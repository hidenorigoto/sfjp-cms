          <div class="article">
            <img class="ico_title" src="<?php echo public_path('images/ico_docu_side.png') ?>" alt="" />
            <h3 class="side_title">
              <div>日本語ドキュメント</div>
              <div class="side_title_en">Japanese Documents</div>
            </h3>
            <ul class="list_side">
            <?php foreach ($docs_pages as $page): ?>
              <li><img src="<?php echo public_path('images/list_arrow_orange.png') ?>" alt="" />
              <?php echo $page->getDateTimeObject('last_updated')->format('Y/m/d') ?>
              <?php echo link_to_page($page->getTitle(), $page->getPath()) ?></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <!-- end .article -->
