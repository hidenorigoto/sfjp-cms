<?php if ($sf_user->isAuthenticated()): ?>
    <li><?php echo link_to('リポジトリ管理', '@repository') ?></li>
    <li><?php echo link_to('ユーザー管理', '@sf_guard_user') ?></li>
    <li><?php echo link_to('グループ管理', '@sf_guard_group') ?></li>
    <li><?php echo link_to('パーミッション管理', '@sf_guard_permission') ?></li>
    <li><?php echo link_to('ログアウト', '@sf_guard_signout') ?></li>
<?php endif; ?>