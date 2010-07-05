<?php
/**
 * CommitTable
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class CommitTable extends Doctrine_Table {
    /**
     * CommitTable::getInstance()
     *
     * @return CommitTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Commit');
    }

    /**
     * CommitTable::getLatestCommit()
     * 指定したページの最新のコミットレコードを取得する
     *
     * @param 　integer $page_id
     * @return Commit　　コミットオブジェクト
     */
    public static function getLatestCommit($page_id)
    {
        $query = Doctrine_Query::create()
               ->from('Commit c')
               ->where('c.page_id = ?', $page_id)
               ->orderBy('c.committed_at desc') ;

        return $query->fetchOne();
    }

    /**
     * CommitTable::getFirstCommit()
     * 指定したページの最初のコミットレコードを取得する
     *
     * @param  integer $page_id
     * @return Commit  コミットオブジェクト
     */
    public static function getFirstCommit($page_id)
    {
        $query = Doctrine_Query::create()
               ->from('Commit c')
               ->where('c.page_id = ?', $page_id)
               ->orderBy('c.committed_at asc') ;

        return $query->fetchOne();
    }
}