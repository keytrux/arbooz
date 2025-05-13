<?php
  $path = sprintf('%s&_wpnonce=%s', menu_page_url('wbp_admin_page', false), wp_create_nonce('wbp-save'));
?>
<form method="post" action="<?= $path; ?>" class="wbpPage">
  <div class="wbpPage__inner">
    <h1 class="wbpPage__headline"><?= __('WP Better Permalinks', 'wp-better-permalinks'); ?></h1>
    <ul class="wbpPage__columns">
      <li class="wbpPage__column wbpPage__column--large">
        <?php if (isset($_REQUEST['wbp_success'])) : ?>
          <div class="wbpPage__alert"><?= __('Changes were successfully saved!', 'wp-better-permalinks'); ?></div>
        <?php endif; ?>
        <?php
          include WBP_PATH . '/resources/components/widgets/settings.php';
        ?>
      </li>
      <li class="wbpPage__column wbpPage__column--small">
        <?php
          include WBP_PATH . '/resources/components/widgets/about.php';
          include WBP_PATH . '/resources/components/widgets/support.php';
          include WBP_PATH . '/resources/components/widgets/donate.php';
        ?>
      </li>
    </ul>
  </div>
</form>