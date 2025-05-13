<?php

  namespace WpBetterPermalinks\Posttype;

  class Link
  {
    public function __construct()
    {
      add_action('post_type_link', [$this, 'replaceLink'], 100, 3);
    }

    /* ---
      Functions
    --- */

    public function replaceLink($original, $post, $leavename)
    {
      $config = apply_filters('wbp_config', []);
      if (!isset($config[$post->post_type]) || !$config[$post->post_type]) return $original;

      $termId = apply_filters('wbp_post_term', null, $post->ID, $config[$post->post_type]);
      if (!$termId || (!$rewrites = apply_filters('wbp_rewrites', []))
        || !isset($rewrites[$termId])) return $original;

      return $this->generatePostLink($original, $post, $leavename, $rewrites[$termId]);
    }

    private function generatePostLink($original, $post, $leavename, $rewrite)
    {
      $postPath  = trim(parse_url($original, PHP_URL_PATH), '/');
      $postParts = explode('/', $postPath);

      $termParts = $this->getTermsParts($rewrite['regex'], $postPath);
      $slugIndex = count($postParts) - 1;
      $parts     = array_merge(
        array_slice($postParts, 0, $slugIndex),
        $termParts,
        array_slice($postParts, $slugIndex)
      );
      return str_replace($postPath, implode('/', $parts), $original);
    }

    private function getTermsParts($termPath, $postPath)
    {
      $postParts = explode('/', $postPath);
      $termParts = explode('/', $termPath);

      foreach ($termParts as $index => $value) {
        if (isset($postParts[$index]) && ($value === $postParts[$index])) {
          unset($termParts[$index]);
        }
      }
      return $termParts;
    }
  }