<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<?php include_stylesheets() ?>
<?php include_javascripts() ?>
<link rel="alternate" type="application/rss+xml" title="日本Symfonyユーザー会 コンテンツ更新情報"  href="<?php echo url_for('@feed'); ?>" />
<link rel="shortcur icon" href="<?php echo public_path('images/favicon.ico') ?>" />
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
        <h1 id="logo_top"><?php echo link_to('日本Symfonyユーザー会', '@homepage') ?></h1>
        <div id="header_top_left"></div>
      </div>
      <!-- end #header -->

      <!--
      <div id="left_light">
      </div>
      -->
      <!-- end lrft_light -->
<?php include_partial('global/global_menu', array('div_id'=>'navbar')) ?>

<?php echo $sf_content ?>
    </div>
    <!-- end #content_wrapper -->
  </div>
  <!-- end #content -->


  <div id="footer">
   	<div id="footer_wrapper">
      <div id="footer_content">
        <div style=" position: relative;">
          <div id="footer_left"></div>
          <div id="footer_right"></div>
        </div>
        <?php include_partial('global/global_menu', array('div_id'=>'f_navbar')) ?>
        <div>
          <p id="copy">
            Powered by <a href="http://www.symfony-project.org/"><img src="<?php echo public_path('images/symfony_button.png') ?>" alt="synfony" /></a>
            <?php echo SYMFONY_VERSION ?>
            &nbsp;&nbsp;
            このホームページは日本Symfonyユーザー会運営事務局が運営しています<br />
            Copyright &copy; 2010 Symfony Japan. All rights reserved.
            &nbsp;&nbsp;&nbsp;Bandwidth and hardware provided by <a href="http://www.asial.co.jp/">アシアル株式会社</a>
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
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16659283-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
