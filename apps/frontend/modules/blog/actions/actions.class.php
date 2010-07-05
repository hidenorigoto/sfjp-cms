<?php

/**
 * blog actions.
 *
 * @package    sfjp-cms
 * @subpackage blog
 * @author     hidenorigoto
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class blogActions extends sfActions
{
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
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      // リクエストされたパスを取得する。
      $path  = strtolower($request->getPathInfo());
      $year  = $request->getParameter('year', '');
      $month = $request->getParameter('month', '');
      $page_type = $request->getParameter('page_type', '');
      $path  = str_replace(sprintf('%s/%s/', $year, $month), '', $path);

      //  並べ替えパラメータを設定する。
      $sort_key   = 'first_committed';
      $sort_order = 'desc';

      // パスと条件にマッチするページ一覧を取得する。
      $pages = PageTable::getListFromPath($path, $sort_key, $sort_order, -1, true, $year, $month);

      // パスにマッチするページ一覧（全部）を取得する。
      $pages_temp = PageTable::getListFromPath($path, $sort_key, $sort_order);

      // ページの一覧から年月インデックス配列を作成する。
      $ym_index = array();
      foreach ($pages_temp as $page) {
          $ym = $page->getDateTimeObject('first_committed')->format('Ym');
          if (isset($ym_index[$ym])) {
              ++$ym_index[$ym]['count'];
          } else {
              $ym_index[$ym]['count'] = 1;
              $ym_index[$ym]['year']  = substr($ym, 0, 4);
              $ym_index[$ym]['month'] = substr($ym, -2, 2);
          }
      }


      $this->path  = $path;
      $this->pages = $pages;
      $this->ym_index = $ym_index;
      switch ($page_type) {
          case 'events':
              $title = 'イベント';
              break;

          case 'news':
              $title = 'ニュース';
              break;

          case 'blog':
          default:
              $title = 'ブログ';
              break;
      }
      $this->page_type  = $page_type;
      $this->page_title = $title;
  }
}
