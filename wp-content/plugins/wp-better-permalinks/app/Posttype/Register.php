<?php

  namespace WpBetterPermalinks\Posttype;

  class Register
  {
    public function __construct()
    {
      add_filter('register_post_type_args', [$this, 'updatePosttypeArgs'], 10, 2);
    }

    /* ---
      Functions
    --- */

    public function updatePosttypeArgs($args, $postType)
    {
      $config = apply_filters('wbp_config', []);
      if (!isset($config[$postType]) || !$config[$postType]) return $args;

      $args['hierarchical'] = false;
      return $args;
    }
  }