<?php

class testTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'taskapp'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'test';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [test|INFO] task does things.
Call it with:

  [php symfony test|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $html = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="日本Symfonyユーザー会" />
<meta name="keywords" content="symfony" />
<meta name="language" content="ja" />
<title>日本Symfonyユーザー会</title>
</head>
<body>

<div id="all">
<div id="content">
<div id="content_wrapper">
<div id="top_menu">
<div id="top_menu_wrapper">
<!--
<form id="s_form">
<input id="s_text" type="text" name="" value="" />
<input id="s_button" type="submit" value="検索" />
</form>
-->
</div>
<!-- end #top_menu_wrapper -->
</div>
<!-- end top_menu -->

<div id="header_top">
<h1 id="logo_top"><a href="/test/sfjp/web/frontend_dev.php/">日本Symfonyユーザー会</a></h1>
<div id="header_top_left"></div>
</div>
<!-- end #header -->

<!--
<div id="left_light">
</div>
-->
<!-- end lrft_light -->
<div id="navbar">
<ul>
<li><a title="ホーム" href="/test/sfjp/web/frontend_dev.php/">ホーム</a></li>
<li><a title="日本Symfonyユーザー会とは" href="/test/sfjp/web/frontend_dev.php/about">日本Symfonyユーザー会とは</a></li>
<li><a title="Symfonyについて" href="/test/sfjp/web/frontend_dev.php/about-symfony">Symfonyについて</a></li>
<li><a title="ニュース" href="/test/sfjp/web/frontend_dev.php/news">ニュース</a></li>
<li><a title="イベント" href="/test/sfjp/web/frontend_dev.php/events">イベント</a></li>
<li><a title="ブログ" href="/test/sfjp/web/frontend_dev.php/blog">ブログ</a></li>
<li><a title="日本語ドキュメント" class="this" href="/test/sfjp/web/frontend_dev.php/docs">日本語ドキュメント</a></li>
<li><a title="コミュニティ" href="/test/sfjp/web/frontend_dev.php/community">コミュニティ</a></li>
</ul>
</div>
<!-- end #navbar -->

<div id="main">

<!--
<div id="info">
<h2 id="info_title">ニュース</h2>
</div>
-->
<!-- end #info -->



<div id="main_content2">
<div class="sympal_markdown">
<h1>Symfonyのインストール方法（入門者・評価向け）</h1>

<blockquote class="tip"><p>
この文書は、Symfony 1系を対象としています。</p>
</blockquote>

<p>Symfonyには、以下の4種類のインストール方法があります。</p>

<ol>
<li>pearによるインストール</li>
<li>Symfonyパッケージをダウンロードしてインストール</li>
<li>Symfony Sandboxパッケージをダウンロードしてインストール</li>
<li>subversionリポジトリからチェックアウトしてインストール</li>
</ol>

<p>これらのインストール方法については、公式サイトのいくつかのドキュメントで説明されています。</p>

<ul>
<li><a href="http://www.symfony-project.org/installation/1_4">The symfony framework Installation (英語)</a></li>
<li><a href="http://www.symfony-project.org/getting-started/1_4/ja/03-Symfony-Installation">Getting Started with symfony symfonyのインストール</a></li>
<li><a href="http://www.symfony-project.org/jobeet/1_4/Doctrine/ja/01">Practical Symfony 1日目：プロジェクトを始める</a></li>
</ul>

<blockquote class="caution"><p>
古いドキュメントでは、pearを使ったインストール方法で解説されているものが多くありますが、現在ではpearを使ったインストールは推奨されていません。</p>
</blockquote>

<p>このページでは、Symfony入門者向けに一番手軽なSandboxパッケージを使ったインストール方法について説明します。</p>

<h2>SymfonyのSandboxパッケージをダウンロード</h2>

<p>まずは、Symfony 1.4の最新版パッケージをダウンロードしましょう。</p>

<p>Symfony 1.4の最新版パッケージのダウンロードは、公式サイトの<a href="http://www.symfony-project.org/installation">こちらのページ</a>から行います。</p>

<p><img src="images/installation.png" alt="ダウンロードページ" /></p>

<p><strong>Download</strong>という行にtgz形式、またはzip形式でダウンロードできるリンクが表示されています。
また、<strong>Sourceパッケージ</strong>と<strong>Sandboxパッケージ</strong>があります。</p>

<ul>
<li><strong>Sourceパッケージ：</strong> Symfony本体のソースのみ</li>
<li><strong>Sandboxパッケージ:</strong> Symfony本体のソースと、sf_sandboxプロジェクト、frontendアプリケーションが初期化されたファイル群が付属</li>
</ul>

<p>今回は、Symfony 1.4の<strong>Sandboxパッケージ</strong>をダウンロードして下さい（Symfony 1.4の列、Sandboxのtgzまたはzipリンクから）。</p>

<p>ウェブサーバーのDocumentRoot配下のディレクトリ、またはユーザーのpublic_html配下のディレクトリにて、ダウンロードしたファイルを展開してください。
以下のようなディレクトリ、ファイルがあります（ファイルは一部のみ記載しています）。</p>

<pre class="command-line">
sf_sandbox/
apps/
frontend/
cache/
config/
data/
lib/
form/
vendor/
symfony/
log/
plugins/
test/
web/
LICENSE
README
symfony
symfony.bat
</pre>

<p>Symfonyのディレクトリ構造について詳しく知りたい方は、『<a href="http://symfony.sarabande.jp/book/1.2/02-Exploring-Symfony-s-Code.html#file.tree.structure">The Definitive Guide to symfony(日本語訳) 2.2.2 ファイルのツリー構造</a>』を参照してください。</p>

<h2>symfonyの最初の動作確認</h2>

<p>展開したSandboxパッケージのSymfonyがお使いの環境で動作するかどうか調べてみましょう。
コマンドラインでパッケージを展開したディレクトリ(sf_sandboxディレクトリ)へ移動し、以下のコマンドを実行してみてください。</p>

<pre class="command-line">
php symfony -V
</pre>

<p>以下のようにSymfonyのバージョン情報が表示されれば、動作確認はOKです。</p>

<pre class="command-line">
symfony version 1.4.4 (パス)
</pre>

<h2>sfディレクトリの準備</h2>

<p>Symfonyには組み込みのエラー画面やデバッグツールバーがありますが、これら組み込み機能用のデザインファイルはプロジェクトのデザインファイルとは分離されています。
以下の操作を行って、組み込みのデザインが適用されるように準備してください。</p>

<h3>Linux環境</h3>

<pre class="command-line">
# sf_sandboxディレクトリにて
ln -s lib/vendor/symfony/data/web/sf web/
</pre>

<h3>Windows環境</h3>

<pre class="command-line">
# sf_sandboxディレクトリにて
xcopy /S /E /F /G /H /R /K /Y lib\\vendor\\symfony\\data\\web\\sf web\\sf\\

# エクスプローラでsfディレクトリをwebディレクトリへコピーしても構いません
</pre>

<h2>パーミッションの設定</h2>

<p>Linux環境の場合、<code>cache</code>ディレクトリと<code>log</code>ディレクトリにウェブサーバーのプロセスから書き込みができるように設定しておく必要があります。
Symfonyにはこれらのディレクトリのパーミッションを設定するタスクが用意されています。
コマンドプロンプトでプロジェクトのルートディレクトリへ移動し、以下のコマンドを実行してください。</p>

<pre class="command-line">
php symfony project:permissions
</pre>

<h2>ブラウザから表示の確認</h2>

<p>さて、ここまで準備ができたらウェブブラウザからSymfonyのディレクトリにアクセスして、初期表示を確認しましょう。
sf_sandboxをローカル環境のドキュメントルート直下で展開した場合は、アクセスするURLは次のとおりです。</p>

<pre class="command-line">
http://localhost/sf_sandbox/web/frontend_dev.php
</pre>

<p>「Symfony Project Created」というような画面が表示されたでしょうか？このメッセージが表示されれば、まずはSymfonyを動作させる最低限の設定の完了です。</p>

<blockquote class="note"><p>
お使いの環境の設定やサンドボックスパッケージを展開したディレクトリによっては上記のURLとは異なる場合があります。
重要な点は、<code>（プロジェクトルート）/web/frontend_dev.php</code>に対応するURLにアクセスするということです。</p>
</blockquote>

<h2>You are not allowed to access this file. Check frontend_dev.php for more information.</h2>

<p>Symfonyを設置した開発サーバーとは別のコンピュータからアクセスした場合、このような表示になります。
これは、公開サーバーで誤って開発用フロントコントローラーが閲覧可能になってしまうのを防ぐためのコードです。
もしこのようなメッセージが表示された場合は、<code>web/frontend_dev.php</code>ファイルを開き、以下の行をコメントアウトして下さい。</p>

<pre class="php"><span class="kw1">if</span> <span class="br0">&#40;</span>!<span class="kw3">in_array</span><span class="br0">&#40;</span>@<span class="re0">$_SERVER</span><span class="br0">&#91;</span><span class="st0">''</span>REMOTE_ADDR<span class="st0">''</span><span class="br0">&#93;</span>, <span class="kw3">array</span><span class="br0">&#40;</span><span class="st0">''</span><span class="nu0">127.0</span><span class="nu0">.0</span><span class="nu0">.1</span><span class="st0">''</span>, <span class="st0">''</span>::<span class="nu0">1</span><span class="st0">''</span><span class="br0">&#41;</span><span class="br0">&#41;</span><span class="br0">&#41;</span>
<span class="br0">&#123;</span>
<span class="kw3">die</span><span class="br0">&#40;</span><span class="st0">''</span>You are not allowed to access this <span class="kw3">file</span>. Check <span class="st0">''</span>.<span class="kw3">basename</span><span class="br0">&#40;</span><span class="kw2">__FILE__</span><span class="br0">&#41;</span>.<span class="st0">''</span> <span class="kw1">for</span> more information.<span class="st0">''</span><span class="br0">&#41;</span>;
<span class="br0">&#125;</span>
&nbsp;</pre>

<h2>画面が真っ白になる</h2>

<p>この段階で画面が真っ白になって何も表示されない場合、<code>cache</code>ディレクトリ、または<code>log</code>ディレクトリのパーミッションが正しく設定されていない可能性があります。
ウェブサーバーのエラーログを確認してキャッシュに書き込めないというエラーが出ている場合は、パーミッションを設定し直して下さい。</p>
</div>

</div>
<!-- end #main_content -->


<div id="side_2" class="side">

<div class="article">
<img class="ico_title" src="/test/sfjp/web/images/ico_docu_side.png" alt="" />
<h3 class="side_title">
<div>日本語ドキュメント</div>
<div class="side_title_en">Japanese Documents</div>
</h3>
<ul class="list_side">
<li><img src="/test/sfjp/web/images/list_arrow_orange.png" alt="" />準備中</li>
</ul>
</div>
<!-- end .article -->

<div class="article">
<img class="ico_title" src="/test/sfjp/web/images/ico_books_side.png" alt="" />
<h3 class="side_title">
書籍の紹介<br />
<span class="side_title_en">Books Information</span>
</h3>
<ul class="b_list_side">
<li>
準備中
</li>
</ul>
<!-- end .books_side -->
</div>
<!-- end .article -->
<div class="release">
<div class="release_wrapper">
<div class="release_content">
<h3 class="side_title" id="release">
リリース情報<br />
<span class="side_title_en">Release Information</span>
</h3>
<ul>
<li>1.3 branch: <a href="http://www.symfony-project.org/installation">1.3.4</a>(2010/04/06)</li>
<li>1.4 branch: <a href="http://www.symfony-project.org/installation">1.4.4</a>(2010/04/06)</li>
<li>2.0 branch: <a href="http://symfony-reloaded.org/code">Preview Release</a></li>
</ul>
</div>
<!-- end release_content -->
</div>
<!-- end release_wrapper -->
</div>
<!-- end release -->
<a href="http://www.symfony-reloaded.org/"><img class="side_banner" src="/test/sfjp/web/images/symfony-reloaded.png" alt="symfony-reloaded プレビューリリース" /></a>
<a href="http://www.sensiolabs.com/books"><img class="side_banner" src="/test/sfjp/web/images/books.png" alt="Books on symfony" /></a>

</div>
<!-- end #side_1 -->

</div>
<!-- end #main -->
</div>
<!-- end #content_wrapper -->
</div>
<!-- end #content -->


<div id="footer">
<div id="footer_wrapper">
<div id="footer_content">
<div id="footer_left"></div>
<div id="footer_right"></div>
<div id="f_navbar">
<ul>
<li><a title="ホーム" href="/test/sfjp/web/frontend_dev.php/">ホーム</a></li>
<li><a title="日本Symfonyユーザー会とは" href="/test/sfjp/web/frontend_dev.php/about">日本Symfonyユーザー会とは</a></li>
<li><a title="Symfonyについて" href="/test/sfjp/web/frontend_dev.php/about-symfony">Symfonyについて</a></li>
<li><a title="ニュース" href="/test/sfjp/web/frontend_dev.php/news">ニュース</a></li>
<li><a title="イベント" href="/test/sfjp/web/frontend_dev.php/events">イベント</a></li>
<li><a title="ブログ" href="/test/sfjp/web/frontend_dev.php/blog">ブログ</a></li>
<li><a title="日本語ドキュメント" class="this" href="/test/sfjp/web/frontend_dev.php/docs">日本語ドキュメント</a></li>
<li><a title="コミュニティ" href="/test/sfjp/web/frontend_dev.php/community">コミュニティ</a></li>
</ul>
</div>
<!-- end #navbar -->
<div>
<p id="copy">
Powered by <img src="/test/sfjp/web/images/symfony_button.png" alt="synfony" /> <span style="font-size: 10px;">このホームページは日本Symfonyユーザー会運営事務局が運営しています</span><br />
Copyright &copy; 2010 Symfony Japan. All rights reserved.
</p>
</div>


</div>
<!-- end #footer_content -->
</div>
<!-- end #footer_wrapper -->
</div>
<!-- end #footer -->




</div>
<!-- end #all -->
</body></html>
EOF;
    //$html = str_replace('\\', "B", $html);
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'ASCII, JIS, UTF-8, EUC-JP, SJIS');

    $dom = new DomDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $domElements = $xpath->query('//h1 | //h2 | //h3');
    $indexes = array();
    $now_h1 = array();
    $now_h2 = array();
    foreach ($domElements as $domElement)
    {
      echo $domElement->nodeValue;
      switch ($domElement->nodeName)
      {
        case 'h1':
          echo "h1";
          $indexes[] = array(
                          'type'=>'h1',
                          'text'=>$domElement->nodeValue,
                          'children'=>array()
                        );
          $now_h1 = &$indexes[count($indexes) - 1]['children'];
          break;
        case 'h2':
          echo "h2";
          $now_h1[] = array(
                          'type'=>'h2',
                          'text'=>$domElement->nodeValue,
                          'children'=>array()
                        );
          $now_h2 = &$now_h1[count($now_h1) - 1]['children'];
          break;
        case 'h3':
          echo "h3";
          $now_h2[] = array(
                          'type'=>'h3',
                          'text'=>$domElement->nodeValue,
                          'children'=>array()
                        );
          break;
        default:
        ;
      }
    }
    var_dump($indexes);
  }
}