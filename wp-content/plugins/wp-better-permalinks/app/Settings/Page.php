<?php

  namespace WpBetterPermalinks\Settings;

  class Page
  {
    public function __construct()
    {
      add_action('admin_menu', [$this, 'addSettingsPage']);
    }

    /* ---
      Functions
    --- */

    public function addSettingsPage()
    {
      if (is_network_admin()) return;

      add_submenu_page(
        'options-general.php',
        'WP Better Permalinks',
        'WP Better Permalinks',
        'manage_options',
        'wbp_admin_page',
        [$this, 'showSettingsPage']
      );
    }

    public function showSettingsPage()
    {
      require_once WBP_PATH . 'resources/views/settings.php';
    }
  }