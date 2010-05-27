      <div id="main">
        <div id="main_content2">

<!-- contents body -->
<div class="sympal_markdown">
<?php echo $page->getRawValue()->render() ?>
</div>
<!-- end contents body -->

            <div id="content_footer">
<?php include_partial('global/global_block_timestamp', array('commits'=>$commits)) ?>

<!-- committers -->
<?php include_partial('global/global_block_committers', array('committers'=>$committers)) ?>
<!-- end comitters -->

<?php include_partial('global/global_block_githubinfo', array('page'=>$page)) ?>
            </div>
            <!-- end #content_footer -->
        </div>
        <!-- end #main_content -->


        <div id="side_2" class="side">

          <div class="article">
            <h3 class="side_title2">
              <div>インデックス</div>
              <div class="side_title_en">Document Index</div>
            </h3>
<?php include_partial('global/global_block_pageindex', array('page'=>$page)) ?>
          </div>
          <!-- end .article -->

          <div class="article">
            <h3 class="side_title2">
              <div>関連ページリスト</div>
              <div class="side_title_en">Related Pages</div>
            </h3>
<ul class="list_side">
<?php foreach ($dir_pages as $dir_page): ?>
<?php if ($dir_page->getTitle() == '') continue; ?>
<li><img src="<?php echo public_path('images/list_arrow_orange.png') ?>" alt="" /> <?php
if ($dir_page->getId() === $page->getId()) {
    echo $dir_page->getTitle();
} else {
    echo link_to_page($dir_page->getTitle(), $dir_page->getPath());
}
?></li>
<?php endforeach; ?>
</ul>
          </div>
          <!-- end .article -->

<?php echo include_partial('global/global_block_docs', array('docs_pages'=>$docs_pages)) ?>

<?php echo include_partial('global/global_block_books') ?>
<?php echo include_partial('global/global_block_release', array('release'=>$release)) ?>
<?php echo include_partial('global/global_block_banner', array('banner'=>$banner)) ?>

        </div>
        <!-- end #side_1 -->

      </div>
      <!-- end #main -->
