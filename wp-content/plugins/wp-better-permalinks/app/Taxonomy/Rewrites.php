<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Rewrites
  {
    public function __construct()
    {
      add_action('generate_rewrite_rules', [$this, 'generateRewriteRules'], 20);
    }

    /* ---
      Functions
    --- */

    public function generateRewriteRules($rewriteObject)
    {
      $rewrites = apply_filters('wbp_rewrites', []);
      if (!$rewrites) return $rewriteObject;

      $list = [];
      foreach ($rewrites as $rewrite) {
        preg_match('/index.php\?([^&]+)=([^&]+)/', $rewrite['path'] . '&page=1', $matches);
        if (!$matches) continue;

        $list[$rewrite['regex'] . '/page/([0-9]+)/?$'] = $rewrite['path'] . '&paged=$matches[1]';
        $list[$rewrite['regex'] . '/?$']               = $rewrite['path'];

        $list += apply_filters('wbp_rewrites_rules/taxonomy', [
          $rewrite['regex'] . '/page/([0-9]+)/?$' => $rewrite['path'] . '&paged=$matches[1]',
          $rewrite['regex'] . '/?$'               => $rewrite['path'],
        ], $matches[1], $matches[2], $rewrite['regex']);
      }

      $rewriteObject->rules = $list + $rewriteObject->rules;
      return $rewriteObject->rules;
    }
  }