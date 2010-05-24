<?php
/**
 * myVersionControl_Git
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class myVersionControl_Git extends VersionControl_Git {
    /**
     * myVersionControl_Git::getRevListFetcher()
     *
     * @return
     */
    public function getRevListFetcher()
    {
        return new myVersionControl_Git_Util_RevListFetcher($this);
    }

    /**
     * myVersionControl_Git::getCommits()
     *
     * @param string $object
     * @param string $arg
     * @param integer $maxResults
     * @param integer $offset
     * @return
     */
    public function getCommits($object = 'master', $arg = '', $maxResults = 100, $offset = 0)
    {
        return $this->getRevListFetcher()
                     ->target((string)$object)
                     ->setFilter($arg)
                     ->addDoubleDash(true)
                     ->setOption('max-count', $maxResults)
                     ->setOption('skip', $offset)
                     ->fetch();
    }
}