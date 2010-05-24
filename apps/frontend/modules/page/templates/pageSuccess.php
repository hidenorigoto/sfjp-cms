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

<?php echo include_partial('global/global_block_docs', array('docs_pages'=>$docs_pages)) ?>

<?php echo include_partial('global/global_block_books') ?>
<?php echo include_partial('global/global_block_release', array('release'=>$release)) ?>
<?php echo include_partial('global/global_block_banner', array('banner'=>$banner)) ?>

        </div>
        <!-- end #side_1 -->

      </div>
      <!-- end #main -->
