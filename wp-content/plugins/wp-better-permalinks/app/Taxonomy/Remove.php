<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Remove
  {
    /* ---
      Functions
    --- */

    public function removeRewriteRule($termId)
    {
      $save = new Save();
      $save->removeRewrite($termId);
    }
  }