<?php

  namespace WpBetterPermalinks;

  class WpBetterPermalinks
  {
    public function __construct()
    {
      new Admin\_Core();
      new Plugin\_Core();
      new Posttype\_Core();
      new Settings\_Core();
      new Taxonomy\_Core();
    }
  }