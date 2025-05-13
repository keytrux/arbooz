<?php

  namespace WpBetterPermalinks\Taxonomy;

  class Save
  {
    private $optionTerms = 'wbp_terms';

    /* ---
      Functions
    --- */

    public function addRewrite($termId, $regex, $path)
    {
      $value          = get_option($this->optionTerms, []);
      $value[$termId] = [
        'path'  => urldecode($path),
        'regex' => urldecode($regex)
      ];
      $this->saveValue($this->optionTerms, $value);
    }

    public function removeRewrite($termId)
    {
      $value = get_option($this->optionTerms, []);
      if (!isset($value[$termId])) return;

      unset($value[$termId]);
      $this->saveValue($this->optionTerms, $value);
    }

    private function saveValue($name, $value)
    {
      if (get_option($name, false) !== false) update_option($name, $value);
      else add_option($name, $value);
    }
  }