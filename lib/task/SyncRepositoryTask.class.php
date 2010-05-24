<?php
require_once "Mail/RFC822.php";

/**
 * SyncRepositoryTask
 *
 * @package
 * @author goto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class SyncRepositoryTask extends sfBaseTask {
    /**
     * SyncRepositoryTask::configure()
     *
     * @return
     */
    protected function configure()
    {
        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'taskapp'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));
        $this->namespace           = 'sfjp';
        $this->name                = 'sync-repository';
        $this->briefDescription    = 'リポジトリの同期フラグに従って、同期処理を行う。';
        $this->detailedDescription = <<<EOF
The [SyncRepository|INFO] task does things.
Call it with:

  [php symfony SyncRepository|INFO]
EOF;
    }

    /**
     * SyncRepositoryTask::execute()
     *
     * @param array $arguments
     * @param array $options
     * @return
     */
    protected function execute($arguments = array(), $options = array())
    {
        // ログファイルの設定
        $file_logger = new sfFileLogger($this->dispatcher, array(
                'file' => ($this->configuration->getRootDir()
                       . '/log/'
                       . $this->getName()
                       . '.log')
        ));
        $this->dispatcher->connect('application.log', array($file_logger, 'listenToLogEvent'));

        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection      = $databaseManager->getDatabase($options['connection'])->getConnection();

        // 更新フラグのあるリポジトリの最初の1件を取得する。
        $repository = RepositoryTable::getInstance()
                    ->findOneByForceUpdate(1);
        if (!$repository) {
            return false;
        }

        // 更新フラグを消しておく。
        $repository->setForceUpdate(0);
        $repository->save();

        // リポジトリを同期する。
        $this->log(sprintf('リポジトリ %s の同期を開始します', $repository->getRepositoryName()));

        // リポジトリキャッシュルートディレクトリ
        $cache_root = sfConfig::get('sf_root_dir') . '/data/repos/';
        $dir_root   = $cache_root . $repository->getCacheKey();
        $do_clone   = false;

        if ($repository->getForceClone()) {
            // 一旦このディレクトリ配下をすべて削除する
            sfToolkit::clearDirectory($dir_root_repo);

            // 強制clone
            $do_clone = true;
        } else if (!is_dir($dir_root)) {
            // ディレクトリがない。
            mkdir($dir_root, 0777, true);

            // このディレクトリ配下にcloneを取得する。
            $do_clone = true;
        }else {
            // リポジトリは取得済か？
            $dir_root_repo = $dir_root . DIRECTORY_SEPARATOR . $repository->getRepositoryName();

            try {
                $git = new myVersionControl_Git($dir_root_repo);
                $git->setGitCommandPath('git');
                $git->getCommits('master', 1);

                // pullする。
                $this->log('リポジトリをpullしています');
                $git->getCommand('pull')->execute();
            }
            catch (Exception $e) {
                // 一旦このディレクトリ配下をすべて削除する
                sfToolkit::clearDirectory($dir_root_repo);

                // cloneする
                $do_clone = true;
            }
        }

        if ($do_clone) {
            $this->log('リポジトリをcloneしています');
            $git = new myVersionControl_Git($dir_root);
            $git->setGitCommandPath('git');
            $git->createClone($repository->getRepository());
        }

        // このリポジトリの対象ファイルリストを取得する。
        $files = sfFinder::type('file')
               ->prune('.git')
               ->discard('.git')
               ->relative()
               ->in($search_dir = $dir_root
                                . DIRECTORY_SEPARATOR
                                . $repository->getRepositoryName()
                                . $repository->getSubdirectory()
                    );
        $page_path_root = $repository->getBindPath();

        // ---------------------------------------------
        // ファイル別に処理
        foreach ($files as $file) {
            $this->log(sprintf('ファイル：%s', $file));
            $info      = pathinfo($file);
            $file_path = $search_dir . DIRECTORY_SEPARATOR . $file;

            //  このファイルが対象かどうかチェックする。
            if (!PageTable::needProcess($file)) {
                $this->log('ページ取り込み対象外');

                // 画像データなら、パブリックディレクトリにコピーする。
                if (preg_match('/^(png|jpg|gif)$/', $info['extension'])) {
                    $target_path = $repository->getImagePublicPath($file);
                    $target_dir  = dirname($target_path);
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    $this->log('ファイルをパブリックディレクトリにコピーします。');
                    copy($file_path, $target_path);
                    chmod($target_path, 0666);
                }
                continue;
            }

            //  各ページに対応するURLパスを求める。
            if ('.' !== $info['dirname']) {
                $page_path = strtolower(
                                $page_path_root
                                . '/'
                                . $info['dirname']
                                . '/'
                                . $info['filename']
                             );
            } else {
                $page_path = strtolower(
                                $page_path_root
                                . '/'
                                . $info['filename']
                             );
            }

            // ページに対応するレコードを取得する。
            $page = Doctrine_Core::getTable('Page')
                        ->findOneByPath($page_path);

            if (!$page) {
                $page = new Page();
                $page->setPath($page_path);
                $page->setRepository($repository);
            }

            echo $file;

            // ページごとにコミット履歴を取得する。
            $commits = $git->getCommits('master', $file_path);
            $new_commit_found = false;
            foreach ($commits as $commit) {
                // 既存ページの場合はコミットがすでに取り込み済かチェックする。
                $commit_record = null;
                if (!$page->isNew()) {
                    $commit_record = Doctrine_Core::getTable('Commit')
                        ->findOneByCommitKeyAndPageId(
                                $commit->__toString(),
                                $page->getId()
                          );
                }
                if (!$commit_record) {
                    // コミットを登録する。
                    $new_commit_found = true;
                    $this->log(sprintf('コミット %s を取得しています', $commit));
                    $commit_record = new Commit();
                    $commit_record->setAuthorHandle(
                                        $commit->getAuthorHandle()
                                    );
                    $commit_record->setAuthorEmail(
                                        $commit->getAuthorEmail()
                                    );
                    $commit_record->setCommitterHandle(
                                        $commit->getCommitterHandle()
                                    );
                    $commit_record->setCommitterEmail(
                                        $commit->getCommitterEmail()
                                    );
                    $commit_record->setCommittedAt(
                                        date(
                                            'Y/m/d H:i:s',
                                            $commit->getCommittedAt()
                                        )
                                    );
                    $commit_record->setCommitKey($commit);
                    $commit_record->setPage($page);
                    $commit_record->save();
                }
            }

            //  新規のコミットが無い場合は、処理をスキップする。
            if (!$new_commit_found) {
                continue;
            }

            $page->setContentType($type = PageTable::checkType($file));
            $content = file_get_contents($file_path);
            if ('UTF-8' !== ($encoding = mb_detect_encoding($content))) {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
            }
            $page->setContentRaw($content);

            // ページのレンダリングモードに合わせてレンダリングする。
            $page->setContentRendered(
                $rendered = PageTable::renderContent($content, $type)
            );

            // DOMパース用に、特殊文字を置換する。
            $html = mb_convert_encoding(
                        $rendered,
                        'HTML-ENTITIES',
                        'ASCII, JIS, UTF-8, EUC-JP, SJIS'
                     );

            // レンダリング結果をパースする。
            $dom = new DomDocument();
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // タイトルを探す。
            $domElements = $xpath->query('//title | //h1');
            if (count($domElements)) {
                $page->setTitle($domElements->item(0)->nodeValue);
            }

            // 見出しをパースする
            $domElements = $xpath->query('//h1 | //h2 | //h3');
            $indexes = array();
            $now_h1  = array();
            $now_h2  = array();
            foreach ($domElements as $domElement) {
                switch ($domElement->nodeName) {
                    case 'h1':
                        $indexes[] = array(
                                        'type' => 'h1',
                                        'text' => $domElement->nodeValue,
                                        'id' => $domElement->getAttribute('id'),
                                        'children' => array()
                                     );
                        $now_h1 = &$indexes[count($indexes) - 1]['children'];
                        break;
                    case 'h2':
                        $now_h1[] = array(
                                        'type' => 'h2',
                                        'text' => $domElement->nodeValue,
                                        'id' => $domElement->getAttribute('id'),
                                        'children' => array()
                                    );
                        $now_h2   = &$now_h1[count($now_h1) - 1]['children'];
                        break;
                    case 'h3':
                        $now_h2[] = array(
                                        'type' => 'h3',
                                        'text' => $domElement->nodeValue,
                                        'id' => $domElement->getAttribute('id'),
                                        'children' => array()
                                    );
                        break;
                    default:
                        break;
                }
            }

            $page->setIndexJson(json_encode($indexes));

            // 保存する。
            $page->save();

            // ページの最終コミット日時を更新する。
            $commit = CommitTable::getLatestCommit($page->getId());
            $page->setLastUpdated($commit->getCommittedAt());
            $page->save();
        }

        $this->log(sprintf(
                    'リポジトリ %s の同期が完了しました',
                    $repository->getRepositoryName()
               ));
    }
}