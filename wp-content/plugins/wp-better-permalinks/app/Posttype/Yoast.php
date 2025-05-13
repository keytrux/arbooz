<?php

  namespace WpBetterPermalinks\Posttype;

  class Yoast
  {
    public function __construct()
    {
      add_filter('wbp_term_primary', [$this, 'getPrimaryTermForPost'], 10, 4);
    }

    /* ---
      Functions
    --- */

    public function getPrimaryTermForPost($termId, $postId, $taxonomy, $rewrites)
    {
      $yoastTermId = get_post_meta($postId, '_yoast_wpseo_primary_' . $taxonomy, true);
      if (!$yoastTermId || !isset($rewrites[$yoastTermId])) return $termId;

      return $yoastTermId;
    }
  }