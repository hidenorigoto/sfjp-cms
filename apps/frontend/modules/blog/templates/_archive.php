          <div class="article">
            <h3 class="side_title2">
              <div>アーカイブ</div>
              <div class="side_title_en">Archives</div>
            </h3>
            <ul class="list_side">
            <?php foreach ($ym_index as $ym): ?>
              <li><img src="<?php echo public_path('images/list_arrow_orange.png') ?>" alt="" />
              <?php echo link_to(sprintf('%s/%s (%s)', $ym['year'], $ym['month'], $ym['count']), sprintf('%s_list_ym', $page_type), array('year'=>$ym['year'], 'month'=>$ym['month'])) ?></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <!-- end .article -->
