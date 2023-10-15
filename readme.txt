=== Sync Pinboard ===
Contributors: magicroundabout
Tags: pinboard, sync, bookmarks
Requires at least: 5.1
Tested up to: 6.1
Stable tag: 1.0.1
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
* provides a Gutenberg/block editor block for display a list of pins created between two specified dates

Note that this plugin does a one-way sync from Pinboard to your WordPress install. You can add your own bookmarks in WordPress but they will not be added to Pinboard.

= Instructions =

Once you have installed the plugin you will need to go to Settings -> Pinboard Sync and enter your API key
(you can get this from your [Pinboard password settings screen](https://pinboard.in/settings/password))

If you want to do automatic sync then you can then also turn on the Auto-sync option.

If you have a lot of pins in Pinboard then it is not recommended that you turn on auto-sync right away as this will probably time out or do bad things.

If you are able then the recommended method for doing a large initial import is to use the bundled wp-cli command: `wp-cli sync-pinboard`

= WP-CLI command =

If you can use [WP-CLI](https://wp-cli.org/) then you can make use of the `wp-cli sync-pinboard` command to
do an import from Pinboard. This works particularly well for large first-time imports before you enable the automatic sync. But you could also use the system cron to run this command instead of WP cron.

= Wish list / Roadmap =

Things I have in mind for future development:

* A shortcode for outputting lists of pins
* Ability to only import a specified tag
* (DONE) A Gutenberg block for displaying pins
* Option in wp-cli command to allow re-import of all pins
* Better front-end validation in admin screens and meta boxes
* Better error logging, and logging in general, including WP-CLI-specific output
* Better intial automated sync (over multiple cron runs)

== Installation ==

Once you have installed and activated the plugin, follow the instructions in the description.

== Screenshots ==

1. Options screen
2. List of sync'ed pins

== Changelog ==

= 1.0.1 =
* Remove console debug logging

= 1.0 =
* Add Gutenberg/block editor block for displaying pins
* Prevent the pins from appearing in WordPress search by default
* Allow post type options to be filtered so that you can add searching back in

= 0.2.1 =
* Fix ridiculous fatal error from initial commit - my mistake!

= 0.2.0 =
* Renamed from pinboard-sync to sync-pinboard to comply with plugin repo trademark rules
* Added WP-CLI command for sync
* Use the correct timezone when creating pins
* Add notices about support
* Improve validation of settings inputs
* Fix error in initial sync (this was failing safely - the sync just wasn't working)
* Start adding some improved logging
* Fix some warnings that were showing on sync

= 0.1.0 =
* Initial version for release

== Upgrade Notice ==

= 1.0 =
Note that this update removes pins from WordPress search by default

= 0.1.0 =
You should install this, it's great!
