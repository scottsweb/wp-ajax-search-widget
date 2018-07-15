![WP Ajax Search Widget](https://scott.ee/images/wp-ajax-search-widget.png)

# WP Ajax Search Widget

* Status: ✔ Active
* Contributors: [@scottsweb](http://twitter.com/scottsweb)
* Description: Displays instant search results directly beneath a search widget.
* Author: [Scott Evans](http://scott.ee)
* Author URI: [http://scott.ee](http://scott.ee)
* License: GNU General Public License v2.0
* License URI: [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)

## About

WP Ajax Search Widget is a replacement for the standard search widget. Instead of redirecting you to a new search page the results are returned underneath the search input with an option to click through to the standard results page.

The widget allows you to choose how many results to show.

## Installation

To install this plugin:

* Upload the `wp-ajax-search-widget` folder to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* That's it!

Alternatively you can search for the plugin from your WordPress dashboard and install from there.

Visit [WordPress.org for a comprehensive guide](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation) on in how to install WordPress plugins.

## Hooks & Filters

The plugin has one filter that allows you adjust the search query parameters:

```
add_filter('wpasw_query', 'my_wp_query_array');
```

The plugin also has the following hooks for adding your own content at various points:

```
wpasw_before_widget
wpasw_after_widget
wpasw_before_results
wpasw_after_results
```

By placing the following template parts within a /parts/ folder in your theme you can also overwrite the HTML output:

```
parts/widget-ajax-search-result.php
parts/widget-ajax-search-more.php
parts/widget-ajax-search-fail.php
```

## Frequently Asked Questions

...

## Changelog

#### 1.1
* Performance improvements
* Code standards and formatting

#### 1.0
* Initial release

