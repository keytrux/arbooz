<?php

  namespace WpBetterPermalinks\Posttype;

  class _Core
  {
    public function __construct()
    {
      new Cache();
      new Link();
      new Register();
      new Rewrites();
      new Yoast();
    }
  }