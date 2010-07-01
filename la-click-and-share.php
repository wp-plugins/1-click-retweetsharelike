<?php
/*
Plugin Name: 1-click Retweet/Share/Like
Plugin URI: http://wwww.linksalpha.com/
Description: 1-click Retweet/Share/Like. Similar to Facebook Like button, but expanded to Twitter Retweet and Facebook Share as well! Email us at discuss@linksalpha.com if you have any queries or suggestions. <a href="http://help.linksalpha.com/1-click-retweet-share-like/faqs" target="_blank">FAQs</a>.
Author: LinksAlpha
Author URI: http://linksalpha.com
Version: 2.0.1
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

define('LACANDS_PLUGIN_URL', lacands_get_plugin_dir());

function lacands_readOptionsValuesFromWPDatabase() {
	global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout;

	$lacands_opt_widget_counters_location     = get_option('lacands-html-widget-counters-location');
	$lacands_opt_widget_margin_top            = get_option('lacands-html-widget-margin-top');
	$lacands_opt_widget_margin_right          = get_option('lacands-html-widget-margin-right');
	$lacands_opt_widget_margin_bottom         = get_option('lacands-html-widget-margin-bottom');
	$lacands_opt_widget_margin_left           = get_option('lacands-html-widget-margin-left');
	$lacands_widget_disable_cntr_display      = get_option('lacands-html-widget-disable-cntr-display');
	$lacands_opt_cntr_font_color              = get_option('lacands-html-cntr-font-color');
	$lacands_opt_widget_fb_like               = get_option('lacands-html-widget-fb-like');
	$lacands_opt_widget_font_style            = get_option('lacands-html-widget-font-style');
	$lacands_display_pages            		  = get_option('lacands-html-display-pages');
	$lacands_like_layout            		  = get_option('lacands-html-like-layout');
}

function lacands_writeOptionsValuesToWPDatabase($option) {
	global $lacands_display_pages;

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
		add_option('lacands-html-display-pages', $lacands_display_pages);
		add_option('lacands-html-like-layout', 'button_count');
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

	    if(!empty($_POST['lacands-html-display-page-single'])) {
		    $lacands_display_pages['single'] = '1';
	    }
	    else {
		    $lacands_display_pages['single'] = '0';
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
	global $post;

	$p          = $post;

	lacands_readOptionsValuesFromWPDatabase();

	$position = '';

	if( $lacands_widget_disable_cntr_display == '0') {
		$position = 'padding-top:'.$lacands_opt_widget_margin_top.'px;padding-right:'.$lacands_opt_widget_margin_right.'px;padding-bottom:'.$lacands_opt_widget_margin_bottom.'px;padding-left:'.$lacands_opt_widget_margin_left.'px;';
	}

	if ((is_single() && ($lacands_display_pages['single']))  ||   (is_home() && ($lacands_display_pages['home'])) || (is_archive() && ($lacands_display_pages['archive'])) )
	{
		$link1 = urlencode(urldecode(get_permalink($p)));

		$lacands_opt_cntr_font_color = str_replace('#', '', $lacands_opt_cntr_font_color);
		$lacands_opt_cntr_font_color = trim($lacands_opt_cntr_font_color);

    	$lacands_widget_display_cntrs = '<div style="'.$position.';">
										<iframe
											style="height:25px !important; border:none !important; overflow:hidden !important; width:340px !important;" frameborder="0" scrolling="no" allowTransparency="true"
											src="http://www.linksalpha.com/social?link='.$link1.'&fc='.$lacands_opt_cntr_font_color.'&fs='.$lacands_opt_widget_font_style.'&fblname='.$lacands_opt_widget_fb_like.'">
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

    if (isset($_POST['lacands_widget_update']))
    {
    	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}

    	lacands_writeOptionsValuesToWPDatabase('update');

    	echo '<div id="message" class="updated fade" style="width:1000px;"><p><strong>Settings saved for 1-click Retweet/Share/Like.</strong></p></div>';
		echo '</strong></p></div>';
	}

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

function lacands_main() {
	register_activation_hook( __FILE__, 'lacands_activate' );
	add_action ( 'admin_menu',  'lacands_wp_admin') ;
	add_filter ( 'the_content', 'lacands_wp_filter_post_content');
	register_deactivation_hook( __FILE__, 'lacands_deactivate' );
}

lacands_main();

?>