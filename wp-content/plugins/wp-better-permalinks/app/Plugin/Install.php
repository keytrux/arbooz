<?php

  namespace WpBetterPermalinks\Plugin;

  class Install
  {
    private $option = 'wbp_notice_hidden';

    public function __construct()
    {
      register_activation_hook(WBP_FILE, [$this, 'addDefaultOptions']);
    }

    /* ---
      Functions
    --- */

    public function addDefaultOptions()
    {
      if (get_option('wbp_notice_hidden', false) !== false) return;

      add_option($this->option, strtotime('+ 1 week'));
    }
  }