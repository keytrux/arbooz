<?php

  namespace WpBetterPermalinks\Plugin;

  class Activation
  {
    public function __construct()
    {
      register_activation_hook(WBP_FILE, [$this, 'refreshRewriteRules']);
    }

    /* ---
      Functions
    --- */

    public function refreshRewriteRules()
    {
      flush_rewrite_rules(true);
    }
  }