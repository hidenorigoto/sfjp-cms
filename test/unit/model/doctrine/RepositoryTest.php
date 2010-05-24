<?php
// test/unit/model/doctrine/RepositoryTest.php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';

require_once($_test_dir.'/../lib/vendor/symfony/test/unit/sfContextMock.class.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/UrlHelper.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/AssetHelper.php');
require_once($_test_dir.'/../lib/vendor/symfony/lib/helper/TagHelper.php');

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


// test環境でDB初期化
$configuration = ProjectConfiguration::getApplicationConfiguration('taskapp', 'test', true);
new sfDatabaseManager($configuration);
Doctrine_Core::loadData(dirname(__FILE__).'/RepositoryFixture.yml');


$t = new lime_test(28);

// construct
$t->diag('__construct()');
$t->ok(
    new Repository instanceof Repository,
    'Repositoryインスタンス化'
    );


// create
$t->diag('create');
$repository = new Repository();
$repository->setName('repository_name');
$repository->setRepository('repository_url');
$repository->setSubdirectory('subdirectory');
$repository->setBindPath('/bind_path');
$repository->setSettingsJson('settings_json');
$repository->setForceUpdate(true);
$repository->setForceClone(true);
$repository->save();

$repository = RepositoryTable::getInstance()->findOneByName('repository_name');
$t->ok(
    $repository instanceof Repository,
    'Repository保存'
    );

$t->is(
    $repository->getName(),
    'repository_name',
    'リポジトリ名の保存'
    );
$t->is(
    $repository->getRepository(),
    'repository_url',
    'リポジトリURLの保存'
    );
$t->is(
    $repository->getSubdirectory(),
    'subdirectory',
    'サブディレクトリの保存'
    );
$t->is(
    $repository->getBindPath(),
    '/bind_path',
    '結合パスの保存'
    );
$t->is(
    $repository->getSettingsJson(),
    'settings_json',
    '設定値の保存'
    );
$t->is(
    $repository->getForceUpdate(),
    true,
    '強制更新値の保存'
    );
$t->is(
    $repository->getForceClone(),
    true,
    '強制clone値の保存'
    );



// setter bind_path
$t->diag('setter bind_path');

$repository->setBindPath('/');
$t->is(
    $repository->getBindPath(),
    '',
    '/のみは空白に'
    );

$repository->setBindPath('/test');
$t->is(
    $repository->getBindPath(),
    '/test',
    '先頭スラッシュ付き、末尾スラッシュなし'
    );
$repository->setBindPath('/test/foo');
$t->is(
    $repository->getBindPath(),
    '/test/foo',
    '先頭スラッシュ付き、末尾スラッシュなし（2階層）'
    );

$repository->setBindPath('foo');
$t->is(
    $repository->getBindPath(),
    '/foo',
    '先頭スラッシュ付与'
    );
$repository->setBindPath('/foo/');
$t->is(
    $repository->getBindPath(),
    '/foo',
    '末尾スラッシュ削除'
    );
$repository->setBindPath('foo/');
$t->is(
    $repository->getBindPath(),
    '/foo',
    '先頭スラッシュ付与、末尾スラッシュ削除'
    );
$repository->setBindPath('/foo/bar/');
$t->is(
    $repository->getBindPath(),
    '/foo/bar',
    '末尾スラッシュ削除'
    );

try {
    $repository->setBindPath('#');
    $t->fail('結合パス指定の不正文字');
} catch (Exception $e) {
    $t->pass(
        '結合パスに不正文字を設定で例外'
        );
}
try {
    $repository->setBindPath('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/*-+!"$%&()^_:;[]');
    $t->pass(
        'パス指定に使える文字'
        );
} catch (Exception $e) {
    $t->fail(
        'パス指定に使える文字の判定'
        );
}






$repository = RepositoryTable::getInstance()->findOneByName('testrepo');

// getCacheKey()
$t->diag('getCacheKey()');
$t->is(
    $repository->getCacheKey(),
    'XXfoo',
    'キャッシュキーは結合パスの/をXXに替えたもの'
    );

$repository->setBindPath('');
$t->is(
    $repository->getCacheKey(),
    'XX',
    '結合パスが空の場合は、XXのみに変換。（/に結合とみなす）'
    );

$repository->setBindPath('/');
$t->is(
    $repository->getCacheKey(),
    'XX',
    '結合パスが/の場合は、XXのみに変換。'
    );
$repository->setBindPath('/test1/test2');
$t->is(
    $repository->getCacheKey(),
    'XXtest1XXtest2',
    '結合パス変換。'
    );


// getRepositoryName()
$t->diag('getRepositoryName()');
$t->is(
    $repository->getRepositoryName(),
    'test',
    'リポジトリURLの名前部分の取得'
    );



$repository = RepositoryTable::getInstance()->findOneByName('testrepo');

// getPublicDirectory()
$t->diag('getPublicDirectory()');
$t->is(
    $repository->getPublicDirectory(),
    sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'r' . DIRECTORY_SEPARATOR . 'images/foo',
    'リポジトリ用のパブリックディレクトリパスの取得'
    );


// getImagePublicPath()
$t->diag('getImagePublicPath()');
$t->is(
    $repository->getImagePublicPath('images/test/foo.png'),
    sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'r' . DIRECTORY_SEPARATOR . 'images/foo' . DIRECTORY_SEPARATOR . 'images/test/foo.png',
    'リポジトリ内画像用のパブリックディレクトリ内パスの取得'
    );


// getRepositoryHttp()
$t->diag('getRepositoryHttp()');
$t->is(
    $repository->getRepositoryHttp(),
    'http://github.com/hidenorigoto/test',
    'github URLの取得（git://）'
    );
$repository->setRepository('http://github.com/hidenorigoto/sfjp-doc-main.git');
$t->is(
    $repository->getRepositoryHttp(),
    'http://github.com/hidenorigoto/sfjp-doc-main',
    'github URLの取得（http://）'
    );
$repository->setRepository('https://github.com/hidenorigoto/sfjp-doc-main.git');
$t->is(
    $repository->getRepositoryHttp(),
    'http://github.com/hidenorigoto/sfjp-doc-main',
    'github URLの取得（https://）'
    );
