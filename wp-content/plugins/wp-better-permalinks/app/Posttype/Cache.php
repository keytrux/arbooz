<?php

  namespace WpBetterPermalinks\Posttype;

  class Cache
  {
    private $metaKey = 'wbp_term';

    public function __construct()
    {
      add_filter('wbp_post_term', [$this, 'getTermForPost'],      10, 3);
      add_action('save_post',     [$this, 'clearPostTermCache'], 100, 2);
    }

    /* ---
      Functions
    --- */

    public function getTermForPost($originalTermId, $postId, $taxonomy)
    {
      if (($savedTermId = get_post_meta($postId, $this->metaKey, true))
        || ($savedTermId === '0')) return $savedTermId;

      $termId = $this->getTermIdForPost($postId, $taxonomy);
      update_post_meta($postId, $this->metaKey, $termId);
      return $termId;
    }

    private function getTermIdForPost($postId, $taxonomy)
    {
      $terms = get_the_terms($postId, $taxonomy);
      if (!$terms) return 0;

      $rewrites = apply_filters('wbp_rewrites', []);
      foreach ($terms as $term) {
        if (!isset($rewrites[$term->term_id])) continue;
        return apply_filters('wbp_term_primary', $term->term_id, $postId, $taxonomy, $rewrites);
      }
      return 0;
    }

    public function clearPostTermCache($postId, $post)
    {
      $config = apply_filters('wbp_config', []);
      if (!isset($config[$post->post_type]) || !$config[$post->post_type]) return;

      update_post_meta($postId, $this->metaKey, null);
    }
  }