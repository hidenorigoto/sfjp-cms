<?php
// test/unit/model/doctrine/PageTableTest.php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

// test環境でDB初期化
$configuration = ProjectConfiguration::getApplicationConfiguration('taskapp', 'test', true);
new sfDatabaseManager($configuration);
Doctrine_Core::loadData(dirname(__FILE__).'/PageFixture.yml');

$t = new lime_test(60);

// getInstance
$t->diag('getInstance()');
$table = PageTable::getInstance();
$t->ok(
    $table instanceof PageTable,
    'テーブルインスタンス取得'
    );

// レコード取得
$t->diag('findAll()');
$list = $table->findAll();
$t->is(
    count($list),
    4,
    'レコード全件取得'
    );

// レコード取得
$t->diag('findOne***()');
$page = $table->findOneByPath('/foo/bar');
$t->ok(
    $page instanceof Page,
    'レコードの取得成功'
    );
$t->is(
    $page->getTitle(),
    'testtitle',
    '取得したレコードのデータが正常'
    );


// getFromPath
$t->diag('getFromPath()');
$page = PageTable::getFromPath('/foo/bar');
$t->is(
    $page->getTitle(),
    'testtitle',
    '取得したレコードのデータが正常'
    );
$t->is(
    $page->getRepository()->getName(),
    'testrepo',
    'リレーション先も正しく取得'
    );


// getListFromPath()
$t->diag('getListFromPath()');
$page_rec = PageTable::getListFromPath('/foo/');

// 最終更新日時を更新しておく。
foreach ($page_rec as $pagetemp) {
    $commit = CommitTable::getLatestCommit($pagetemp->getId());
    $pagetemp->setLastUpdated($commit->getCommittedAt());
    $pagetemp->save();
}

$t->ok(
    $page_rec instanceof Doctrine_Collection,
    '戻り値はDoctrine_Collection'
    );
$t->is(
    count($page_rec),
    4,
    'レコードの件数が正しい'
    );
$page_rec = PageTable::getListFromPath('/foo/baｒ');
$t->is(
    count($page_rec),
    0,
    '末尾にスラッシュを付加してマッチ'
    );
$page_rec = PageTable::getListFromPath('/foo');
$t->is(
    count($page_rec),
    4,
    '末尾にスラッシュを付加してマッチ'
    );
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getTitle() === 'testtitle2') &&
    ($page2->getTitle() === 'testtitle3') &&
    ($page3->getTitle() === 'testtitle'),
    '取得したレコードの順序(デフォルト：最終更新日時の降順)'
    );

$page_rec = PageTable::getListFromPath('/foo', 'title', 'asc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getTitle() === 'testtitle') &&
    ($page2->getTitle() === 'testtitle2') &&
    ($page3->getTitle() === 'testtitle3'),
    '取得したレコードの順序(タイトルの昇順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'title', 'desc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getTitle() === 'testtitle4') &&
    ($page2->getTitle() === 'testtitle3') &&
    ($page3->getTitle() === 'testtitle2'),
    '取得したレコードの順序(タイトルの降順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'file', 'asc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/bar') &&
    ($page2->getPath() === '/foo/bar2') &&
    ($page3->getPath() === '/foo/baz'),
    '取得したレコードの順序(ファイル名の昇順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'file', 'desc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/baz/test') &&
    ($page2->getPath() === '/foo/baz') &&
    ($page3->getPath() === '/foo/bar2'),
    '取得したレコードの順序(ファイル名の降順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'commit', 'asc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
foreach ($page_rec as $pagetemp) {
    $pagetemp->getLastUpdated();
}
$t->ok(
    ($page1->getPath() === '/foo/baz/test') &&
    ($page2->getPath() === '/foo/bar') &&
    ($page3->getPath() === '/foo/baz'),
    '取得したレコードの順序(最終コミット日時の昇順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'commit', 'desc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/bar2') &&
    ($page2->getPath() === '/foo/baz') &&
    ($page3->getPath() === '/foo/bar'),
    '取得したレコードの順序(最終コミット日時の降順)'
    );


$page_rec = PageTable::getListFromPath('/foo', 'id', 'asc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/bar') &&
    ($page2->getPath() === '/foo/bar2') &&
    ($page3->getPath() === '/foo/baz'),
    '取得したレコードの順序(IDの昇順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'id', 'desc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/baz/test') &&
    ($page2->getPath() === '/foo/baz') &&
    ($page3->getPath() === '/foo/bar2'),
    '取得したレコードの順序(IDの降順)'
    );

$page = PageTable::getFromPath('/foo/bar');
$page->setCreatedAt('2010-01-01 01:02:03');
$page->save();

$page = PageTable::getFromPath('/foo/bar2');
$page->setCreatedAt('2010-01-01 01:02:04');
$page->save();

$page = PageTable::getFromPath('/foo/baz');
$page->setCreatedAt('2010-01-01 01:02:05');
$page->save();

$page = PageTable::getFromPath('/foo/baz/test');
$page->setCreatedAt('2010-01-01 01:02:06');
$page->save();


$page_rec = PageTable::getListFromPath('/foo', 'create', 'asc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/bar') &&
    ($page2->getPath() === '/foo/bar2') &&
    ($page3->getPath() === '/foo/baz'),
    '取得したレコードの順序(レコード作成日時の昇順)'
    );
$page_rec = PageTable::getListFromPath('/foo', 'create', 'desc');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getPath() === '/foo/baz/test') &&
    ($page2->getPath() === '/foo/baz') &&
    ($page3->getPath() === '/foo/bar2'),
    '取得したレコードの順序(レコード作成日時の降順)'
    );



$page_rec = PageTable::getListFromPath('/foo', 'com;mit');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getTitle() === 'testtitle2') &&
    ($page2->getTitle() === 'testtitle3') &&
    ($page3->getTitle() === 'testtitle'),
    '取得したレコードの順序(キーに不正文字を指定した場合はデフォルトのcommitになる))'
    );

$page_rec = PageTable::getListFromPath('/foo', 'com;mit', '; select *');
$page1 = $page_rec[0];
$page2 = $page_rec[1];
$page3 = $page_rec[2];
$t->ok(
    ($page1->getTitle() === 'testtitle2') &&
    ($page2->getTitle() === 'testtitle3') &&
    ($page3->getTitle() === 'testtitle'),
    '取得したレコードの順序(並べ替えに不正文字を指定した場合はデフォルトのdescになる))'
    );
$page_rec = PageTable::getListFromPath('/foo', '', '', 2);
$t->is(
    count($page_rec),
    2,
    '取得件数の指定'
    );


$page_rec = PageTable::getListFromPath('/foo/', '', '', -1, false);
$t->is(
    count($page_rec),
    3,
    'サブディレクトリ除外'
    );

$page_rec = PageTable::getListFromPath('/foo', '', '', -1, true);
$t->is(
    count($page_rec),
    4,
    'サブディレクトリ含む'
    );

$page_rec = PageTable::getListFromPath('/foo', '', '', -1, true, '2000');
$t->is(
    count($page_rec),
    0,
    '年のみ指定（該当レコードなし）'
    );

$page_rec = PageTable::getListFromPath('/foo', '', '', -1, true, '', '05');
$t->is(
    count($page_rec),
    0,
    '月のみ指定（該当レコードなし）'
    );
$page_rec = PageTable::getListFromPath('/foo', '', '', -1, true, '2010', '05');
$t->is(
    count($page_rec),
    4,
    '年月指定'
    );
$page_rec = PageTable::getListFromPath('/foo', '', '', -1, true, '2010', '06');
$t->is(
    count($page_rec),
    0,
    '年月指定'
    );




// renderContent()
$t->diag('renderContent()');
$markdown = <<<EOF
test
====
foo bar
EOF;
$t->is(
    PageTable::renderContent($markdown, 'markdown'),
    "<h1 id=\"" . md5('test') . "\">test</h1>\n\n<p>foo bar</p>\n",
    'markdownレンダリング'
    );
$t->is(
    PageTable::renderContent("<h1>test</h1>\n\n<p>foo bar</p>\n", 'html'),
    "<h1>test</h1>\n\n<p>foo bar</p>\n",
    'HTMLレンダリング'
    );


// getRenderer()
$t->diag('getRenderer()');
$t->ok(
    PageTable::getRenderer('markdown') instanceof MarkdownRenderer,
    'レンダラーの取得(Markdown)'
    );
$t->ok(
    PageTable::getRenderer('markdown') instanceof MarkdownRenderer,
    'レンダラーの取得(Markdown) 複数回実行（キャッシュのテスト）'
    );
$t->ok(
    PageTable::getRenderer('html') instanceof HtmlRenderer,
    'レンダラーの取得(HTML)'
    );
$t->ok(
    PageTable::getRenderer('') instanceof MarkdownRenderer,
    'レンダラーの取得(デフォルト＝Markdown)'
    );


// checkType()
$t->diag('checkType()');
$t->is(
    PageTable::checkType('test.markdown'),
    'markdown',
    'タイプ：マークダウン'
    );
$t->is(
    PageTable::checkType('test.md'),
    'markdown',
    'タイプ：マークダウン'
    );
$t->is(
    PageTable::checkType('test.mkd'),
    'markdown',
    'タイプ：マークダウン'
    );
$t->is(
    PageTable::checkType('test.mdown'),
    'markdown',
    'タイプ：マークダウン'
    );
$t->is(
    PageTable::checkType('test.mkdn'),
    'markdown',
    'タイプ：マークダウン'
    );
$t->is(
    PageTable::checkType('test.html'),
    'html',
    'タイプ：HTML'
    );
$t->is(
    PageTable::checkType('test'),
    'markdown',
    'タイプ：空の場合はマークダウン'
    );
$t->is(
    PageTable::checkType('test.txt'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.xml'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.gif'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.jpg'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.png'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.js'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.css'),
    false,
    '未対応タイプ'
    );
$t->is(
    PageTable::checkType('test.php'),
    false,
    '未対応タイプ'
    );



// needProcess()
$t->diag('needProcess()');
$t->is(
    PageTable::needProcess('test.markdown'),
    true,
    'markdown　要'
    );
$t->is(
    PageTable::needProcess('test.html'),
    true,
    'html　要'
    );
$t->is(
    PageTable::needProcess('test'),
    true,
    '拡張子なし 要'
    );
$t->is(
    PageTable::needProcess('test.png'),
    false,
    'png 不要'
    );
$t->is(
    PageTable::needProcess('test.jpg'),
    false,
    'jpg 不要'
    );
$t->is(
    PageTable::needProcess('test.gif'),
    false,
    'gif 不要'
    );
$t->is(
    PageTable::needProcess('test.js'),
    false,
    'js 不要'
    );
$t->is(
    PageTable::needProcess('test.css'),
    false,
    'css 不要'
    );
$t->is(
    PageTable::needProcess('test.php'),
    false,
    'php 不要'
    );

