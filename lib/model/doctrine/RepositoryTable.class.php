<?php
/**
 * RepositoryTable
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class RepositoryTable extends Doctrine_Table {
    /**
     * RepositoryTable::getInstance()
     *
     * @return
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Repository');
    }
}