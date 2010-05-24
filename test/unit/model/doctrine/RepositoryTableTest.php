<?php
// test/unit/model/doctrine/RepositoryTableTest.php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';


// test環境でDB初期化
$configuration = ProjectConfiguration::getApplicationConfiguration('taskapp', 'test', true);
new sfDatabaseManager($configuration);
Doctrine_Core::loadData(dirname(__FILE__).'/RepositoryFixture.yml');

$t = new lime_test(4);


// getInstance
$t->ok(
    ($table = RepositoryTable::getInstance()) instanceof RepositoryTable,
    'RepositoryTableインスタンス取得'
    );


// レコード取得
$t->diag('findAll()');
$list = $table->findAll();
$t->is(
    count($list),
    2,
    'レコード全件取得'
    );

// レコード取得
$t->diag('findOne***()');
$commit = $table->findOneByName('testrepo2');
$t->ok(
    $commit instanceof Repository,
    'レコードの取得成功'
    );
$t->is(
    $commit->getRepository(),
    'git://github.com/hidenorigoto/test2.git',
    '取得したレコードのデータが正常'
    );