<?php
// test/unit/model/doctrine/CommitTest.php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

// test環境でDB初期化
$configuration = ProjectConfiguration::getApplicationConfiguration('taskapp', 'test', true);
new sfDatabaseManager($configuration);
Doctrine_Core::loadData(dirname(__FILE__).'/CommitFixture.yml');

$t = new lime_test(12);

// construct
$t->diag('__construct()');
$t->ok(
    new Commit() instanceof Commit,
    'Commitインスタンス化'
    );


$page = PageTable::getInstance()->findOneByPath('/foo/bar');

// create
$t->diag('create');
$commit = new Commit();
$commit->setCommittedAt('2010/05/19 01:02:03');
$commit->setAuthorHandle('author_handle');
$commit->setAuthorEmail('author_email');
$commit->setCommitterHandle('committer_handle');
$commit->setCommitterEmail('committer_email');
$commit->setCommitKey('commit_key');
$commit->setPage($page);
$commit->save();

$commit = CommitTable::getInstance()->findOneByCommitKey('commit_key');

$t->ok(
    $commit instanceof Commit,
    'レコードが正しく保存された'
    );
$t->is(
    $commit->getDateTimeObject('committed_at')->format('Y/m/d H:i:s'),
    '2010/05/19 01:02:03',
    'コミット日時の保存'
    );
$t->is(
    $commit->getAuthorHandle(),
    'author_handle',
    '作者ハンドルの保存'
    );
$t->is(
    $commit->getAuthorEmail(),
    'author_email',
    '作者メールアドレスの保存'
    );
$t->is(
    $commit->getCommitterHandle(),
    'committer_handle',
    'コミッターハンドルの保存'
    );
$t->is(
    $commit->getCommitterEmail(),
    'committer_email',
    'コミッターメールアドレスの保存'
    );
$t->is(
    $commit->getCommitKey(),
    'commit_key',
    'コミットキー保存'
    );


// getCommitterGravatarUrl
$t->diag('getCommitterGravatarUrl()');
$t->is(
    $commit->getCommitterGravatarUrl(),
    'http://www.gravatar.com/avatar/'
        . md5($commit->getCommitterEmail())
        . '?s=24',
    'gravatarの画像URL'
    );
$t->is(
    $commit->getCommitterGravatarUrl(32),
    'http://www.gravatar.com/avatar/'
    . md5($commit->getCommitterEmail())
    . '?s=32',
    'gravatarの画像URL(サイズ指定)'
    );
$t->is(
    $commit->getCommitterGravatarUrl(512),
    'http://www.gravatar.com/avatar/'
    . md5($commit->getCommitterEmail()) . '?s=512',
    'gravatarの画像URL(サイズは512まで)'
    );
$t->is(
    $commit->getCommitterGravatarUrl(513),
    'http://www.gravatar.com/avatar/'
    . md5($commit->getCommitterEmail()),
    'gravatarの画像URL(サイズが512より大きい場合は無視)'
    );
