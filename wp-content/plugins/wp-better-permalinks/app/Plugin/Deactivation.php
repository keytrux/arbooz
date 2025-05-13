<?php

  namespace WpBetterPermalinks\Plugin;

  class Deactivation
  {
    public function __construct()
    {
      register_deactivation_hook(WBP_FILE, [$this, 'removePosttypeCache']);
      register_deactivation_hook(WBP_FILE, [$this, 'refreshRewriteRules']);
    }

    /* ---
      Functions
    --- */

    public function removePosttypeCache()
    {
      global $wpdb;

      $sql = sprintf('DELETE FROM `%s` WHERE `meta_key` = \'wbp_term\'', $wpdb->postmeta);
      $wpdb->query($sql);
    }

    public function refreshRewriteRules()
    {
      flush_rewrite_rules(true);
    }
  }