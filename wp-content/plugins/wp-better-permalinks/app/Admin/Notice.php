<?php

  namespace WpBetterPermalinks\Admin;

  class Notice
  {
    private $option = 'wbp_notice_hidden';

    public function __construct()
    {
      add_filter('wbp_notice_url',     [$this, 'showNoticeUrl']); 
      add_action('admin_notices',      [$this, 'showAdminNotice']);
      add_action('wp_ajax_wbp_notice', [$this, 'hideAdminNotice']);
    }

    /* ---
      Functions
    --- */

    public function showNoticeUrl()
    {
      $url = admin_url('admin-ajax.php?action=wbp_notice');
      return $url;
    }

    public function showAdminNotice()
    {
      if (($_SERVER['PHP_SELF'] !== '/wp-admin/index.php') ||
        (get_option($this->option, 0) >= time())) return;

      require_once WBP_PATH . 'resources/components/notices/thanks.php';
    }

    public function hideAdminNotice()
    {
      $isPermanent = isset($_POST['is_permanently']) && $_POST['is_permanently'];
      $expires     = strtotime($isPermanent ? '+10 years' : '+ 1 month');

      $this->saveOption($expires);
    }

    public function saveOption($value)
    {
      if (get_option($this->option, false) !== false) update_option($this->option, $value);
      else add_option($this->option, $value);
    }
  }