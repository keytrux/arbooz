<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Actions
  {
    private $taxonomy, $postType, $termChildren = [];

    public function __construct($taxonomy, $postType)
    {
      $this->taxonomy = $taxonomy;
      $this->postType = $postType;

      add_action('created_' . $taxonomy, [$this, 'addRewriteRule']);
      add_action('edited_' . $taxonomy,  [$this, 'addRewriteRule'],      10);
      add_action('edited_' . $taxonomy,  [$this, 'loadTermChildren'],    20, 1);
      add_action('edited_' . $taxonomy,  [$this, 'refreshTermChildren'], 30);
      add_action('pre_delete_term',      [$this, 'loadTermChildren'],    10, 2);
      add_action('delete_' . $taxonomy,  [$this, 'removeRewriteRule'],   10);
      add_action('delete_' . $taxonomy,  [$this, 'refreshTermChildren'], 20);
    }

    /* ---
      Functions
    --- */

    public function addRewriteRule($termId)
    {
      $module = new Add($this->taxonomy, $this->postType);
      $module->addRewriteRule($termId);

      $cache = apply_filters('wbp_rewrites', [], true);
      flush_rewrite_rules(false);
    }

    public function loadTermChildren($termId, $taxonomy = null)
    {
      if ($this->termChildren || (($taxonomy !== null) && ($taxonomy !== $this->taxonomy))) return;

      $this->termChildren = get_term_children($termId, $this->taxonomy);
    }

    public function refreshTermChildren($termId)
    {
      if (!$this->termChildren) return;

      foreach ($this->termChildren as $termChild) {
        $this->addRewriteRule($termChild);
      }
    }

    public function removeRewriteRule($termId)
    {
      $module = new Remove();
      $module->removeRewriteRule($termId);

      $cache = apply_filters('wbp_rewrites', [], true);
      flush_rewrite_rules(false);
    }
  }