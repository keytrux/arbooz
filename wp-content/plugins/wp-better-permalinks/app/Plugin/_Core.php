<?php

  namespace WpBetterPermalinks\Plugin;

  class _Core
  {
    public function __construct()
    {
      new Activation();
      new Deactivation();
      new Install();
      new Uninstall();
    }
  }