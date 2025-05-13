<div class="wbpPage__widget">
  <h3 class="wbpPage__widgetTitle wbpPage__widgetTitle--second">
    <?= __('How does this work?', 'wp-better-permalinks'); ?>
  </h3>
  <div class="wbpContent">
    <p>
      <?= sprintf(__('Plugin sets custom friendly permalinks structure: %sCustom Post Type > Taxonomy > Post%s and %sCustom Post Type > Taxonomy%s instead of default WordPress structure.', 'wp-better-permalinks'),
        '<strong>',
        '</strong>',
        '<strong>',
        '</strong>'
      ); ?>
    </p>
    <p>
      <?= __('Default permalinks structure in WordPress:', 'wp-better-permalinks'); ?>
    </p>
    <ul>
      <li><?= __('Custom Post Type > Post', 'wp-better-permalinks'); ?></li>
      <li><?= __('Taxonomy > Single Term', 'wp-better-permalinks'); ?></li>
    </ul>
    <p>
      <?= __('Friendly permalinks structure pattern available using this plugin:', 'wp-better-permalinks'); ?>
    </p>
    <ul>
      <li><?= __('Custom Post Type > Single Term (or Term tree) > Post', 'wp-better-permalinks'); ?></li>
      <li><?= __('Custom Post Type > Post (when no term is selected)', 'wp-better-permalinks'); ?></li>
      <li><?= __('Custom Post Type > Single Term (or Term tree)', 'wp-better-permalinks'); ?></li>
    </ul>
  </div>
</div>