<?php

  namespace WpBetterPermalinks\Taxonomy;

  class _Core
  {
    public function __construct()
    {
      new Init();
      new Link();
      new Register();
      new Rewrites();
    }
  }