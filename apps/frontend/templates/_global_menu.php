<?php
/**
 * グローバルメニュー
 * @param $div_id divに設定するID
 */

// 単一ページパスのマッチング
$compare_function1 = function($path) use ($pathinfo)
{
    return ($pathinfo == $path) ? true : false;
};

// 下の階層も含めたマッチング
$compare_function2 = function($path) use ($pathinfo)
{
    return (preg_match(sprintf('|^%s|i', $path), $pathinfo)) ? true : false;
};
$class_on = array('class'=>'this');
?>
      <div id="<?php echo $div_id ?>">
        <ul>
          <li><?php echo link_to_option_selectable(
          'ホーム',
          '/',
          $compare_function1,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          '日本Symfonyユーザー会とは',
          '/about',
          $compare_function1,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          'Symfonyについて',
          '/about-symfony',
          $compare_function2,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          'ニュース',
          '/news/',
          $compare_function2,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          'イベント',
          '/events/',
          $compare_function2,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          'ブログ',
          '/blog/',
          $compare_function2,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          '日本語ドキュメント',
          '/docs',
          $compare_function2,
          null,
          $class_on) ?></li>
          <li><?php echo link_to_option_selectable(
          'コミュニティ',
          '/community',
          $compare_function2,
          null,
          $class_on) ?></li>
          <?php include_partial('global/global_admin_menu') ?>
        </ul>
      </div>
      <!-- end #navbar -->
