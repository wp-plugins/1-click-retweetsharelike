<?php
/*
Plugin Name: 1-click Retweet/Share/Like
Plugin URI: http://wwww.linksalpha.com/publish
Description: Adds Facebook Like, Facebook Share, Twitter, and LinkedIn Share buttons to your wordpress blog. Automatically publish your blog posts to 30 Social Networks.
Author: LinksAlpha
Author URI: http://www.linksalpha.com/publish
Version: 3.5.0
*/

/*
    Copyright (C) 2010 LinksAlpha.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a  copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require("la-click-and-share-utility-fns.php");
require("la-click-and-share-networkpub.php");

define('LACANDS_PLUGIN_URL', 			 lacands_get_plugin_dir());
define('LAECHONW_WIDGET_NAME', 			 '1-click Retweet/Share/Like');
define('LACANDSNW_WIDGET_NAME_INTERNAL', 'lacandsnw_networkpub');
define('LACANDSNW_WIDGET_PREFIX',        'lacandsnw_networkpub');
define('LACANDSNW_NETWORKPUB', 			 'Automatically publish your blog posts to 30 Social Networks including Facebook,Twitter,LinkedIn,Yahoo,Yammer,MySpace,Identi.ca');
define('LACANDSNW_ERROR_INTERNAL',       'internal error');
define('LACANDSNW_ERROR_INVALID_URL',    'invalid url');
define('LACANDSNW_ERROR_INVALID_KEY',    'invalid key');

$lacandsnw_networkpub_settings['api_key'] = array('label'=>'API Key:', 'type'=>'text', 'default'=>'');
$lacandsnw_networkpub_settings['id']      = array('label'=>'id', 'type'=>'text', 'default'=>'');
$lacandsnw_options                        = get_option(LACANDSNW_WIDGET_NAME_INTERNAL);

$lacands_version_number = '3.5.0';

function lacands_init() {
	global $lacands_version_number;
			
	$lacands_version_number_db = get_option('lacands-html-version-number');
	
	if($lacands_version_number != $lacands_version_number_db) {
		update_option('lacands-html-version-number', $lacands_version_number);
		lacands_writeOptionsValuesToWPDatabase('default');
	}
}

function lacands_readOptionsValuesFromWPDatabase() {
	global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout, $lacandsnw_opt_warning_msg;
	global $lacands_opt_widget_fb_ref, $lacands_opt_widget_fb_like_lang, $lacands_opt_widget_twitter_lang, $lacands_opt_widget_twitter_mention, $lacands_opt_widget_twitter_related1, $lacands_opt_widget_twitter_related2, $lacands_opt_widget_linkedin_button;

	$lacands_opt_widget_counters_location     = get_option('lacands-html-widget-counters-location');
	$lacands_opt_widget_margin_top            = get_option('lacands-html-widget-margin-top');
	$lacands_opt_widget_margin_right          = get_option('lacands-html-widget-margin-right');
	$lacands_opt_widget_margin_bottom         = get_option('lacands-html-widget-margin-bottom');
	$lacands_opt_widget_margin_left           = get_option('lacands-html-widget-margin-left');
	$lacands_widget_disable_cntr_display      = get_option('lacands-html-widget-disable-cntr-display');
	$lacands_opt_cntr_font_color              = get_option('lacands-html-cntr-font-color');
	$lacands_opt_widget_fb_like               = get_option('lacands-html-widget-fb-like');
	$lacands_opt_widget_font_style            = get_option('lacands-html-widget-font-style');
	$lacands_opt_widget_fb_ref            	  = get_option('lacands-html-widget-fb-ref');
	$lacands_opt_widget_fb_like_lang          = get_option('lacands-html-widget-fb-like-lang');
	$lacands_opt_widget_twitter_lang          = get_option('lacands-html-widget-twitter-lang');
	$lacands_opt_widget_twitter_mention       = get_option('lacands-html-widget-twitter-mention');
	$lacands_opt_widget_twitter_related1      = get_option('lacands-html-widget-twitter-related1');
	$lacands_opt_widget_twitter_related2      = get_option('lacands-html-widget-twitter-related2');
	$lacands_opt_widget_linkedin_button		  = get_option('lacands-html-widget-linkedin-button');
	$lacands_display_pages            	  	  = get_option('lacands-html-display-pages');
	$lacands_like_layout            	  	  = get_option('lacands-html-like-layout');
	$lacandsnw_opt_warning_msg                = get_option('lacandsnw-html-warning-msg');
}

function lacands_writeOptionsValuesToWPDatabase($option) {
	global $lacands_display_pages;
	global $lacands_version_number;

	if($option == 'default') {		
		$lacands_eget = get_bloginfo('admin_email'); $lacands_uget = get_bloginfo('url'); $lacands_nget = get_bloginfo('name');
		$lacands_dget = get_bloginfo('description'); $lacands_cget = get_bloginfo('charset'); $lacands_vget = get_bloginfo('version');
		$lacands_lget = get_bloginfo('language'); $link='http://www.linksalpha.com/a/bloginfo';
		$lacands_bloginfo = array('email'=>$lacands_eget, 'url'=>$lacands_uget, 'name'=>$lacands_nget, 'desc'=>$lacands_dget, 'charset'=>$lacands_cget, 'version'=>$lacands_vget, 'lang'=>$lacands_lget, 'plugin'=>'cs');
		lacands_http_post($link, $lacands_bloginfo);
		$lacands_display_pages = array('single' => '1','home' => '1','archive' => '1');
		add_option('lacands-html-widget-counters-location', 'beforeAndafter');
		add_option('lacands-html-widget-margin-top',    '5');
		add_option('lacands-html-widget-margin-right',  '0');
		add_option('lacands-html-widget-margin-bottom', '5');
		add_option('lacands-html-widget-margin-left',   '0');
		add_option('lacands-html-widget-disable-cntr-display-after', '0');
		add_option('lacands-html-cntr-font-color', '333333');
		add_option('lacands-html-widget-fb-like', 'like');
		add_option('lacands-html-widget-font-style', 'arial');
		add_option('lacands-html-widget-fb-ref', 'facebook');
		add_option('lacands-html-widget-fb-like-lang', 'en_US');
		add_option('lacands-html-widget-twitter-lang', 'en');
		add_option('lacands-html-widget-twitter-mention', 'en');
		add_option('lacands-html-widget-twitter-related1', 'en');
		add_option('lacands-html-widget-twitter-related2', 'en');
		add_option('lacands-html-widget-linkedin-button', 'noshow');
		add_option('lacands-html-display-pages', $lacands_display_pages);
		add_option('lacands-html-like-layout', 'button_count');
		update_option('lacands-html-version-number', $lacands_version_number);
		add_option('lacandsnw-html-warning-msg', '0');
	}
	else if ($option == 'update')
	{
		if(!empty($_POST['lacands-html-widget-counters-location'])) {
			update_option('lacands-html-widget-counters-location', $_POST['lacands-html-widget-counters-location']);
		}

		if($_POST['lacands-html-widget-margin-top'] != NULL) {
    		update_option('lacands-html-widget-margin-top',    (string)$_POST['lacands-html-widget-margin-top']);
		}
		else {
			update_option('lacands-html-widget-margin-top',    '0');
		}

		if($_POST['lacands-html-widget-margin-right'] != NULL) {
    		update_option('lacands-html-widget-margin-right',  (string)$_POST['lacands-html-widget-margin-right']);
		}
		else {
			update_option('lacands-html-widget-margin-right',    '0');
		}

    	if($_POST['lacands-html-widget-margin-bottom'] != NULL) {
    		update_option('lacands-html-widget-margin-bottom', (string)$_POST['lacands-html-widget-margin-bottom']);
    	}
		else {
			update_option('lacands-html-widget-margin-bottom',    '0');
		}

    	if($_POST['lacands-html-widget-margin-left'] != NULL) {
    		update_option('lacands-html-widget-margin-left',   (string)$_POST['lacands-html-widget-margin-left']);
    	}
		else {
			update_option('lacands-html-widget-margin-left',    '0');
		}

    	if(!empty($_POST['lacands-html-widget-disable-cntr-display'])) {
			update_option('lacands-html-widget-disable-cntr-display',   (string)$_POST['lacands-html-widget-disable-cntr-display']);
		}
		else {
			update_option('lacands-html-widget-disable-cntr-display', '0');
		}

	    if(!empty($_POST['lacands-html-cntr-font-color'])) {
	    	update_option('lacands-html-cntr-font-color',(string)$_POST['lacands-html-cntr-font-color']);
	    }
	    else {
	    	update_option('lacands-html-cntr-font-color', '333333');
	    }

	    if(!empty($_POST['lacands-html-widget-fb-like'])) {
	    	update_option('lacands-html-widget-fb-like',(string)$_POST['lacands-html-widget-fb-like']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-like', 'Like');
	    }

	    if(!empty($_POST['lacands-html-widget-font-style'])) {
	    	update_option('lacands-html-widget-font-style',(string)$_POST['lacands-html-widget-font-style']);
	    }
	    else {
	    	update_option('lacands-html-widget-font-style', 'Like');
	    }
		
		if(!empty($_POST['lacands-html-widget-fb-ref'])) {
	    	update_option('lacands-html-widget-fb-ref',(string)$_POST['lacands-html-widget-fb-ref']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-ref', 'facebook');
	    }
		
		if(!empty($_POST['lacands-html-widget-fb-like-lang'])) {
	    	update_option('lacands-html-widget-fb-like-lang',(string)$_POST['lacands-html-widget-fb-like-lang']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-like-lang', 'Like');
	    }
		
		if(!empty($_POST['lacands-html-widget-twitter-lang'])) {
	    	update_option('lacands-html-widget-twitter-lang',(string)$_POST['lacands-html-widget-twitter-lang']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-like-lang', 'Like');
	    }

		if(!empty($_POST['lacands-html-widget-twitter-mention'])) {
	    	update_option('lacands-html-widget-twitter-mention',(string)$_POST['lacands-html-widget-twitter-mention']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-like-mention', '');
	    }
		
		if(!empty($_POST['lacands-html-widget-twitter-related1'])) {
	    	update_option('lacands-html-widget-twitter-related1',(string)$_POST['lacands-html-widget-twitter-related1']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-like-related1', '');
	    }
		
		if(!empty($_POST['lacands-html-widget-twitter-related2'])) {
	    	update_option('lacands-html-widget-twitter-related2',(string)$_POST['lacands-html-widget-twitter-related2']);
	    }
	    else {
	    	update_option('lacands-html-widget-fb-like-related2', '');
	    }
		
		if(!empty($_POST['lacands-html-widget-linkedin-button'])) {
	    	update_option('lacands-html-widget-linkedin-button',(string)$_POST['lacands-html-widget-linkedin-button']);
	    }
	    else {
	    	update_option('lacands-html-widget-linkedin-button', '');
	    }
		
	    if(!empty($_POST['lacands-html-display-page-home'])) {
		    $lacands_display_pages['home'] = '1';
	    }
	    else {
		    $lacands_display_pages['home'] = '0';
	    }

	    if(!empty($_POST['lacands-html-display-page-archive'])) {
		    $lacands_display_pages['archive'] = '1';
	    }
	    else {
		    $lacands_display_pages['archive'] = '0';
	    }
	   	update_option('lacands-html-display-pages', $lacands_display_pages);

	    if(!empty($_POST['lacands-html-like-layout'])) {
	    	update_option('lacands-html-like-layout', (string)$_POST['lacands-html-like-layout']);
	    }
	    
		if (isset($_POST['warning_msg'])) {
			if(!empty($_POST['lacandsnw-html-warning-msg'])) {
				update_option('lacandsnw-html-warning-msg',  (string)$_POST['lacandsnw-html-warning-msg']);
			}
			else {
				update_option('lacandsnw-html-warning-msg', '0');
			}
		}	    
	}
	else {
		
		/*
		delete_option('lacands-html-widget-counters-location');
		delete_option('lacands-html-widget-margin-top');
		delete_option('lacands-html-widget-margin-right');
		delete_option('lacands-html-widget-margin-bottom');
		delete_option('lacands-html-widget-margin-left');
		delete_option('lacands-html-cntr-font-color');
		delete_option('lacands-html-widget-disable-cntr-display-after');
		delete_option('lacands-html-widget-fb-like');
		delete_option('lacands-html-widget-font-style');
		delete_option('lacands-html-display-pages');
		delete_option('lacands-html-like-layout');
		delete_option('lacands-html-version-number');
		delete_option('lacandsnw-html-warning-msg');
		*/		
	}
}

function lacands_wp_filter_post_content ( $related_content ) {
	global $lacands_opt_widget_counters_location;
	global $lacands_widget_disable_cntr_display;
	
	$lacands_widget_disable_cntr_display  = get_option('lacands-html-widget-disable-cntr-display');
	$lacands_opt_widget_counters_location = get_option('lacands-html-widget-counters-location');

	if($lacands_widget_disable_cntr_display == '0') {
		if($lacands_opt_widget_counters_location == "beforeAndafter") {
			$related_content_beforeAndafter = lacands_wp_filter_content_widget(FALSE);
			$related_content                = $related_content_beforeAndafter.$related_content.$related_content_beforeAndafter;
		}

		else if($lacands_opt_widget_counters_location == "before") {
			$related_content = lacands_wp_filter_content_widget(FALSE).$related_content;
		}

		else if($lacands_opt_widget_counters_location == "after") {
			$related_content = $related_content.lacands_wp_filter_content_widget(FALSE);
		}
	}

	return ($related_content);

}

function lacands_wp_filter_content_widget ($show=TRUE) {
	global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout;
	global $lacands_opt_widget_fb_ref, $lacands_opt_widget_fb_like_lang, $lacands_opt_widget_twitter_lang, $lacands_opt_widget_twitter_mention, $lacands_opt_widget_twitter_related1, $lacands_opt_widget_twitter_related2, $lacands_opt_widget_linkedin_button;
	global $post;

	$p          = $post;

	lacands_readOptionsValuesFromWPDatabase();

	$position = '';

	if( $lacands_widget_disable_cntr_display == '0') {
		$position = 'padding-top:'.$lacands_opt_widget_margin_top.'px;padding-right:'.$lacands_opt_widget_margin_right.'px;padding-bottom:'.$lacands_opt_widget_margin_bottom.'px;padding-left:'.$lacands_opt_widget_margin_left.'px;';
	}

	if ((is_single())  ||   (is_home() && ($lacands_display_pages['home'])) || (is_archive() && ($lacands_display_pages['archive'])) )
	{
		$link1 = urlencode(urldecode(get_permalink($p)));

		$lacands_opt_cntr_font_color = str_replace('#', '', $lacands_opt_cntr_font_color);
		$lacands_opt_cntr_font_color = trim($lacands_opt_cntr_font_color);

		$args = array();
		$args['link'] = htmlentities($link1);
		$args['fc'] = $lacands_opt_cntr_font_color;
		$args['fs'] = $lacands_opt_widget_font_style;
		$args['fblname'] = $lacands_opt_widget_fb_like;
		$args['fblref'] = $lacands_opt_widget_fb_ref;
		$args['fbllang'] = $lacands_opt_widget_fb_like_lang;
		$args['twitterlang'] = $lacands_opt_widget_twitter_lang;
		$args['twittermention'] = $lacands_opt_widget_twitter_mention;
		$args['twitterrelated1'] = $lacands_opt_widget_twitter_related1;
		$args['twitterrelated12'] = $lacands_opt_widget_twitter_related2;
		$args['linkedinbutton'] = $lacands_opt_widget_linkedin_button;
		$args_data = http_build_query($args);
		
    	$lacands_widget_display_cntrs = '<div style="'.$position.';">
										<iframe
											style="height:25px !important; border:none !important; overflow:hidden !important; width:360px !important;" frameborder="0" scrolling="no" allowTransparency="true"
											src="http://www.linksalpha.com/social?'.$args_data.'">
										</iframe>
										</div>';

   		if($show) {
			echo $lacands_widget_display_cntrs;
			return;
		}

	    return $lacands_widget_display_cntrs;
	}
	return;
}

function lacands_wp_admin_options_settings () {
	global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout;
	global $lacandsnw_networkpub_settings;
	global $lacandsnw_opt_warning_msg;
	global $lacands_opt_widget_fb_ref, $lacands_opt_widget_fb_like_lang, $lacands_opt_widget_twitter_lang, $lacands_opt_widget_twitter_mention, $lacands_opt_widget_twitter_related1, $lacands_opt_widget_twitter_related2, $lacands_opt_widget_linkedin_button;

    if (isset($_POST['lacands_widget_update']))
    {
    	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}

    	lacands_writeOptionsValuesToWPDatabase('update');

    	echo '<div id="message" class="updated fade" style="width:1000px;"><p><strong>Settings saved for 1-click Retweet/Share/Like.</strong></p></div>';
		echo '</strong></p></div>';
	}
	
	if (isset($_POST['AddAPIKey']))
    {
    	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}

		$field_name = sprintf('%s_%s', LACANDSNW_WIDGET_PREFIX, 'api_key');
		$value = strip_tags(stripslashes($_POST[$field_name]));
		if($value) {
			$networkadd = lacandsnw_networkpub_add($value);
		}
	}
	
	if (isset($_POST['warning_msg']))
    {
      	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}

		if(!empty($_POST['lacandsnw-html-warning-msg'])) {
			update_option('lacandsnw-html-warning-msg',  (string)$_POST['lacandsnw-html-warning-msg']);
		}
		else {
			update_option('lacandsnw-html-warning-msg', '0');
		}

    	echo '<div id="message" class="updated fade" style="width:1000px;"><p><strong>Warning Msg setting saved.</strong></p></div>';
		echo '</strong></p></div>';
	}
	
	$options    = get_option(LACANDSNW_WIDGET_NAME_INTERNAL);
	$curr_field = 'api_key';
	$field_name = sprintf('%s_%s', LACANDSNW_WIDGET_PREFIX, $curr_field);
	
	lacands_readOptionsValuesFromWPDatabase();

	$lacands_combo_iconWidget = '<img border="0" style="vertical-align:middle; border:1px solid #C0C0C0  " src="'.LACANDS_PLUGIN_URL.'widget.png">';

	require("la-click-and-share-comboAdmin.html");
	
}

function lacands_wp_admin() {
    if (function_exists('add_options_page')) {
        add_options_page('1-click Retweet/Share/Like', '1-click Retweet/Share/Like', 'manage_options', __FILE__, 'lacands_wp_admin_options_settings');
    }
}

function lacands_activate() {
	lacands_writeOptionsValuesToWPDatabase('default');
}

function lacands_deactivate() {
	lacands_writeOptionsValuesToWPDatabase('delete');
}

function lacands_warning() {
	$options          = get_option(LACANDSNW_WIDGET_NAME_INTERNAL);	
	$show_warning_msg = get_option('lacandsnw-html-warning-msg');

	if( ($show_warning_msg == 1) || (!empty($options['api_key']) ) )
	{
		return;
	}
	else {
		echo "<div id='1-click Retweet/Share/Like' class='updated fade' style='width:80%;'>
		      <p>
   			  	<strong>".__('<a href="http://wordpress.org/extend/plugins/1-click-retweetsharelike/" target="_blank">1-click Retweet/Share/Like</a> plugin is almost ready.')."</strong>
			    <ol>
		      ";

		if(empty($options['api_key'])) {
			if (!isset($_POST['AddAPIKey'])) {
			    echo "<li>".sprintf(__('<div style="font-size:11px"><span style=color:#d12424;"><b>Pending:</b></span> For automatic posting of your blog articles to 20+ Social Networks including Twitter, Facebook Profile, Facebook Pages, LinkedIn, MySpace, Yammer, Yahoo, Identi.ca, you must <a href="%1$s">enter API key</a> (under Settings->1-click Retweet/Share/Like->Auto Publish on Social Networks)</div>'),
				"options-general.php?page=1-click-retweetsharelike/la-click-and-share.php")."</li>";
			}
		}

		if(!empty($options['api_key'])) {
			    echo "<li>".sprintf(__('<div style="font-size:11px"><span style=color:#006633;"><b>Done:</b></span>
			    <span style="color:#808080;">Automatic posting of your blog articles to 20+ Social Networks including Twitter, Facebook Profile, Facebook Pages, LinkedIn, MySpace, Yammer, Yahoo, Identi.ca</span></div>'),
				"options-general.php?page=1-click-retweetsharelike/la-click-and-share.php")."</li>";
		}

		echo "<li> <div style='color: #006633;font-size:11px'><b>Done:</b> <span style='color:#808080;'>Displaying 1-click Retweet/Share/Like</span></div></li>
		     ";

		echo "<div style='color:#808080; font-size:11px'>To disable this message, go to Settings->1-click Retweet/Share/Like->'Auto Publish on Social Networks' and check the 'Warning box' and save changes. </div></div>";

	}
}


function lacands_la_langs() {
    $langs = array();
    $response_full = lacands_http_post("http://www.facebook.com/translations/FacebookLocales.xml");
    $response_code = $response_full[0];
	if ($response_code == 200) {
		preg_match_all('/<locale>\s*<englishName>([^<]+)<\/englishName>\s*<codes>\s*<code>\s*<standard>.+?<representation>([^<]+)<\/representation>/s', utf8_decode($response_full[1]), $langslist, PREG_PATTERN_ORDER);
        foreach ($langslist[1] as $key=>$val) {
            $langs[$langslist[2][$key]] = $val;
        }
	} else {
		$langs['default'] = "Default";
    }
    return $langs;
}


function lacands_main() {
	lacands_init();
	register_activation_hook( __FILE__, 'lacands_activate' );
	if ( is_admin() ) {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_register_script('lacandsjs', LACANDS_PLUGIN_URL.'la-click-and-share.js');
		wp_enqueue_script ('lacandsjs');
		wp_register_style ('lacandsnetworkpubcss', LACANDS_PLUGIN_URL.'la-click-and-share-networkpub.css');
		wp_enqueue_style  ('lacandsnetworkpubcss');
		add_action ( 'admin_menu',  'lacands_wp_admin');
		add_action ( 'admin_notices', 'lacands_warning');
		add_action ( 'init', 'lacandsnw_networkpub_ajax');
		add_action ( 'activate_{$plugin}', 'lacandsnw_pushpresscheck');
		add_action ( 'activated_plugin', 'lacandsnw_pushpresscheck');
	}
	add_filter ( 'the_content', 'lacands_wp_filter_post_content');
	register_deactivation_hook( __FILE__, 'lacands_deactivate' );
}

add_action ( '{$new_status}_{$post->post_type}', 'lacandsnw_networkping');
add_action ( 'publish_post',                     'lacandsnw_networkping');
add_action ( 'future_to_publish', 'lacandsnw_networkping');

add_action ( 'init', 'lacandsnw_networkpub_remove');
lacands_main();

?>