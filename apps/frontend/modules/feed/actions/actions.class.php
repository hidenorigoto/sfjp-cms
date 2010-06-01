<?php

/**
 * feed actions.
 *
 * @package prj
 * @subpackage feed
 * @author Your name here
 * @version SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class feedActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->getContext()->getConfiguration()->loadHelpers(array('Url'));

        $feed = new sfAtom1Feed();

        $feed->setTitle('日本Symfonyユーザー会 コンテンツ更新情報');
        $feed->setLink($this->getController()->genUrl('@homepage'));
        $feed->setAuthorEmail('info@symfony.gr.jp');
        $feed->setAuthorName('日本Symfonyユーザー会');

        $feedImage = new sfFeedImage();
        $feedImage->setFavicon(public_path('images/favicon.ico'));

        $pages = Doctrine_Query::create()
            ->from('Page p')
            ->limit(10)
            ->orderBy('p.last_updated desc')
            ->execute();

        foreach ($pages as $page) {
            $item = new sfFeedItem();
            $item->setTitle($page->getTitle());
            $item->setLink(url_for_page($page->getPath()));
            $item->setPubdate($page->getDateTimeObject('last_updated')->format('U'));
            $item->setDescription(strip_tags($page->getContentRendered()));
            $item->setContent($page->getContentRendered());

            $feed->addItem($item);
        }

        $this->feed = $feed;
    }
}