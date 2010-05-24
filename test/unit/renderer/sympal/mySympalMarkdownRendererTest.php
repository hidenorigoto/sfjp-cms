<?php
// test/unit/renderer/sympal/mySympalMarkdownRendererTest.php
//  あらかじめパーサー定数を変更しておく
define('MARKDOWN_PARSER_CLASS', 'myMarkdownExtra_Parser');
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

$t = new lime_test(3);

// markdownテスト
$t->diag('markdown機能自体をテスト');
$data = "test";
$t->is(
    mySympalMarkdownRenderer::enhanceHtml(Markdown($data), $data),
    "<p>test</p>\n",
    'markdownレンダリング'
    );

$data = "# test\n## test2";
$t->is(
    mySympalMarkdownRenderer::enhanceHtml(Markdown($data), $data),
    "<h1 id=\"" . md5('test') . "\">test</h1>\n\n<h2 id=\"" . md5('test2') . "\">test2</h2>\n",
    'markdownレンダリング'
    );

$data = <<<EOT
    [php]
    echo "Hello, World!";
EOT;

$t->is(
    mySympalMarkdownRenderer::enhanceHtml(Markdown($data), $data),
"<pre class=\"php\"><span class=\"kw3\">echo</span> <span class=\"st0\">&quot;Hello, World!&quot;</span>;\n&nbsp;</pre>\n",
    'markdownレンダリング(php)'
    );
