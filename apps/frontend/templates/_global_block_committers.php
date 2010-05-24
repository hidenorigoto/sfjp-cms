<?php
/**
 * @param Doctrine_Collection $committers
 */
$image_size = 36;
?>
<div class="committers">
<h2>この文書の執筆・編集</h2>
<ul>
<?php foreach ($committers as $committer): ?>
<li><?php echo image_tag($committer->getCommitterGravatarUrl($image_size),
        array(
          'width'=>$image_size,
          'height'=>$image_size,
          'title'=>$committer->getCommitterHandle()
      ));
?></li>
<?php endforeach ?>
</ul>
</div>