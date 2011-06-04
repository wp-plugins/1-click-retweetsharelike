<?php


function lacands_fb_meta() {
    global $posts;
    global $paged;
    
    $opengraph_meta = "";
    
    //Site name
    $site_name = get_bloginfo('name');
    if($site_name) {
        $opengraph_meta .= "\n<meta property=\"og:site_name\" content=\"" . $site_name . "\" />";    
    }
    //Post or Page
    if ( is_single() || is_page() ) {
        //Post data
        $post_data = get_post( $posts[0]->ID, ARRAY_A );
        //Title
        $post_title = lacands_clean_text($post_data['post_title']);
        $opengraph_meta .= "\n<meta property=\"og:title\" content=\"" . $post_title . "\" />";
        //Link
        $post_link = get_permalink($posts[0]->ID);
        $opengraph_meta .= "\n<meta property=\"og:url\" content=\"" . $post_link . "\" />";
        //Featured Image
        $post_image = lacands_thumbnail_link($posts[0]->ID, $post_data['post_content']);
        if($post_image) {
            $opengraph_meta .= "\n<meta property=\"og:image\" content=\"" . $post_image . "\" />";    
        }
        //Content
        if(!empty($post_data['post_excerpt'])) {
            $post_content = $post_data['post_excerpt'];
        } else {
            $post_content = $post_data['post_content'];
            $post_content = lacands_clean_text($post_content);
            if(strlen($post_content) > 300) {
                $post_content = substr($post_content, 0, 300).'...';
            }
        }
        $opengraph_meta .= "\n<meta property=\"og:description\" content=\"" . $post_content . "\" />";
        //Type
        $opengraph_meta .= "\n<meta property=\"og:type\" content=\"article\" />";
    } else {
        //Title
        $opengraph_meta .= "\n<meta property=\"og:title\" content=\"" . $site_name . "\" />";
        //Site url
        $site_url = get_bloginfo('url');
        $opengraph_meta .= "\n<meta property=\"og:url\" content=\"" . $site_url . "\" />";
        //Type
        $opengraph_meta .= "\n<meta property=\"og:type\" content=\"blog\" />";
    }
    //Return
    if ($opengraph_meta) {
		echo "\n<!-- Facebook Open Graph metatags added by WordPress plugin. Get it at: http://www.linksalpha.com/widgets/clickngo -->" . $opengraph_meta . "\n<!-- End Facebook Open Graph metatags-->\n";
	}
}


function lacands_clean_text($text) {
	$text = stripslashes($text);
	$text = strip_tags($text);
	$text = htmlspecialchars($text);
	$text = preg_replace('/([\n \t\r]+)/', ' ', $text); 
	$text = preg_replace('/( +)/', ' ', $text);
	return trim($text);
}


function lacands_thumbnail_link($post_id, $post_content) {
    if(function_exists('get_post_thumbnail_id') and function_exists('wp_get_attachment_image_src')) {
        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        if($src) {
            $src = $src[0];
            return $src;
        }
    }
    if(class_exists("DOMDocument") and function_exists('simplexml_import_dom')) {
        $doc = new DOMDocument();
        if(!($doc->loadHTML($post_content))){
			return False;
		}
        $xml = simplexml_import_dom($doc);
        $images = $xml->xpath('//img');
        if(!empty($images)) {
            return $images[0]['src'];
        }
    }
    return False;
}


?>