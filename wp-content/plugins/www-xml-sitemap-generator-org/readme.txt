=== XML Sitemap Generator for Google ===
Contributors: XmlSitemapGenerator 
Tags: google, google sitemaps, seo, xml sitemap
Donate link: https://xmlsitemapgenerator.org/contribute/subscribeother.aspx?service=wordpress
Requires at least: 5.1.0
Tested up to: 6.0
Stable tag: 2.0.7

Improve your websites SEO with a comprehensive, easy to use RSS and XML sitemap plugin. Compatible with Google, Bing, Baidu, Yandex and more.
 
== Description ==

Improve your websites SEO (Search Engine Optimization) and SERP (Search Engine Page Ranking) using an XML Sitemap.

XML Sitemaps, RSS feeds, etc. help search engines understand the content of your website, including Google, Bing, Baidu, Yandex and more

[Google XML Sitemap Generator](https://xmlsitemapgenerator.org/wordpress-sitemap-generator-plugin.aspx) adds powerful and configurable HTML, RSS and XML sitemap features to your website. 

The plugin supports sitemap index files for larger sites and the special News and Image sitemap formats to provide comprehensive coverage for your website.

It works across your entire website creating a detailed sitemap, including all custom posts and taxonomy, which makes it a great companion for plugins such as WooCommerce, bbPress, BuddyPress and more.

A distinct advantage of this plugin is the ability to edit your sitemap defaults for taxonomy and post types, as well as being able to edit individual page and post settings.

UPGRADE NOTE - After upgrading, some users are reporting issues with the XML sitemap index file giving a 404 error/ redirecting to the homepage. If you have this issue please deactivate then reactive the plugin.  If you have any further issues please contact support.

**Features include:**

* HTML, RSS and Google XML Sitemap formats.
* News sitemap and image sitemap support.
* Sitemap index support for larger websites.
* List all your WordPress Pages, Posts, Archives, Authors, Categories and Tags.
* Support for custom post types and taxonomy.
* Includes paged links for posts for Archives, Authors, Categories and Tags.
* Set global sitemap default values for priority and update frequencies.
* Set sitemap value for priority and frequency at the category, tag, post and page level.
* Automatic daily auto ping when you have updated pages / posts in WordPress.
* Add latest pages / posts RSS feed to page header.
* Automatically adds sitemap entries to your robots.txt file.
* Add custom entries to your robots.txt file.
* Compatible with WooCommerce, bbPress, BuddyPress and more.

**New features**

We're always seeking to improve and update. 
Stay in touch via [facebook](https://www.facebook.com/XmlSitemapGenerator) and [Twitter](https://twitter.com/createsitemaps)

== Frequently Asked Questions ==

= How easy is it to setup? =

Very easy! Simply install via the wordpress plugin library and activate it.

Go to the XML sitemap settings page and if we alert you to any problems with permalinks, etc. follow the simple instructions to fix these.

That's it, you're up and running.

= Do you support the special images and news sitemap formats? =

Yes. Both are available simply enable them in the settings.

= Where can I find my sitemap / robots.txt files? =

We create these pages dynamically so you will not find them in your control panel / file system.

Go to the XML sitemap settings page and on the right hand side you will see a list of links to the various pages we produce.

= Why do I get a blank page or 404 error? =

This usually happens when your permalinks are not set up correctly.

We will alert you to this when you go to the XML sitemap settings page.

Simply go to the Permalinks settings page and make sure you are NOT using plain links.

= Why does google think my sitemap is HTML? =

You may have submitted the wrong link. It should be www.yourwebsiteaddress.something/xmlsitemap.xml

Another reason this happens is when your permalinks are not set up correctly.

We will alert you to this when you go to the XML sitemap settings page.

Simply go to the permalinks settings page and make sure you are NOT using plain links.

= Why does google say my website / pages are blocked? =

This is usually because of a problem with your robots.txt file or Wordpress is adding a noindex nofollow meta tag.

This is a problem with your "Search Engine Visibility" on the "Reading settings" page.

We will alert you to this when you go to the XML sitemap settings page.

Simply go to the Reading Settings page and ensure "Discourage search engines from indexing this site" is NOT ticked.

= I'm still having problems what can I do? =

* Check out our [trouble shooting](http://blog.xmlsitemapgenerator.org/2016/06/troubleshooting-your-wordpress-sitemap.html) blog post.
* If you are still stuck get in touch via the settings page and we'll try to help.


== Installation ==

1. We recommend you install Google XML Sitemap Generator via the WordPress.org plugin directory.
2. After activating it usually just works!
3. To make sure click the "Settings" menu and select "XML Sitemap".
4. If you get any alerts about permalinks and search engine visibility, follow the links to fix these.

You should now be up and running, but you may also want to :

5. Change the sitemap global defaults for pages, posts, etc.
4. Configure tag, category, post and page level settings when adding / editing them.

**Still having problems?**

* Check out our [trouble shooting](http://blog.xmlsitemapgenerator.org/2016/06/troubleshooting-your-wordpress-sitemap.html) blog post.

== Screenshots ==

1. Global sitemap settings 1 
2. Global sitemap settings 2
3. Edit settings per category / tag
4. Edit settings per post / page
5. XML Sitemap index page
6. XML Sitemap news page
7. XML sitemap page with images
8. Sitemap entries in Robots.txt


== Changelog ==

= 2.0.7 =
Release Date: May 14th, 2022
* Push hot fix for bug in 2.06

= 2.0.6 =
Release Date: May 12th, 2022
* New : Tested for Wordpress 6.0
* Fix : Added timezone correction to dates.
* Fix : Added missing escaping.
* Fix : Archives showing with zero posts
* Fix : Updated various code quality issues.

= 2.0.5 =
Release Date: April 29th, 2022
* To ensure hot fix from 2.0.4 gets pushed to all users.
* In hindshight 2.0.4 should have been 2.1.0.
* Sorry for any problems.

= 2.0.4 =
Release Date: April 28th, 2022
* New : Set an empty sitemap file to disable a given map.
* Fix : Index file showing news twice.
* Fix : Archive provider rendered regardless of settings
* Fix : Erroneous variables in archive provider.
* Fix : Added WP sanitize and esc filters
* Fix : Enqueue scripts instead of inline.
* Fix : Stable tag.
* Fix : Removed analytics.
* Fix : Remove latest archive from XML index.

= 2.0.3 =
Release Date: February 6th, 2022
* New : Tested up to WordPress 5.9
* Fix : security fix - validate sitemap renderer
* Fix : multi-site activation

= 2.0.2 =
Release Date: August 19th, 2021
* Fix : PHP debug / log errors xmlRenderer.php when images disabled.
* Fix : Post settings not updating.
* Fix : News sitemap missing language tag.
* Fix : News not working due to bad database upgrade script.
* Fix : Activation issues on network installs.

= 2.0.1 =
Release Date: February 11th, 2021
* Fix : Activation issue.
* Fix : Sitemap index "Invalid content" issue.
* Fix : Exclude setting not working.

= 2.0.0 =
Release Date: February 7th, 2021

* New : Tested up to WordPress 5.6.1
* New : Support for sitemap index files
* New : Support for image sitemaps
* New : Support for news sitemaps
* New : Support for larger sitemaps
* New : Rearchitected to improve maintainability and performance
* Fix : Incorrect robots.txt entries
* Fix : Category / Tag editing fields

UPGRADE NOTE - After upgrading, some users are reporting issues with the XML sitemap index file giving a 404 error/ redirecting to the homepage. If you have this issue please deactivate then reactive the plugin.  If you have any further issues please contact support.

= 1.3.5 =
Release Date: July 11th, 2020

* New : Tested up to WordPress 5.4.
* New : Edit the sitemap filenames
* New : Set sitemap values per author/user.
* New : Include scheduled posts.
* Fix : Authors variable undefined debug output
* Fix : Page options do not work for multisite/network
* Fix : Incorrect sitemap values due to ID collisions
* Fix : Settings link on network plugins
* Fix : Google ping url

= 1.3.4 =
Release Date: February 28th, 2017

* Fix : Archive reporting incorrect number of pages

= 1.3.2 and 1.3.3 =
Release Date: February 3rd, 2017

* New : Warning if your website is hidden from search engines
* New : Warning about permalink settings
* Fix : Non escaped urls cause invalid sitemap

= 1.3.1 =
Release Date: January 26th, 2017

* Fix : Custom taxonomy, tags & categories not displaying

= 1.3.0 =
Release Date: September 7th, 2016

* New : Support for custom post types and taxonomy
* New : Add custom entries to you robot.txt file.


= 1.2.3 =
Release Date: April 5th, 2016

* Fix : Network / multi-site activation issue
* Fix : robots.txt bug calling addRobotLinks()
* Fix : Errors due to conflicts with some plugin's

= 1.2.2 =
Release Date: December 16th, 2015

* Fix : Duplicate homepage when using a static page

= 1.2.1 =
Release Date: September 23rd, 2015

* Fix : Unexpected out put when activating
* Fix : Missing Hourly update frequency
* Fix : PHP warnings in sitemaps when in debug mode

= 1.2 =
Release Date: September 2nd, 2015

* Fix : invalid sitemap due to default value

= 1.1 =
Release Date: July 27nd, 2015

* Fix : RSS sitemap date format issue
* Fix : XML sitemap date issue
* Fix : Pagination counting pages
* Fix : Logging null value error
* Fix : Ping issues

= 1.0 =
Release Date: July 23rd, 2015
Release Post: http://blog.xmlsitemapgenerator.org/2015/07/wordpress-xml-sitemap-generator.html

* Initial release

