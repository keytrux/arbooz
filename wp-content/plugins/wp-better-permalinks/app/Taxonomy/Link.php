<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Link
  {
    public function __construct()
    {
      add_filter('term_link',     [$this, 'replaceLink'], 100, 3);
      add_filter('wbp_term_link', [$this, 'getTermLink'], 10,  3);
    }

    /* ---
      Functions
    --- */

    public function replaceLink($original, $term, $taxonomy)
    {
      $rewrites = apply_filters('wbp_rewrites', []);
      if (!isset($rewrites[$term->term_id])) return $original;

      $path = trim(parse_url($original, PHP_URL_PATH), '/');
      return str_replace($path, $rewrites[$term->term_id]['regex'], $original);
    }

    public function getTermLink($value, $termId, $taxonomy)
    {
      remove_filter('term_link', [$this, 'replaceLink'], 100, 3);
      return get_term_link($termId, $taxonomy);
      add_filter('term_link', [$this, 'replaceLink'], 100, 3);
    }
  }