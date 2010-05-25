<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<?php include_stylesheets() ?>
<?php include_javascripts() ?>
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
			  <div id="footer_left"></div>
			  <div id="footer_right"></div>
          <?php include_partial('global/global_menu', array('div_id'=>'f_navbar')) ?>
          <div>
            <p id="copy">
              Powered by <img src="<?php echo public_path('images/symfony_button.png') ?>" alt="synfony" /> <span style="font-size: 10px;">このホームページは日本Symfonyユーザー会運営事務局が運営しています</span><br />
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
</body>
</html>
