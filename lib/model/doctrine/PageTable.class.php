<?php

/**
 * PageTable
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class PageTable extends Doctrine_Table {
    private static $renderers;

    /**
     * PageTable::getInstance()
     *
     * @return PageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Page');
    }

    /**
     * PageTable::getFromPath()
     * パスが一致するページを取得する。
     * リポジトリレコードもJOINする。
     *
     * @param string $path
     * @return Page
     */
    public static function getFromPath($path)
    {
        $query = Doctrine_Query::create()
               ->from('Page p')
               ->leftJoin('p.Repository r')
               ->where('p.path = ?', $path);

        return $query->fetchOne();
    }

    /**
     * PageTable::getListFromPath()
     * パスが前方一致するページの一覧を取得する。
     *
     * @param string $path       取得するページ一覧のパス
     * @param string $sort_key   並べ替えキー  title, commit, create, file, id, first_committed
     * @param string $sort_order 並べ替え順 asc, desc
     * @param integer $limit     取得件数
     * @param bool   $include_subdirectory サブディレクトリも対象とするか？
     * @param string $year       年（初回コミット年月）
     * @param string $month      月（初回コミット年月）
     * @return Doctrine_Collection (Page)
     */
    public static function getListFromPath($path,
        $sort_key = 'commit',
        $sort_order = 'desc',
        $limit = -1,
        $include_subdirectory = true,
        $year = '',
        $month = '')
     {
        //　パスの末尾にスラッシュを付加する
        $path .= (substr($path, -1, 1) !== '/') ? '/' : '';

        $query = Doctrine_Query::create()
               ->from('Page p')
               ;
        if ($include_subdirectory) {
            $query->where('p.path like ?', $path . '%');
        } else {
            $query->where('p.path regexp ?', sprintf('^%s[^/]+$', $path));
        }

        if ($year . $month !== '') {
            $query->addWhere('p.first_committed_ym = ?', (int)($year . $month));
        }

        switch ($sort_order) {
            case 'asc':
            case 'desc':
                //  そのまま
                break;

            default:
                $sort_order = 'desc';
                break;
        }

        switch ($sort_key) {
            case 'file':
                $query->orderBy('p.path ' . $sort_order);
                break;
            case 'title':
                $query->orderBy('p.title ' . $sort_order);
                break;
            case 'create':
                $query->orderBy('p.created_at ' . $sort_order);
                break;
            case 'id':
                $query->orderBy('p.id ' . $sort_order);
                break;
            case 'commit':
                $query->orderBy('p.last_updated ' . $sort_order);
                break;
            case 'first-committed':
            default:
                $query->orderBy('p.first_committed ' . $sort_order);
                break;
        }

        if ($limit > 0) {
            $query->limit($limit);
        }

        return $query->execute();
    }

    /**
     * PageTable::renderContent()
     * タイプに応じたレンダラーでコンテンツをレンダリングする。
     *
     * @param  string $content
     * @param  string $type
     * @return string
     */
    public static function renderContent($content, $type)
    {
        return self::getRenderer($type)
               ->render($content);
    }

    /**
     * PageTable::getRenderer()
     * レンダリングタイプに応じたレンダラーオブジェクトを返す。
     *
     * @param  string   $type
     * @return Renderer
     */
    public static function getRenderer($type)
    {
        // レンダラーキャッシュがあれば、キャッシュから返す。
        if (isset(self::$renderers[$type])) {
            return self::$renderers[$type];
        }
        $renderer = null;
        switch ($type) {
            case 'markdown': // markdownレンダラー
                $renderer = new MarkdownRenderer();
                break;
            case 'html': // HTMLレンダラー
                $renderer = new HtmlRenderer();
                break;
            default:
                $renderer = self::getRenderer($type = 'markdown');
        }
        self::$renderers[$type] = $renderer;

        return $renderer;
    }

    /**
     * PageTable::checkType()
     * ファイル名（拡張子）からタイプを取得する。
     * 　対応したタイプでない場合はfalse
     *
     * @param string $filename
     * @return mixed
     */
    public static function checkType($filename)
    {
        $pathinfo  = pathinfo($filename);
        $entension = (isset($pathinfo['extension']))
                   ? strtolower($pathinfo['extension'])
                   : '';
        switch ($entension) {
            case '': // 拡張子がない場合はmarkdownとみなす
            case 'markdown':
            case 'md':
            case 'mkd':
            case 'mdown':
            case 'mkdn':
                $type = 'markdown';
                break;
            case 'html':
                $type = 'html';
                break;
            default:
                return false;
        }

        return $type;
    }

    /**
     * PageTable::needProcess()
     * 拡張子に応じて、ページ処理が必要かどうかを判定する
     *
     * @param string $filename
     * @return boolean
     */
    public static function needProcess($filename)
    {
        $ret = false;
        if (self::checkType($filename)) {
            $ret = true;
        }

        return $ret;
    }
}