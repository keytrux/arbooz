<?php

  namespace WpBetterPermalinks\Admin;

  class Assets
  {
    public function __construct()
    {
      add_filter('admin_enqueue_scripts', [$this, 'loadStyles']);
      add_filter('admin_enqueue_scripts', [$this, 'loadScripts']);
    }

    /* ---
      Functions
    --- */

    public function loadStyles()
    {
      wp_register_style('wp-better-permalinks', WBP_URL . 'public/build/css/styles.css', '', WBP_VERSION);
      wp_enqueue_style('wp-better-permalinks');
    }

    public function loadScripts()
    {
      wp_register_script('wp-better-permalinks', WBP_URL . 'public/build/js/scripts.js', 'jquery', WBP_VERSION, true);
      wp_enqueue_script('wp-better-permalinks');
    }
  }