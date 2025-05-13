=== WP Better Permalinks ===
Contributors: mateuszgbiorczyk
Donate link: https://ko-fi.com/gbiorczyk/?utm_source=wp-better-permalinks&utm_medium=readme-donate
Tags: friendly permalinks, permalinks structure, taxonomy term permalinks, custom post type permalinks, permalinks tree
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.0
Stable tag: 4.1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Set custom friendly permalinks structure: Custom Post Type > Taxonomy > Post and Custom Post Type > Taxonomy instead of default WordPress structure.

== Description ==

Set custom friendly permalinks structure: **Custom Post Type > Taxonomy > Post** and **Custom Post Type > Taxonomy** instead of default WordPress structure.

Default permalinks structure in WordPress:

* Custom Post Type > Post
* Taxonomy > Single Term

Friendly permalinks structure pattern available using this plugin:

* Custom Post Type > Single Term *(or Term tree)* > Post
* Custom Post Type > Post *(when no term is selected)*
* Custom Post Type > Single Term *(or Term tree)*

The plugin allows you to set your own structure with a few clicks. Everything works automatically, no need to add any additional code.

#### Please also read the FAQ below. Thank you for being with us!

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/wp-better-permalinks` directory, or install plugin through the WordPress plugins screen directly.
2. Activate plugin through `Plugins` screen in WordPress Admin Panel.
3. Use `Settings -> WP Better Permalinks` screen to configure the plugin.

== Frequently Asked Questions ==

= How does the plugin work? =

To start with, you should add Custom Post Types and Taxonomies assigned to them. Without this, the plugin will not work because it creates a friendly link structure of Custom Post Type and Taxonomy.

Then on the plugin settings page you can choose Taxonomy for each Custom Post Type that will be preferred for building URLs.

You can create your own Custom Post Types and Taxonomies using the built-in functions in WordPres or additional plugins.

Finally, just save the plugin settings and the new structure for links will work.

= How do I register Custom Post Type and Taxonomy to set up permalink structure for them? =

You can use the Wordpress features: [register_post_type](https://codex.wordpress.org/Function_Reference/register_post_type) and [register_taxonomy](https://codex.wordpress.org/Function_Reference/register_taxonomy) or use any plugin for this. It is important to set visibility as `public` in arguments.

= Does the plugin modify Custom Post Type and Taxonomy settings? =

Yes. Minor corrections are made to allow the plugin to work properly.

In the case of Custom Post Type, the value of `hierarchical` is set to `false`. If set to `true`, the parent post servant is displayed in the link. The child post may have a different category, which would cause URL mismatch.

For Taxonomy, set the `hierarchical` value in the `rewrite` section for hierarchical terms. Thanks to this, we keep the tree structure, which is very important.

= Can I choose one Taxonomy for several Custom Post Types? =

Unfortunately not. This possibility is not available. You can assign Taxonomy to only one Custom Post Type.

Adding one Taxonomy to many Custom Post Types settings will not be saved.

= How are links created? =

Links are created according to the structure:
* Custom Post Type > Single Term *(or Term tree)* > Post
* Custom Post Type > Post *(when no term is selected)*
* Custom Post Type > Single Term *(or Term tree)*

If you choose more than one category for a post, the first one is always taken.

= Is the plugin completely free? =

Yes. The plugin is completely free.

However, working on plugins and technical support requires many hours of work. If you want to appreciate it, you can [provide us a coffee](https://ko-fi.com/gbiorczyk/?utm_source=wp-better-permalinks&utm_medium=readme-faq). Thanks everyone!

Thank you for all the ratings and reviews.

If you are satisfied with this plugin, please recommend it to your friends. Every new person using our plugin is valuable to us.

This is all very important to us and allows us to do even better things for you!

== Screenshots ==

1. Screenshot of the options panel

== Changelog ==

= 4.1.1 (2021-05-22) =
* `[Fixed]` Closing notice in admin panel

= 4.1.0 (2020-10-28) =
* `[Fixed]` Generating Rewrite Rules for WPML

= 4.0.2 (2020-10-18) =
* `[Added]` Filter `wbp_rewrites_rules/post_type`
* `[Added]` Filter `wbp_rewrites_rules/taxonomy`

= 4.0.1 (2020-07-15) =
* `[Fixed]` Error 404 on Taxonomy Page
* `[Fixed]` Generating Rewrite Rules after saving settings

= 4.0.0 (2020-06-29) =
* `[Removed]` Withdrawal of support for 301 redirects *(since version 3.0.0)*
* `[Changed]` Performance optimization
* `[Changed]` Plugin structure
* `[Changed]` New settings page
* `[Changed]` New admin notice
* `[Changed]` Minor fixes

= 3.0.9 (2019-08-22) =
* `[Added]` Support for WPML *(for Custom Post Types)*

= 3.0.8 (2019-08-22) =
* `[Fixed]` Support for multiple domains

= 3.0.7 (2019-07-02) =
* `[Fixed]` Generation URL for Post Type

= 3.0.6 (2019-06-30) =
* `[Added]` Support for Post Ancestors

= 3.0.5 (2019-06-26) =
* `[Fixed]` UTF-8 characters in URLs
* `[Changed]` Security changes

= 3.0.4 (2019-01-15) =
* `[Removed]` Support for `future` Post Status

= 3.0.3 (2018-10-29) =
* `[Fixed]` Loading of assets

= 3.0.2 (2018-10-23) =
* `[Added]` Possibility of manually editing post slug
* `[Added]` Possibility of permanent turn off admin notice
* `[Added]` Default hidden admin notice

= 3.0.1 (2018-05-28) =
* `[Added]` Support for Yoast SEO plugin *(Primary category)*

= 3.0.0 (2018-05-05) =
* `[Fixed]` Minor fixes
* `[Changed]` Changes in plugin structure
* `[Added]` Automatic update of post slug
* `[Added]` 301 redirects for old links
* `[Added]` Support for internationalization

= 2.1.4 (2018-03-22) =
* `[Changed]` Improved rewrite rules

= 2.1.3 (2018-03-13) =
* `[Added]` Cleaning old rewrite rules after saving settings

= 2.1.2 (2018-03-09) =
* `[Added]` Support for `future` Post Status

= 2.1.1 (2018-03-09) =
* `[Fixed]` Error 404 on pagination pages

= 2.1.0 (2018-02-26) =
* `[Added]` Cleaning database after removing plugin

= 2.0.1 (2018-02-22) =
* `[Changed]` Method of saving settings

= 2.0.0 (2018-02-08) =
* `[Changed]` New plugin core
* `[Changed]` Improved performance and reliability
* `[Added]` Support for category hierarchy in permalinks
* `[Added]` Support for Polylang plugin

= 1.0.1 (2017-12-21) =
* `[Changed]` Admin notice

= 1.0.0 (2017-10-03) =
* The first stable release
