<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addpage extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('page', array(
             'id' => 
             array(
              'primary' => true,
              'unsigned' => true,
              'type' => 'integer',
              'autoincrement' => true,
              'length' => 8,
             ),
             'repository_id' => 
             array(
              'unsigned' => true,
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'path' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'content_raw' => 
             array(
              'type' => 'clob',
              'length' => NULL,
             ),
             'content_type' => 
             array(
              'type' => 'string',
              'length' => 32,
             ),
             'content_rendered' => 
             array(
              'type' => 'clob',
              'length' => NULL,
             ),
             'title' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'index_json' => 
             array(
              'type' => 'string',
              'length' => NULL,
             ),
             'last_updated' => 
             array(
              'type' => 'timestamp',
              'length' => 25,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' => 
             array(
              'IX_Page_1' => 
              array(
              'fields' => 
              array(
               0 => 'path',
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
        $this->dropTable('page');
    }
}