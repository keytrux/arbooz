<?php

  namespace WpBetterPermalinks\Plugin;

  class Uninstall
  {
    public function __construct()
    {
      register_uninstall_hook(WBP_FILE, ['WpBetterPermalinks\Plugin\Uninstall', 'removePluginSettings']);
    }

    /* ---
      Functions
    --- */

    public static function removePluginSettings()
    {
      delete_option('wbp_settings');
      delete_option('wbp_terms');
      delete_option('wbp_notice_hidden');

      /* ---
        Older versions
      --- */
      delete_option('wbp_posts');
      delete_option('wbp_posts_redirects');
      delete_option('wbp_terms_redirects');
      delete_transient('wp_better_permalinks_notice');
    }
  }