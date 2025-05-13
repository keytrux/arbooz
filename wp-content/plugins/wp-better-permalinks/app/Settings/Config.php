<?php

  namespace WpBetterPermalinks\Settings;

  class Config
  {
    private $config, $rewrites;

    public function __construct()
    {
      add_filter('wbp_config',   [$this, 'getConfig'],   10, 2);
      add_filter('wbp_rewrites', [$this, 'getRewrites'], 10, 2);
    }

    /* ---
      Functions
    --- */

    public function getConfig($value, $isForce = false)
    {
      if ($this->config && !$isForce) return $this->config;

      $config = get_option('wbp_settings', []);
      $this->config = $config;
      return $config;
    }

    public function getRewrites($value, $isForce = false)
    {
      if ($this->rewrites && !$isForce) return $this->rewrites;

      $rewrites = get_option('wbp_terms', []);
      $this->rewrites = $rewrites;
      return $rewrites;
    }
  }