<?php
// test/unit/renderer/MarkdownRendererTest.php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

$t = new lime_test(6);

// __construct
$t->diag('__construct');
$t->ok(($obj = new MarkdownRenderer()) instanceof MarkdownRenderer,
    'MarkdownRendererインスタンス化'
    );
$t->ok(($obj = new MarkdownRenderer()) instanceof Renderer,
    'Rendererのサブクラス'
    );

// render()
$t->diag('render()');
$t->is(
    $obj->render(''),
    "\n",
    '空文字列の描画'
    );
$t->is(
    $obj->render('simple text'),
    "<p>simple text</p>\n",
    '単純なコンテンツの描画'
    );
$t->is(
    $obj->render("# h1 test\n\naaaa"),
    "<h1 id=\"" . md5('h1 test') . "\">h1 test</h1>\n\n<p>aaaa</p>\n",
    'markdownのマークアップ。見出しタグには自動でID付与。'
    );
$t->is(
    $obj->render("simple text\nあいうえお日本語"),
    "<p>simple text\nあいうえお日本語</p>\n",
    '日本語の描画'
    );
