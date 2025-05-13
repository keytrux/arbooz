<?php

  namespace WpBetterPermalinks\Settings;

  class Save
  {
    private $option = 'wbp_settings';

    public function __construct()
    {
      add_action('admin_init', [$this, 'initSaving']);
    }

    /* ---
      Functions
    --- */

    public function initSaving()
    {
      if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'wbp-save')
        || !$this->savePostTypes()) return;

      $nonce = wp_create_nonce('wbp-refresh');
      $url   = admin_url(sprintf('options-general.php?page=wbp_admin_page&wbp_success=1&_wpnonce=%s', $nonce));
      wp_redirect($url);
    }

    private function savePostTypes()
    {
      if (!isset($_POST['wbp_save'])) return;

      $value = $this->getSelectedTypes();
      $this->saveOption($value);
      return true;
    }

    private function getSelectedTypes()
    {
      $types = apply_filters('wbp_posttypes', []);
      $list  = [];

      foreach ($types as $type) {
        $key = sprintf('wbp_%s', $type['slug']);
        if (!isset($_POST[$key]) || !$_POST[$key]
          || !in_array($_POST[$key], array_column($type['values'], 'slug'))
          || in_array($_POST[$key], $list)) continue;
        $list[$type['slug']] = $_POST[$key];
      }
      return $list;
    }

    private function saveOption($value)
    {
      if (get_option($this->option, false) !== false) update_option($this->option, $value);
      else add_option($this->option, $value);
    }
  }