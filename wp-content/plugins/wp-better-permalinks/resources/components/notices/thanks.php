<div class="notice notice-success is-dismissible" data-notice="wp-better-permalinks" data-url="<?= apply_filters('wbp_notice_url', ''); ?>">
  <div class="wbpContent wbpContent--notice">
    <h4>
      <?= __('Thank you for using our plugin WP Better Permalinks!', 'wp-better-permalinks'); ?>
    </h4>
    <p>
      <?= sprintf(
        __('Please let us know what you think about our plugin. It is important that we can develop this tool. Thank you for all the ratings, reviews and donates. If you have a technical problem, please before you add a review %scheck our FAQ%s or contact us if you did not find help there. We will try to help you!', 'wp-better-permalinks'),
        '<a href="https://wordpress.org/plugins/wp-better-permalinks/#faq" target="_blank">',
        '</a>'
      ); ?>
    </p>
    <div class="wbpContent__buttons">
      <a href="https://wordpress.org/plugins/wp-better-permalinks/#new-post" target="_blank"
        class="wbpContent__button wbpButton wbpButton--green">
        <?= __('Get help', 'wp-better-permalinks'); ?>
      </a>
      <a href="https://wordpress.org/support/plugin/wp-better-permalinks/reviews/#new-post" target="_blank"
        class="wbpContent__button wbpButton wbpButton--green">
        <?= __('Add review', 'wp-better-permalinks'); ?>
      </a>
      <a href="https://ko-fi.com/gbiorczyk/?utm_source=wp-better-permalinks&utm_medium=notice-thanks" target="_blank"
        class="wbpContent__button wbpButton wbpButton--green dashicons-heart">
        <?= __('Provide us a coffee', 'wp-better-permalinks'); ?>
      </a>
      <button type="button" data-permanently
        class="wbpContent__button wbpButton wbpButton--blue">
        <?= __('I added review, do not show again', 'wp-better-permalinks'); ?>
      </button>
    </div>
  </div>
</div>
