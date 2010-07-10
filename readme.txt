=== Plugin Name ===

Contributors: LinksAlpha
Tags: like, facebook like, facebook, widget, plugin, twitter, retweet, tweet, images, social plugins, Post, google, admin, social posts, posts, shares, comments, sidebar, likes, page, image, social networks, buttons, counters, social media, social, links, comments, social networks, social.
Requires at least: 2.0.2
Tested up to: 3.0.0
Stable tag: 2.0.1


== Description ==

Lets users Retweet, Share and Like pages from your site back to their Twitter followers and Facebook friends with just one click. *The user experience is similar to Facebook Like button but expanded to Twitter and Facebook Share as well ! Screenshot: http://cdn.linksalpha.com/static/1clickwidget.png*

**Plugin allows 1-click sharing for best user experience for the most popular social networks:**

* 1-click Retweet
* 1-click Facebook Share
* 1-click Facebook Like
* Displays counts next to the buttons
* Offers consistent UI: aligned buttons and uniform color selection
* Gives visual indication after the blog post is Retweeted/Shared/Liked. See screenshot at http://cdn.linksalpha.com/static/1clickedwidget.png

You can interact with the plugin at http://dev30.linksalpha.com/?p=8


**Manual positioning**

For Manually positioning the 1-click Retweet/Share/Like on your blog you need to do the following two things:

1. Place the following code `<?php lacands_wp_filter_content_widget(); ?>` in index.php file or any other file as you see appropriate in themes folder (...\wordpress\wp-content\themes). Note: if you are using 'default' theme for the Wordpress plugin, then place the above code in single.php 
(...\wordpress\wp-content\themes\default\single.php)

2. On admin page for this plugin ('1-click Retweet/Share/Like'), check the box next to "Disable displaying 1-click Retweet/Share/Like (for Manual Option Only - see readme.txt)" under "1-Click Social Widget Position & Colors" and submit by clicking on 'Save Changes'.


**Admin Options**

* Option to show the buttons at top, bottom, or both top and bottom of the blog post
* Option to set margins for the buttons
* Option to place the buttons manually
* Select pages on which buttons should be visible: home and archive (default: single/home/archive)
* Select Font Styles for Retweet/Share/Like: arial, tahoma, lucida grande, segoe ui, trebuchet ms, verdana
* Select Counter Colors (any color) for Retweet and Facebook Share (For Facebook Like, option not available from Facebook)
* Option to change 'Like' text to 'Recommend'


**Misc**

* For getting support, email us at: discuss@linksalpha.com
* Note: We encourage you to download the latest version of the plugin as soon as it becomes available - as it may have additional extremely useful features for your blog.


**Check out Network Publisher plugin:**

* `Automatically Publishes` your `Blog Posts to Social Networks`: Facebook Profile, Facebook Pages, Twitter, LinkedIn, Yahoo, Yammer, Identi.ca, and MySpace. 
* Download plugin from http://wordpress.org/extend/plugins/network-publisher/
* Plugin also supports `Publishing your Blog Posts to Twitter` via `OAuth`


== Installation ==
1. Upload la-click-and-share.zip to '/wp-content/plugins/' directory and unzip it.
2. Activate the Plugin from "Manage Plugins" window

For support email us at: discuss@linksalpha.com. 


== Frequently Asked Questions ==

= After plugin upgrade it doesn't work? =

Deactivate and then Activate the plugin. If by default it shows as 'activated', then click on 'deactivate' and then click on 'activate'. 

= What if I have more questions? =

Go to http://help.linksalpha.com/1-click-retweet-share-like/faqs for list of FAQs and corresponding answers.

= Question still not answered? =

Email us at discuss@linksalpha.com


== Screenshots ==
1. Social 1-click Retweet/Share/Like buttons


== Changelog ==
= 2.0.1 =

Multiple fixes and enhancements

* Fix for iframe - as for some themes it was taking more space
* Fix for sharing URLs with international languages (i.e., other than English)
* Option to select pages on which buttons should be visible: home, single page, archive
* Option to select Font Styles for Retweet/Share/Like: arial, tahoma, lucida grande, segoe ui, trebuchet ms, verdana
* Option to select Counter Colors (any color) for Retweet and Facebook Share (For Facebook Like, option not available from Facebook)
* Option to change 'Like' to show as text 'Recommend'
* Text for 'Share' changes to 'Shared' after the article is shared