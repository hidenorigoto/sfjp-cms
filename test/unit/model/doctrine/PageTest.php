<?php
// test/unit/model/doctrine/PageTest.php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

require_once($_test_dir.'/../lib/vendor/symfony/test/unit/sfContextMock.class.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/UrlHelper.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/AssetHelper.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/TagHelper.php');

class myController
{
    public function genUrl($parameters = array(), $absolute = false)
    {
        if (preg_match('|^(\/)|i', $parameters)) {
            return $parameters;
        }
        $url = is_array($parameters) && isset($parameters['sf_route']) ? $parameters['sf_route'] : '/module/action';
        return ($absolute ? '/' : '').$url;
    }
}

class myRequest
{
    public function getRelativeUrlRoot()
    {
        return '/public';
    }

    public function isSecure()
    {
        return true;
    }

    public function getHost()
    {
        return 'example.org';
    }
}

class BaseForm extends sfForm
{
    public function getCSRFToken($secret = null)
    {
        return '==TOKEN==';
    }
}

sfForm::enableCSRFProtection();

$context = sfContext::getInstance(array('controller' => 'myController', 'request' => 'myRequest'));


// test環境でDB初期化
$configuration = ProjectConfiguration::getApplicationConfiguration('taskapp', 'test', true);
new sfDatabaseManager($configuration);
Doctrine_Core::loadData(dirname(__FILE__).'/PageFixture.yml');






$t = new lime_test(31);


// construct
$t->diag('__construct()');
$t->ok(
    new Page() instanceof Page,
    'Pageインスタンス化'
    );

// create
$t->diag('create');

$repo = RepositoryTable::getInstance()->findOneByName('testrepo');

$page = new Page();
$page->setRepository($repo);
$page->setPath('/path/to');
$page->setContentRaw('content_raw');
$page->setContentType('content_type');
$page->setContentRendered('content_rendered');
$page->setTitle('title');
$page->setIndexJson('index_json');
$page->setLastUpdated('2010/01/02 03:04:05');
$page->save();

$page = PageTable::getInstance()->findOneByPath('/path/to');

$t->ok(
    $page instanceof Page,
    'レコードが正しく保存された'
    );

$t->is(
    $page->getPath(),
    '/path/to',
    'パスの保存'
    );
$t->is(
    $page->getContentRaw(),
    'content_raw',
    'コンテンツの保存'
    );
$t->is(
    $page->getContentRendered(),
    'content_rendered',
    '描画済コンテンツの保存'
    );
$t->is(
    $page->getContentType(),
    'content_type',
    'コンテンツ種別の保存'
    );
$t->is(
    $page->getTitle(),
    'title',
    'タイトルの保存'
    );
$t->is(
    $page->getIndexJson(),
    'index_json',
    'インデックスの保存'
    );
$t->is(
    $page->getDateTimeObject('last_updated')->format('Y/m/d H:i:s'),
    '2010/01/02 03:04:05',
    '更新日時の保存'
    );


// render
$t->diag('render()');
$t->is(
    $page->render(),
    'content_rendered',
    '単純render'
    );

$page->setContentRendered('<img src="images/img.png">');
$t->is(
    $page->render(),
    '<img src="/public/r/images/foo/images/img.png">',
    '画像相対パスの自動変換'
    );
$t->is(
    $page->render(),
    '<img src="/public/r/images/foo/images/img.png">',
    '画像相対パスの自動変換（複数回実行）'
    );


// adjustRelativeImagePath()
$t->diag('adjustRelativeImagePath()');
$t->is(
    $page->adjustRelativeImagePath('testtest<img src="images/img.png">testimg'),
    'testtest<img src="/public/r/images/foo/images/img.png">testimg',
    '画像相対パスの補正'
    );
$t->is(
    $page->adjustRelativeImagePath('testtest<img src="/images/img.png">testimg'),
    'testtest<img src="/images/img.png">testimg',
    '画像絶対パスは無視される'
    );
$t->is(
    $page->adjustRelativeImagePath('testtest<img src="http://host/images/img.png">testimg'),
    'testtest<img src="http://host/images/img.png">testimg',
    '画像URL(http)は無視される'
    );
$t->is(
    $page->adjustRelativeImagePath('testtest<img src="https://host/images/img.png">testimg'),
    'testtest<img src="https://host/images/img.png">testimg',
    '画像URL(https)は無視される'
    );
$t->is(
    $page->adjustRelativeImagePath('<img alt="test" src="images/img.png">'),
    '<img alt="test" src="/public/r/images/foo/images/img.png">',
    'タグ内の属性の位置に依存しない'
    );


// getCommitters
$t->diag('getCommitters()');
$page = PageTable::getInstance()->findOneByPath('/foo/bar');  // page1
$committers = $page->getCommitters();
$t->ok(
    $committers instanceof Doctrine_Collection,
    'Doctrine_Collectionが返る'
    );
$t->is(
    count($committers),
    2,
    'コミッター一覧の取得件数'
    );
$keys = $committers->getKeys();
$t->ok(
    preg_match('/^[^@]+@[^@]+$/i', $keys[0]),
    'メールアドレスがキーになっている'
    );


// getCommits
$t->diag('getCommits()');
$commits = $page->getCommits();
$t->ok(
    $commits instanceof Doctrine_Collection,
    'Doctrine_Collectionが返る'
    );
$t->is(
    count($commits),
    3,
    'コミット一覧の取得件数'
    );


// getIndexJsonDecoded
$t->diag('getIndexJsonDecoded()');
$decoded = $page->getIndexJsonDecoded();
$t->ok(
    $decoded instanceof stdClass,
    'json_decodeの結果オブジェクトが返される'
    );
$t->is(
    $decoded->test,
    'testtext',
    '保存したデータが正しく復元される'
    );


// getGithubRepositoryUrl
$t->diag('getGithubRepositoryUrl()');
$t->is(
    $page->getGithubRepositoryUrl(),
    'http://github.com/hidenorigoto/test',
    'このページが所属するリポジトリのURLを取得する。'
    );



// getGithubUrl
$t->diag('getGithubUrl()');
$t->is(
    $page->getGithubUrl(),
    'http://github.com/hidenorigoto/test/blob/master/bar.markdown',
    'このページのgithub上のURLを取得する。'
    );

$page2 = PageTable::getInstance()->findOneByPath('/foo/bar2');
$t->is(
    $page2->getGithubUrl(),
    'http://github.com/hidenorigoto/test/blob/master/bar2.html',
    'このページのgithub上のURLを取得する。（ファイル名、タイプ加味）'
    );


// getGithubHistoryUrl
$t->diag('getGithubHistoryUrl()');
$t->is(
    $page->getGithubHistoryUrl(),
    'http://github.com/hidenorigoto/test/commits/master/bar.markdown',
    'このページのgithub上のコミット履歴のURLを取得する。'
    );

// getFormattedFirstCommitted
$page = PageTable::getInstance()->findOneByPath('/foo/bar');  // page1
$t->diag('getFormattedFirstCommitted()');
$t->is(
    $page->getFormattedFirstCommitted(),
    '2010/05/09',
    'ページの、フォーマット済初回コミット日付'
    );


$page = new Page();
$page->setRepository($repo);
$page->setPath('/path/to2');
$page->setContentRaw('content_raw');
$page->setContentType('content_type');
$page->setContentRendered('content_rendered');
$page->setTitle('title');
$page->setIndexJson('index_json');
$page->setLastUpdated('2010/01/02 03:04:05');
$page->save();

$page = PageTable::getInstance()->findOneByPath('/path/to2');  // page1
$t->diag('getFormattedFirstCommitted()');
$t->is(
    $page->getFormattedFirstCommitted(),
    '',
    'ページの、フォーマット済初回コミット日付 値未設定'
    );

$page->setFirstCommitted(0);
$page->save();

$page = PageTable::getInstance()->findOneByPath('/path/to2');  // page1
$t->diag('getFormattedFirstCommitted()');
$t->is(
    $page->getFormattedFirstCommitted(),
    '',
    'ページの、フォーマット済初回コミット日付 値0'
    );
