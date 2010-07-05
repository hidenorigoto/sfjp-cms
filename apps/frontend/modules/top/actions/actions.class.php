<?php
/**
 * top actions.
 *
 * @package sfjp-cms
 * @subpackage top
 * @author hidenorigoto
 * @version SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class topActions extends sfActions {

    /**
     * topActions::postExecute()
     *
     * @return
     */
    public function postExecute()
    {
        $this->docs_pages = PageTable::getListFromPath('/docs', 'commit', 'desc', 10);
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
        $this->news_pages   = PageTable::getListFromPath('/news', 'first_committed', 'desc', 10);
        $this->events_pages = PageTable::getListFromPath('/events', 'first_committed', 'desc', 10);
        $this->blog_pages   = PageTable::getListFromPath('/blog', 'first_committed', 'desc', 10);
    }
}