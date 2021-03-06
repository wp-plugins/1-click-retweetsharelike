=== Plugin Name ===

Contributors: linksalpha
Tags: social media, social media buttons, like, facebook, facebook like, twitter, retweet, tweet, widget, plugin, images, social plugins, Post, google, admin, social posts, posts, shares, comments, sidebar, likes, page, image, social networks, buttons, counters, social media, social, links, comments, social, Blogger, Delicious, Diigo, Foursquare, Plurk, Sonico, Tumblr, Typepad, Yahoo Meme, Yammer, Status.net, socialcast, p2, tumblr, linkedin share, google +1, google plus one, google plusone, google plus, chrome extension, firefox extension, safari extension
Requires at least: 2.0.2
Tested up to: 3.5.1
Stable tag: 5.2


== Description ==

Shows following 8 buttons on your blog posts:

1. Google +1
1. Facebook Like
1. Facebook Share
1. Twitter button
1. LinkedIn Share
1. StumbleUpon
1. Digg
1. Email

AND, Facebook Recommendations in the Widgets Sidebar


Demo the plugin at - http://dev30.linksalpha.com/?p=8


Plugin also enables you to `Automatically Publish` or `Self Publish` your `Blog Posts to 30+ Networks`.

1. Facebook Profile/Wall
1. Facebook Pages
1. Facebook Events
1. Facebook Groups
1. Twitter
1. LinkedIn
1. MySpace
1. Yammer
1. Identi.ca
1. Status.net
1. Socialcast
1. Plurk
1. Sonico
1. Delicious
1. Diigo
1. Foursquare
1. Wordpress.com Blog
1. Wordpress.org Blog
1. Blogger
1. Tumblr
1. Typepad
1. Yahoo Meme


**Browser Extensions**

We are excited to announce launch of [LinksAlpha.com](http://www.linksalpha.com) browser extensions for Chrome, Firefox, or Safari. These extensions enable quick and easy posting to your social profiles from your browser. Below are the download links:

1. [Chrome](https://chrome.google.com/webstore/detail/ffifmkcjncgmnnmkedgkiabklmjdmpgi)
1. [Firefox](http://www.linksalpha.com/downloads/app?id=980907126)
1. [Safari](http://www.linksalpha.com/downloads/app?id=980926069)


**List of Features**

* 1-click Retweet
* 1-click Facebook Share
* 1-click Facebook Like
* Displays counts next to the buttons
* Offers consistent UI: aligned buttons and uniform color selection
* Gives visual indication after the blog post is Retweeted/Shared/Liked. See screenshot at http://cdn.linksalpha.com/static/1clickedwidget.png
* View Weekly Stats to track total number of Blog Posts, Tweets, Bitly Clicks, Facebook Comments, Facebook Likes, and Facebook Shares.
* View status of your blog posts to each network - whether the blog post has been published, when it was published, etc. 
* Using advanced features such as categories, automatically post selected blog posts to a subset of networks.


**Benefits**

* Enable your users to retweet, share and like your blog posts to their Twitter followers and Facebook friends.
* Keep your fans, followers, and connections automatically updated on your blog posts.
* Expand your blog reach and save time by letting the plugin publish your blog posts - automatically.


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

* For getting support, email us at: post@linksalpha.com
* Note: We encourage you to download the latest version of the plugin as soon as it becomes available - as it may have additional extremely useful features for your blog.


== Installation ==
1. Upload la-click-and-share.zip to '/wp-content/plugins/' directory and unzip it.
2. Activate the Plugin from "Manage Plugins" window


== Frequently Asked Questions ==

= After plugin upgrade it doesn't work? =

Deactivate and then Activate the plugin. If by default it shows as 'activated', then click on 'deactivate' and then click on 'activate'. 

= What if I have more questions? =

Go to http://help.linksalpha.com/1-click-retweet-share-like for getting started help documents.

= Question still not answered? =

Email us at post@linksalpha.com


== Screenshots ==
1. Social 1-click Retweet/Share/Like buttons
2. List of supported networks for automatic publishing
3. 1-click Retweet/Share/Like widget in the WordPress Post Editor window


== Changelog ==

= 5.2 =
* Bug fixes.
* Readme cleanup

= 5.1 =
* Added support to manually re-publish posts to Facebook, Twitter and LinkedIn.

= 5.0.1 =
* Minor Fix

= 5.0 =
* Users can now add message to their Facebook and LinkedIn posts.
* Users can now add Twitter Handle and Twitter Hash in their posts.
* Users can view the publish results on the 1-click Retweet/Share/Like's settings page.

= 4.9.1 =
* Minor Fix for AJSAX requests

= 4.9 =
* Minor Fix

= 4.8 =
* javascript bug fix

= 4.7 =
* Added 4 new options
* Minor Fixes

= 4.6 =
* Fixes to Postbox

= 4.5.3 =
* Minor bug fix

= 4.5.2 =
* Minor bug fix

= 4.5.0 =
* Added timeout to HTTP calls
* Added option to hide from mobile browsers

= 4.4.0 =
* Added new options
* Minor bug fix

= 4.3.2 =
* Minor bug fix

= 4.3.1 =
* Minor bug fix

= 4.3 =
* Support for Custom post type and xmlrpc for publishing to networks
* Show hide buttons on Posts and Pages
* Referral tracking for analytics
* Minor bug fixes

= 4.2 =
* Minor bug fixes

= 4.1.4 =
* Bug fix
* Language support for Google Buzz button

= 4.1.3 =
* Bug fix

= 4.1.2 =
* Bug fix

= 4.1.1 =
* Added Support for Facebook Opengraph tags
* Ability to show/hide buttons

= 4.1.0 =
* Adds Support for Google +1

= 4.0.0 =
* Adds Support for Google Buzz, Digg, and StumbleUpon
* Users will now have to add their LinksAlpha user key, instead of network key

= 3.6.0 =
* Adds Support to self Post content to connected Networks. Submenu option under - Posts - in Admin console
* Added option to show/hide Twitter and Facebook Share counters
* Minor bug fixes

= 3.5.0 =

* Options added for Facebook Like button
* Options added for Twitter button
* Options added for Publishing

= 3.1.0 =

* Plugin now uses official Twitter button instead of ReTweet button from LinksAlpha.com
* Plugin now detects if user has PuSHPress plugin installed. Helps in faster publishing

= 3.0.0 =

* New functionality: ability to Automatically Publish your blog posts to 30 Networks!
