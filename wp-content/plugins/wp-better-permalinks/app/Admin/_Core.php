<?php

  namespace WpBetterPermalinks\Admin;

  class _Core
  {
    public function __construct()
    {
      new Assets();
      new Notice();
      new Plugin();
    }
  }