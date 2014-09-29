=== WP Ajax Search Widget ===
Contributors: scottsweb, codeforthepeople
Tags: search, ajax, instant, results, widget, form, searching, quick, sidebar, filter, action, extensible
Requires at least: 3.8
Tested up to: 4.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays instant search results directly beneath a search widget.

== Description ==

WP Ajax Search Widget is a replacement for the standard search widget but instead of redirecting you to a new search page the results are returned underneath the search input with an option to click through to the standard results page.

The widget allows you to choose how many results to show.

== Installation ==

To install this plugin:

1. Upload the `wp-ajax-search-widget` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That's it!

Alternatively you can search for the plugin from your WordPress dashboard and install from there.

== Frequently Asked Questions ==

= Hooks & Filters =

The plugin has one filter that allows you adjust the search query parameters:

`add_filter('wpasw_query', 'my_wp_query_array');`

The plugin also has the following hooks for adding your own content at various points:

`wpasw_before_widget`
`wpasw_after_widget`
`wpasw_before_results`
`wpasw_after_results`

= Templates =

By placing the following template parts within a /parts/ folder in your theme you can also overwrite the HTML output:

`parts/widget-ajax-search-result.php`
`parts/widget-ajax-search-more.php`
`parts/widget-ajax-search-fail.php`

== Screenshots ==

1. Search results.

== Changelog ==

= 1.0 =
* Initial release
