<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addcommit extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('commit', array(
             'id' => 
             array(
              'primary' => true,
              'unsigned' => true,
              'type' => 'integer',
              'autoincrement' => true,
              'length' => 8,
             ),
             'committed_at' => 
             array(
              'type' => 'timestamp',
              'length' => 25,
             ),
             'author_handle' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'author_email' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'committer_handle' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'committer_email' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'commit_key' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'commit_url' => 
             array(
              'type' => 'string',
              'length' => 512,
             ),
             'page_id' => 
             array(
              'unsigned' => true,
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             ), array(
             'indexes' => 
             array(
              'IX_Commit_1' => 
              array(
              'fields' => 
              array(
               0 => 'commit_key',
               1 => 'page_id',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('commit');
    }
}