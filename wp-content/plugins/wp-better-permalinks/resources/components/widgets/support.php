<div class="wbpPage__widget">
  <h3 class="wbpPage__widgetTitle wbpPage__widgetTitle--second">
    <?= __('We are waiting for your message', 'wp-better-permalinks'); ?>
  </h3>
  <div class="wbpContent">
    <p>
      <?= __('Do you have a technical problem? Please contact us. We will be happy to help you. Or maybe you have an idea for a new feature? Please let us know about it by filling the support form. We will try to add it!', 'wp-better-permalinks'); ?>
    </p>
    <p>
      <?= sprintf(
        __('Please %scheck our FAQ%s before adding a thread with technical problem. If you do not find help there, %scheck support forum%s for similar problems.', 'wp-better-permalinks'),
        '<a href="https://wordpress.org/plugins/wp-better-permalinks/#faq" target="_blank">',
        '</a>',
        '<a href="https://wordpress.org/support/plugin/wp-better-permalinks/" target="_blank">',
        '</a>'
      ); ?>
    </p>
    <p>
      <a href="https://wordpress.org/support/plugin/wp-better-permalinks/#new-post" target="_blank" class="wbpButton wbpButton--blue">
        <?= __('Get help', 'wp-better-permalinks'); ?>
      </a>
    </p>
    <p>
      <?= __('Do you like our plugin? Could you rate him? Please let us know what you think about our plugin. It is important that we can develop this tool. Thank you for all the ratings, reviews and donates.', 'wp-better-permalinks'); ?>
    </p>
    <p>
      <a href="https://wordpress.org/support/plugin/wp-better-permalinks/reviews/#new-post" target="_blank" class="wbpButton wbpButton--blue">
        <?= __('Add review', 'wp-better-permalinks'); ?>
      </a>
    </p>
  </div>
</div>