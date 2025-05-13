<?php

  namespace WpBetterPermalinks\Settings;

  class Options
  {
    public function __construct()
    {
      add_filter('wbp_posttypes', [$this, 'getPostTypes']);
    }

    /* ---
      Functions
    --- */

    public function getPostTypes()
    {
      $list = $this->getExistsPostTypes();
      return $list;
    }

    private function getExistsPostTypes()
    {
      $list = get_post_types(
        [
          'public'             => true,
          'publicly_queryable' => true,
          '_builtin'           => false,
        ],
        'objects'
      );
      return $this->parsePostTypes($list);
    }

    private function parsePostTypes($types)
    {
      $list = [];
      foreach ($types as $key => $type) {
        $list[] = $this->parsePostType($type);
      }
      return $list;
    }

    private function parsePostType($object)
    {
      return [
        'slug'   => $object->name,
        'label'  => $object->label,
        'values' => array_merge([
          [
            'slug'  => '',
            'label' => '-',
          ],
        ], $this->getTaxonomiesForPostType($object->name)),
      ];
    }

    private function getTaxonomiesForPostType($slug)
    {
      $list = get_object_taxonomies($slug, 'objects');
      return $this->parseTaxonomies($list);
    }

    private function parseTaxonomies($taxonomies)
    {
      $list = [];
      foreach ($taxonomies as $key => $taxonomy) {
        if (!$taxonomy->public) continue;
        $list[] = $this->parseTaxonomy($taxonomy);
      }
      return $list;
    }

    private function parseTaxonomy($object)
    {
      return [
        'slug'  => $object->name,
        'label' => $object->label,
      ];
    }
  }