<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Register
  {
    public function __construct()
    {
      add_filter('register_taxonomy_args', [$this, 'updateTaxonomyArgs'], 10, 3);
    }

    /* ---
      Functions
    --- */

    public function updateTaxonomyArgs($args, $taxonomy, $objectType)
    {
      $config = array_flip(apply_filters('wbp_config', []));
      if (!isset($config[$taxonomy]) || !$config[$taxonomy]
        || !isset($args['hierarchical']) || !$args['hierarchical']) return $args;

      $args['rewrite']['hierarchical'] = true;
      return $args;
    }
  }