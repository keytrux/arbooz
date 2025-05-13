<?php

  namespace WpBetterPermalinks\Posttype;

  class Rewrites
  {
    public function __construct()
    {
      add_action('generate_rewrite_rules', [$this, 'generateRewriteRules'], 10);
    }

    /* ---
      Functions
    --- */

    public function generateRewriteRules($rewriteObject)
    {
      $taxonomies = array_flip(apply_filters('wbp_config', []));
      $rewrites   = apply_filters('wbp_rewrites', []);
      if (!$rewrites) return $rewriteObject;

      $list = [];
      foreach ($rewrites as $rewrite) {
        preg_match('/index.php\?([^&]+)=/', $rewrite['path'] . '&page=1', $matches);
        if (!$matches || !isset($taxonomies[$matches[1]])) continue;

        $regexPath = 'index.php?post_type=' . $taxonomies[$matches[1]] . '&name=$matches[1]';
        $rewrites  = [
          $rewrite['regex'] . '(/([^/]+))+/?$' => $regexPath,
        ];

        global $sitepress; // Support for WPML
        if ($sitepress) {
          $regexLang = preg_replace('/^(?:(?:[a-z]{2}\/)?)(.*)/', '${1}', $rewrite['regex']);
          if ($regexLang !== $rewrite['regex']) {
            $rewrites[$regexLang . '(/([^/]+))+/?$'] = $regexPath;
          }
        }

        $list += apply_filters('wbp_rewrites_rules/post_type', $rewrites, $taxonomies[$matches[1]], $rewrite['regex']);
      }

      $rewriteObject->rules = $list + $rewriteObject->rules;
      return $rewriteObject->rules;
    }
  }