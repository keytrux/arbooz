<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Add
  {
    private $taxonomy, $postType;

    public function __construct($taxonomy, $postType)
    {
      $this->taxonomy = $taxonomy;
      $this->postType = $postType;
    }

    /* ---
      Functions
    --- */

    public function addRewriteRule($termId)
    {
      $term    = get_term_by('id', $termId, $this->taxonomy);
      $url     = apply_filters('wbp_term_link', '', $term, $this->taxonomy);
      $path    = $this->getTermPath($url, $term);
      $rewrite = 'index.php?' . $term->taxonomy . '=' . $term->slug;

      $save = new Save();
      $save->addRewrite($termId, $path, $rewrite);
    }

    private function getTermPath($url, $term)
    {
      $postType = get_post_type_object($this->postType);
      $taxonomy = get_taxonomy($this->taxonomy);

      $path  = '/' . trim(parse_url($url, PHP_URL_PATH), '/') . '/';
      $path  = str_replace($taxonomy->rewrite['slug'], $postType->rewrite['slug'], $path);
      $parts = explode('/', trim($path, '/'));
      return implode('/', $parts);
    }
  }