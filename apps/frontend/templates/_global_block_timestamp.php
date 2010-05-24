<?php
//  @param Doctrine_Collection $commits
$first = $commits->getFirst();
$last = $commits->getLast();
?>
<div class="timestamp">
<ul>
  <li>更新：<?php echo $last->getDateTimeObject('committed_at')->format('Y/m/d H:i'); ?></li>
  <li>作成：<?php echo $first->getDateTimeObject('committed_at')->format('Y/m/d H:i'); ?></li>
</ul>
</div>