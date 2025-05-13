<?php

  namespace WpBetterPermalinks\Admin;

  class Plugin
  {
    public function __construct()
    {
      add_filter('plugin_action_links_' . WBP_NAME,               [$this, 'addLinkToSettings']);
      add_filter('plugin_action_links_' . WBP_NAME,               [$this, 'addLinkToDonate']);
      add_filter('network_admin_plugin_action_links_' . WBP_NAME, [$this, 'addLinkToDonate']);
    }

    /* ---
      Functions
    --- */

    public function addLinkToSettings($links)
    {
      array_unshift($links, sprintf(
        __('%sSettings%s', 'wp-better-permalinks'),
        '<a href="' . menu_page_url('wbp_admin_page', false) . '">',
        '</a>'
      ));
      return $links;
    }

    public function addLinkToDonate($links)
    {
      $links[] = sprintf(
        __('%sProvide us a coffee%s', 'wp-better-permalinks'),
        '<a href="https://ko-fi.com/gbiorczyk/?utm_source=wp-better-permalinks&utm_medium=plugin-links" target="_blank">',
        '</a>'
      );
      return $links;
    }
  }