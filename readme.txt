=== Reactor: Core ===
Contributors: apppresser, modemlooper, scottopolis, webdevstudios, williamsba1, messenlehner, lisasabinwilson, tw2113
Tags: android, android app, App, application, iOS, ios app, iphone app, mobile, mobile app, native app, wordpress mobile
Requires at least: 3.9
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Reactor: Core connects your site to mobile apps built with Reactor: Builder.

== Description ==
Reactor: Core connects your site to mobile apps built with Reactor: Builder. Adds JSON API endpoints to allow custom data in your Reactor powered apps. To utilize this plugin you will need an active account at http://reactor.apppresser.com.

[youtube https://www.youtube.com/watch?v=65L90xeK-4c]

Sign up now and start creating mobile apps for your WordPress sites! http://reactor.apppresser.com

Includes all WP-API endpoints
Adds /wp-json/reactor/media *this is an endpoint for media galleries
Adds /wp-json/posts?type=product *if WooCommerce is installed Woo meta is added to CPT

== Installation ==
Activate plugin and the JSON API is available to Reactor.

NOTE: This plugin contains the master branch of JSON API from https://github.com/WP-API/WP-API. The master branch contains fixes and is more up to date than the 1.1.1 version in the repo. This plugin will deactivate the 1.1.1 version of the WP-API plugin if installed as to not cause conflicts. When the API is finally in WordPress core then we will remove the API from Reactor: Core.

== Frequently Asked Questions ==


== Upgrade Notice ==


== Changelog ==
= 0.2.2 =
fix undefined array in woo api

= 0.2.1 =
wp-api security fix

= 0.2 =
wp-api security fix

= 0.1.2 =
Authentication (login) 

= 0.1.1 =
add custom featured image sizes for usage in app

= 0.1 =
remove unused inappbrowser code

= 0.0.9 =
Gravity form support

= 0.0.8 =
Woo add to cart functionality

= 0.0.7 =
add args to API get_comments

= 0.0.6 =
Bumped up size of woo product thumbnail

= 0.0.5 =
Fix woo currency symbol

= 0.0.4 =
Fix url issues in landing page.

= 0.0.3 =
Fix valid plugin header errors upon activation

= 0.0.2 =
Initial release
