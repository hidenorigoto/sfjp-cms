<?php
/**
 * ページ内インデックス
 *
 * @param $page Page
 */
$index = $page->getRawValue()->getIndexJsonDecoded();
?>
<div class="pageindex">
<?php echo renderIndexItemList($index); ?>
</div>