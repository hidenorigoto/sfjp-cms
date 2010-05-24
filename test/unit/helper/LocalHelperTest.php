<?php
// test/unit/helper/LocalHelperTest.php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';
require_once($_test_dir.'/../lib/vendor/symfony/test/unit/sfContextMock.class.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/UrlHelper.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/AssetHelper.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/TagHelper.php');


require_once($_test_dir.'/../lib/helper/LocalHelper.php');

class myController
{
    public function genUrl($parameters = array(), $absolute = false)
    {
        if (preg_match('|^(\/)|i', $parameters)) {
            return $parameters;
        }
        $url = is_array($parameters) && isset($parameters['sf_route']) ? $parameters['sf_route'] : '/module/action';
        return ($absolute ? '/' : '').$url;
    }
}

class myRequest
{
    public function getRelativeUrlRoot()
    {
        return '/public';
    }

    public function isSecure()
    {
        return true;
    }

    public function getHost()
    {
        return 'example.org';
    }
}

class BaseForm extends sfForm
{
    public function getCSRFToken($secret = null)
    {
        return '==TOKEN==';
    }
}

sfForm::enableCSRFProtection();

$context = sfContext::getInstance(array('controller' => 'myController', 'request' => 'myRequest'));



$t = new lime_test(25);

// url_for_page()
$t->diag('url_for_page()');
$t->is(
    url_for_page('/test'),
    '/module/action/test',
    '第1階層ページ名');
$t->is(
    url_for_page('test'),
    '/module/action/test',
    '第1階層、先頭のスラッシュは自動付与');
$t->is(
    url_for_page(''),
    '/module/action/',
    '空の場合はトップURL（スラッシュ付）');
$t->is(
    url_for_page('/'),
    '/module/action/',
    'ルート');
$t->is(
    url_for_page('/test/'),
    '/module/action/test/',
    '第1階層 末尾スラッシュ');
$t->is(
    url_for_page('/test/foo'),
    '/module/action/test/foo',
    '第2階層ページ名');
$t->is(
    url_for_page('/test/foo/'),
    '/module/action/test/foo/',
    '第2階層スラッシュ付');
$t->is(
    url_for_page('/test//foo'),
    '/module/action/test/foo',
    '途中の連続スラッシュは自動削除');


// link_to_page()
$t->diag('link_to_page()　URL生成部分はurl_for_page()に依存');
$t->is(
    link_to_page('foo', '/test'),
    '<a href="/module/action/test">foo</a>',
    '第1階層ページ名');
$t->is(
    link_to_page('foo', '/test/foo'),
    '<a href="/module/action/test/foo">foo</a>',
    '第2階層ページ名');
$t->is(
    link_to_page('foo', '/test/foo/'),
    '<a href="/module/action/test/foo/">foo</a>',
    '第2階層スラッシュ付');
$t->is(
    link_to_page('foo', '/test//foo'),
    '<a href="/module/action/test/foo">foo</a>',
    '途中の連続スラッシュは自動削除');
$t->is(
    link_to_page('foo', '/test', array('class'=>'bar')),
    '<a class="bar" href="/module/action/test">foo</a>',
    'link_toのオプションはそのまま有効'
    );


// link_to_option_selectable()
$t->diag('link_to_option_selectable() リンクタグ生成はlink_to_page()に依存');

$test_function_true = function($param) {
  return true;
};
$test_function_false = function($param) {
    return false;
};

$t->is(
    link_to_option_selectable('foo',
        '/test',
        $test_function_true,
        array(),
        array('opt'=>'1'),
        array('opt'=>'0')
    ),
    '<a title="foo" opt="1" href="/module/action/test">foo</a>',
    '条件true時は、true時オプションが適用される'
    );
$t->is(
    link_to_option_selectable('foo',
        '/test',
        $test_function_false,
        array(),
        array('opt'=>'1'),
        array('opt'=>'0')
    ),
    '<a title="foo" opt="0" href="/module/action/test">foo</a>',
    '条件false時は、false時オプションが適用される'
    );
$t->is(
    link_to_option_selectable('foo',
        '/test',
        $test_function_true,
        array('defopt'=>'default'),
        array('opt'=>'1'),
        array('opt'=>'0')
    ),
    '<a defopt="default" opt="1" href="/module/action/test">foo</a>',
    'デフォルトオプションとマージされる'
    );
$t->is(
    link_to_option_selectable('foo',
        '/test',
        $test_function_true,
        array('opt'=>'default'),
        array('opt'=>'1'),
        array('opt'=>'0')
    ),
    '<a opt="1" href="/module/action/test">foo</a>',
    'デフォルトオプションとマージされる（上書き）'
    );
$t->is(
    link_to_option_selectable('foo',
        '/test',
        null,
        array('opt'=>'default'),
        array('opt'=>'1'),
        array('opt'=>'0')
    ),
    '<a opt="default" href="/module/action/test">foo</a>',
    '比較関数がない場合はデフォルトオプションのみ有効'
    );


// renderIndexItem()
$t->diag('renderIndexItem() 内部でrenderIndexItemList()を呼び出す');
$indexdata = null;
$t->is(
    renderIndexItem($indexdata),
    '',
    'データが空の場合は何も出力されない'
    );

$indexdata = new stdClass();
$indexdata->type = 'testtype';
$indexdata->text = 'hogehoge';
$indexdata->id   = 'testid';
$indexdata->children = array();

$t->is(
    renderIndexItem($indexdata),
    "<li><a href=\"#testid\">hogehoge</a></li>\n",
    '単一データ。liタグにて出力される。idデータがアンカーリンクとなる。'
    );

$indexdata2 = new stdClass();
$indexdata2->type = 'testtype2';
$indexdata2->text = 'hogehoge2';
$indexdata2->id   = 'testid2';
$indexdata2->children = array();

$indexdata3 = new stdClass();
$indexdata3->type = 'testtype3';
$indexdata3->text = 'hogehoge3';
$indexdata3->id   = 'testid3';
$indexdata3->children = array();

$indexdata = new stdClass();
$indexdata->type = 'testtype';
$indexdata->text = 'hogehoge';
$indexdata->id   = 'testid';
$indexdata->children = array($indexdata2, $indexdata3);

$t->is(
    renderIndexItem($indexdata),
    "<li><a href=\"#testid\">hogehoge</a>\n<ul>\n<li><a href=\"#testid2\">hogehoge2</a></li>\n<li><a href=\"#testid3\">hogehoge3</a></li>\n</ul>\n</li>\n",
    '階層データ。liタグにて出力される。idデータがアンカーリンクとなる。子はulタグ'
    );

$indexdata2 = new stdClass();
$indexdata2->type = 'testtype2';
$indexdata2->text = 'hogehoge2';
$indexdata2->id   = 'testid2';
$indexdata2->children = array();

$indexdata3 = new stdClass();
$indexdata3->type = 'testtype3';
$indexdata3->text = 'hogehoge3';
$indexdata3->id   = 'testid3';
$indexdata3->children = array($indexdata2);

$indexdata = new stdClass();
$indexdata->type = 'testtype';
$indexdata->text = 'hogehoge';
$indexdata->id   = 'testid';
$indexdata->children = array($indexdata2, $indexdata3);

$t->is(
    renderIndexItem($indexdata),
    "<li><a href=\"#testid\">hogehoge</a>\n<ul>\n<li><a href=\"#testid2\">hogehoge2</a></li>\n<li><a href=\"#testid3\">hogehoge3</a>\n<ul>\n<li><a href=\"#testid2\">hogehoge2</a></li>\n</ul>\n</li>\n</ul>\n</li>\n",
    '階層データ。第3階層まで。'
    );



// renderIndexItemList()
$t->diag('renderIndexItemList() 内部でrenderIndexItem()を呼び出す');

$t->is(
    renderIndexItemList(array()),
    "",
    '空データの場合は何も出力されない。'
    );

$indexdata = new stdClass();
$indexdata->type = 'testtype';
$indexdata->text = 'hogehoge';
$indexdata->id   = 'testid';
$indexdata->children = array();

$t->is(
    renderIndexItemList(array($indexdata)),
    "\n<ul>\n<li><a href=\"#testid\">hogehoge</a></li>\n</ul>\n",
    '単一データ'
    );

$indexdata2 = new stdClass();
$indexdata2->type = 'testtype2';
$indexdata2->text = 'hogehoge2';
$indexdata2->id   = 'testid2';
$indexdata2->children = array();

$indexdata3 = new stdClass();
$indexdata3->type = 'testtype3';
$indexdata3->text = 'hogehoge3';
$indexdata3->id   = 'testid3';
$indexdata3->children = array($indexdata2);

$indexdata = new stdClass();
$indexdata->type = 'testtype';
$indexdata->text = 'hogehoge';
$indexdata->id   = 'testid';
$indexdata->children = array($indexdata2, $indexdata3);

$t->is(
    renderIndexItemList(array($indexdata)),
    "\n<ul>\n<li><a href=\"#testid\">hogehoge</a>\n<ul>\n<li><a href=\"#testid2\">hogehoge2</a></li>\n<li><a href=\"#testid3\">hogehoge3</a>\n<ul>\n<li><a href=\"#testid2\">hogehoge2</a></li>\n</ul>\n</li>\n</ul>\n</li>\n</ul>\n",
    '階層付データデータ'
    );
