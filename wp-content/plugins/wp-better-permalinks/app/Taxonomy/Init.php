<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Init
  {
    public function __construct()
    {
      add_action('init', [$this, 'loadActions']);
    }

    /* ---
      Functions
    --- */

    public function loadActions()
    {
      $postTypes = apply_filters('wbp_config', []);

      foreach ($postTypes as $postType => $taxonomy) {
        new Actions($taxonomy, $postType);
      }
    }
  }