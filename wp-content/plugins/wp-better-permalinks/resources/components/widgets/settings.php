<?php
  $postTypes = apply_filters('wbp_posttypes', []);
  $config    = apply_filters('wbp_config', []);
?>
<div class="wbpPage__widget">
  <h3 class="wbpPage__widgetTitle">
    <?= __('Settings', 'wp-better-permalinks'); ?>
  </h3>
  <div class="wbpContent">
    <div class="wbpPage__widgetRow">
      <?php if ($postTypes) : ?>
        <?php include WBP_PATH . '/resources/components/settings/post-types.php'; ?>
      <?php else : ?>
        <p><?= __('Saving the settings now will reset them.', 'wp-better-permalinks'); ?></p>
      <?php endif; ?>
    </div>
    <div class="wbpPage__widgetRow">
      <button type="submit" name="wbp_save"
        class="wbpButton wbpButton--green"><?= __('Save Changes', 'wp-better-permalinks'); ?></button>
    </div>
    <div class="wbpPage__widgetRow">
      <p><?= sprintf(__('To use the plugin, please add Custom Post Type and Taxonomy assigned to it to enable a friendly link structure. You can use %sregister_post_type%s and %sregister_taxonomy%s functions or additional plugin. You can assign one Taxonomy to one Post Type.', 'wp-better-permalinks'),
        '<a href="https://codex.wordpress.org/Function_Reference/register_post_type" target="_blank">',
        '</a>',
        '<a href="https://codex.wordpress.org/Function_Reference/register_taxonomy" target="_blank">',
        '</a>'
      ); ?></p>
    </div>
  </div>
</div>