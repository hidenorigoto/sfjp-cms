<?php
$repository_url = $page->getGithubRepositoryUrl();
$page_url       = $page->getGithubUrl();
$history_url    = $page->getGithubHistoryUrl();
?>
<div class="githubinfo">
    <img src="<?php echo public_path('images/github.png') ?>" width="50" height="23">
    <ul>
        <li>リポジトリ：<?php echo link_to($repository_url, $repository_url) ?></li>
        <li>ページ：<?php echo link_to($page_url, $page_url) ?></li>
        <li>コミット履歴：<?php echo link_to($history_url, $history_url) ?></li>
    </ul>
</div>