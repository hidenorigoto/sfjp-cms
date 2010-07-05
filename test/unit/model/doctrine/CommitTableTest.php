<?php
// test/unit/model/doctrine/CommitTableTest.php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

// test環境でDB初期化
$configuration = ProjectConfiguration::getApplicationConfiguration('taskapp', 'test', true);
new sfDatabaseManager($configuration);
Doctrine_Core::loadData(dirname(__FILE__).'/CommitFixture.yml');

$t = new lime_test(12);

// getInstance
$t->diag('getInstance()');
$table = CommitTable::getInstance();
$t->ok(
    $table instanceof CommitTable,
    'テーブルインスタンス取得'
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
$commit = $table->findOneByCommitKey('commit1');
$t->ok(
    $commit instanceof Commit,
    'レコードの取得成功'
    );
$t->is(
    $commit->getCommitterHandle(),
    'hidenori',
    '取得したレコードのデータが正常'
    );

// 最新のコミット
$t->diag('getLatestCommit()');

//  ページを取得しておく
$page = PageTable::getInstance()->findOneByPath('/foo/bar');

$commit = CommitTable::getLatestCommit($page->getId());

$t->ok(
    $commit instanceof Commit,
    'コミットレコード取得成功'
    );
$t->is(
    $commit->getCommitKey(),
    'commit2',
    'コミット日付が新しい方のレコード'
    );

$commit = CommitTable::getLatestCommit(-1);

$t->is(
    $commit,
    null,
    'ページIDに対応するコミットレコードがない場合は、null'
    );



$commit = CommitTable::getFirstCommit($page->getId());

$t->ok(
    $commit instanceof Commit,
    'コミットレコード取得成功'
    );
$t->is(
    $commit->getCommitKey(),
    'commit1',
    'コミット日付が最初のレコード'
    );

$commit = CommitTable::getFirstCommit(-1);

$t->is(
    $commit,
    null,
    'ページIDに対応するコミットレコードがない場合は、null'
    );



// リレーション
$commit = $table->findOneByCommitKey('commit1');
$page   = $commit->getPage();
$t->ok(
    $page instanceof Page,
    'リレーション先のページオブジェクト'
    );

$t->is(
    $page->getPath(),
    '/foo/bar',
    'リレーション先のページオブジェクトが正しい'
    );