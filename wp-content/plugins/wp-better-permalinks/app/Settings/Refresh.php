<?php

  namespace WpBetterPermalinks\Settings;

  use WpBetterPermalinks\Taxonomy\Add as Add;

  class Refresh
  {
    private $option = 'wbp_terms';

    public function __construct()
    {
      add_action('admin_init', [$this, 'refreshRedirects']);
    }

    /* ---
      Functions
    --- */

    public function refreshRedirects()
    {
      if (!is_admin() || !isset($_REQUEST['wbp_success'])
        || !isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'wbp-refresh')) return;

      $this->resetTermsCache();
      $this->updateTermsCache();
      flush_rewrite_rules(true);
    }

    private function resetTermsCache()
    {
      if (get_option($this->option, false) !== false) update_option($this->option, []);
      else add_option($this->option, []);
    }

    private function updateTermsCache()
    {
      if (!$taxonomies = apply_filters('wbp_config', [])) return;

      foreach ($taxonomies as $postType => $taxonomy) {
        $termIds = $this->getTermsList($taxonomy);
        $this->updateTermsForTaxonomy($termIds, $taxonomy, $postType);
      }
    }

    private function getTermsList($taxonomy)
    {
      global $sitepress; // Support for WPML (terms for all langs)
      if ($sitepress) {
        remove_filter('get_terms_args', [$sitepress, 'get_terms_args_filter']);
        remove_filter('get_term',       [$sitepress, 'get_term_adjust_id']);
        remove_filter('terms_clauses',  [$sitepress, 'terms_clauses']);
      }

      $list = get_terms($taxonomy, [
        'hide_empty' => false,
        'fields'     => 'ids',
        'lang'       => [],
      ]);
      return $list;
    }

    private function updateTermsForTaxonomy($termIds, $taxonomy, $postType)
    {
      if (!$taxonomies = apply_filters('wbp_config', [])) return;

      foreach ($termIds as $termId) {
        $module = new Add($taxonomy, $postType);
        $module->addRewriteRule($termId);
      }
    }
  }