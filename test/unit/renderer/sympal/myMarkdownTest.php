<?php
// test/unit/renderer/sympal/myMarkdownTest.php
//  あらかじめパーサー定数を変更しておく
define('MARKDOWN_PARSER_CLASS', 'myMarkdownExtra_Parser');
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

$t = new lime_test(5);

// construct
$t->diag('construct');
$t->ok(
    new myMarkdownExtra_Parser() instanceof myMarkdownExtra_Parser,
    'myMarkdownExtra_Parserインスタンス化'
    );
$t->ok(
    new myMarkdownExtra_Parser() instanceof MarkdownExtra_Parser,
    'MarkdownExtra_Parserのサブクラス'
    );


// markdownテスト
$t->diag('markdown機能自体をテスト');
$t->is(
    Markdown('test'),
    "<p>test</p>\n",
    'markdownレンダリング'
    );

$t->is(
    Markdown('# test'),
    "<h1 id=\"" . md5('test') . "\">test</h1>\n",
    '見出しに自動的にid付与'
    );

$t->is(
    Markdown("# test\n## test2"),
    "<h1 id=\"" . md5('test') . "\">test</h1>\n\n<h2 id=\"" . md5('test2') . "\">test2</h2>\n",
    '見出しに自動的にid付与'
    );
