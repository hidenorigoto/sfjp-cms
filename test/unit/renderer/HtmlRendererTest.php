<?php
// test/unit/renderer/HtmlRendererTest.php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

$t = new lime_test(6);

// __construct
$t->diag('__construct');
$t->ok(($obj = new HtmlRenderer()) instanceof HtmlRenderer,
    'HtmlRendererインスタンス化'
    );
$t->ok(($obj = new HtmlRenderer()) instanceof Renderer,
    'Rendererのサブクラス'
    );

// render()
$t->diag('render()');
$t->is(
    $obj->render(''),
    '',
    '空文字列の描画'
    );
$t->is(
    $obj->render('simple text'),
    'simple text',
    '単純なコンテンツの描画'
    );
$t->is(
    $obj->render("<h1>simple text</h1>"),
    '<h1>simple text</h1>',
    'タグ付コンテンツの描画（そのまま出力）'
    );
$t->is(
    $obj->render("<h1>simple text</h1>\n<a href=\"test\">foobar</a>"),
    "<h1>simple text</h1>\n<a href=\"test\">foobar</a>",
    'タグ付コンテンツの描画2（改行などもそのまま出力）'
    );
