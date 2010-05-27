<?php

/**
 * page actions.
 *
 * @package prj
 * @subpackage page
 * @author Your name here
 * @version SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pageActions extends sfActions {
    /**
     * pageActions::postExecute()
     *
     * @return
     */
    public function postExecute()
    {
        $this->docs_pages = PageTable::getListFromPath('/docs', 'commit', 'desc', 5);
        $this->banner     = PageTable::getFromPath('/banner');
        $this->release    = PageTable::getFromPath('/release');
    }

    /**
     * pageActions::executePage()
     *
     * @param sfWebRequest $request
     * @return
     */
    public function executePage(sfWebRequest $request)
    {
        // リクエストされたパスを取得する。
        $path = strtolower($request->getPathInfo());

        //  末尾がスラッシュなら、インデックスへ
        if (substr($path, -1, 1) === '/') {
            $this->forward('page', 'page_index');
        }

        // パスに対応するページを取得する。
        $page = PageTable::getFromPath($path);

        // 対応するページがなければトップへ
        $this->redirectUnless($page, 'top/index');

        // ページのコミッターリストを取得する。
        $this->committers = $page->getCommitters();

        // ページのコミットリストを取得する。
        $this->commits = $page->getCommits();

        //  ページの属するディレクトリ内のコンテンツ一覧を取得する。
        $dir_path = preg_replace('/^(.*?)[^\/]+$/i', '$1', $path);
        $this->dir_pages = PageTable::getListFromPath($dir_path, 'file', 'asc', -1, false);

        // このページのタイトルを設定する。
        $this->getResponse()->setTitle($page->getTitle() . ' | 日本Symfonyユーザー会');

        $this->page = $page;
    }

    /**
     * pageActions::executePage_index()
     *
     * @param sfWebRequest $request
     * @return
     */
    public function executePage_index(sfWebRequest $request)
    {
        // リクエストされたパスを取得する。
        $path = strtolower($request->getPathInfo());

        //  並べ替えパラメータを取得する。
        $sort_key   = $request->getParameter('sk', 'title');
        $sort_order = $request->getParameter('so', 'asc');

        // パスにマッチするページ一覧を取得する。
        $pages = PageTable::getListFromPath($path, $sort_key, $sort_order);
        $this->path  = $path;
        $this->pages = $pages;
    }
}