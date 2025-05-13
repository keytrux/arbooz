<?php

  namespace WpBetterPermalinks\Settings;

  class _Core
  {
    public function __construct()
    {
      new Config();
      new Options();
      new Page();
      new Refresh();
      new Save();
    }
  }