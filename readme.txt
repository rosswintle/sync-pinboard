=== Pinboard Sync ===
Contributors: magicroundabout
Tags: pinboard, sync, bookmarks
Requires at least: 5.1
Tested up to: 5.1.1
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Copies bookmarks from pinboard.in into a custom post type.

== Description ==

This plugin copies bookmarks from [pinboard.in](https://pinboard.in/) into a custom post type and the Pinboard tags into a custom taxonomy.

*Note:* This is not an official Pinboard plugin. If you have any problems please direct them to the WordPress support forums for this plugin.

This plugin:

* runs automatically using either wp-cron or manually using [wp-cli](https://wp-cli.org/)
* uses the official Pinboard API (you will need your API key)
* obeys the API's rate limits
* allows you to choose an author for synced pins
* updates pins in pinboard that have been updated (I think!) but will not remove pins that have been deleted

Note that this is a one-way sync from Pinboard to your WordPress install. You can add your own bookmarks in WordPress
but they will not be added to Pinboard.

= Instructions =

Once you have installed the plugin you will need to go to Settings -> Pinboard Sync and enter your API key
(you can get this from your [Pinboard password settings screen](https://pinboard.in/settings/password))

If you want to do automatic sync then you can then also turn on the Auto-sync option.

If you have a lot of pins in Pinboard then it is not recommended that you turn on auto-sync right away as this will probably time out or do bad things.

If you are able then the recommended method for doing a large initial import is to use the bundled wp-cli command: `wp-cli pinboard-sync` - this will be available soon in a future version of the plugin.

= Wish list / Roadmap =

Things I have in mind for future development:

* Create WP-CLI sync command
* A shortcode for outputting lists of pins
* Ability to only import a specified tag
* A Gutenberg block for displaying pins
* Better error logging, and logging in general, including WP-CLI-specific output

== Installation ==

Once you have installed and activated the plugin, follow the instructions in the description.

== Screenshots ==

1. Options screen
2. List of sync'ed pins

== Changelog ==

= 0.1.0 =
* Initial version for release

== Upgrade Notice ==

= 0.1.0 =
You should install this, it's great!
