      <div id="main">

      	<div id="info">
        	<h2 id="info_title">日本Symfonyユーザー会とは</h2>
          <p>日本Symfonyユーザー会は、Symfonyを普及させることを第一の目的として有志により設立されました。 現在は特に会則などを定めない有志の集まりとして運営しています。 ※金銭・資産の管理は、アシアル株式会社にて行っています。
          <?php echo link_to_page('≫詳細はこちら', '/about') ?></p>
        </div>
      	<!-- end #info -->



        <div id="main_content">
          <div class="article">
            <img class="ico_title" src="<?php echo public_path('images/ico_news_main.png') ?>" alt="" />
            <h2 class="main_title">
              <div>ニュース</div>
              <div class="main_title_en">News Information</div>
            </h2>
            <ul class="list_main">
            <?php foreach ($news_pages as $page): ?>
              <li><img src="<?php echo public_path('images/list_arrow_orange.png') ?>" alt="" />
                <?php echo $page->getFormattedFirstCommitted() ?>
                <?php echo link_to_page($page->getTitle(), $page->getPath()) ?></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <!-- end .article -->

          <div class="article">
            <img class="ico_title" src="<?php echo public_path('images/ico_event_main.png') ?>" alt="" />
            <h2 class="main_title">
              <div>イベント</div>
              <div class="main_title_en">Events Information</div>
            </h2>
            <ul class="list_main">
            <?php foreach ($events_pages as $page): ?>
              <li><img src="<?php echo public_path('images/list_arrow_orange.png') ?>" alt="" />
                              <?php echo $page->getFormattedFirstCommitted() ?>
                              <?php echo link_to_page($page->getTitle(), $page->getPath()) ?></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <!-- end .article -->

          <div class="article" id="bl_list_main">
            <img class="ico_title" src="<?php echo public_path('images/ico_blog_main.png') ?>" alt="" />
            <h2 class="main_title">
              <div>ブログ</div>
              <div class="main_title_en">Blogs Information</div>
            </h2>
            <ul class="list_main">
            <?php foreach ($blog_pages as $page): ?>
              <li><img src="<?php echo public_path('images/list_arrow_orange.png') ?>" alt="" />
              <?php echo $page->getFormattedFirstCommitted() ?>
              <?php echo link_to_page($page->getTitle(), $page->getPath()) ?></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <!-- end .article -->


        </div>
        <!-- end #main_content -->


        <div id="side_2" class="side">


<?php echo include_partial('global/global_block_docs', array('docs_pages'=>$docs_pages)) ?>
<?php echo include_partial('global/global_block_books') ?>
        </div>
        <!-- end #side_1 -->


        <div id="side_1" class="side">
<?php echo include_partial('global/global_block_release', array('release'=>$release)) ?>
<?php echo include_partial('global/global_block_banner', array('banner'=>$banner)) ?>

        </div>
        <!-- end #side_1 -->


      </div>
      <!-- end #main -->
