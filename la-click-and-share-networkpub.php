<?php

function lacandsnw_networkping($id) {
	if(!$id) {
		return FALSE;
	}
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);	
	$link = 'http://www.linksalpha.com/a/ping?id='.$options['lacandsnw_id'];
	$response_full = lacandsnw_networkpub_http($link);
	$response_code = $response_full[0];
	if ($response_code === 200) {
		return TRUE;
	}
	return FALSE;
}

function lacandsnw_networkpub_add($api_key) {

	if (!$api_key) {
		$errdesc = lacandsnw_error_msgs('invalid key');
		echo $errdesc;		
		return FALSE;
	}

	$url  = get_bloginfo('url');	
	$desc = get_bloginfo('description');	
	if (!$url) {
		$errdesc = lacandsnw_error_msgs('invalid url');
		echo $errdesc;		
		return FALSE;
	}
	
	$link   = 'http://www.linksalpha.com/a/networkpubadd';		
	
	$params = array('url'=>urlencode($url), 'key'=>$api_key, 'plugin'=>'sd-nw');
	$response_full = lacandsnw_networkpub_http_post($link,$params);
	
	$response_code = $response_full[0];
	
	if ($response_code != 200) {
		$errdesc = lacandsnw_error_msgs($response_full[1]); 
		echo $errdesc;		
		return FALSE;
	}
	
	$response = lacandsnw_networkpub_json_decode($response_full[1]);
	if ($response->errorCode > 0) {	
		$errdesc = lacandsnw_error_msgs($response->errorMessage);
		echo $errdesc;		
		return FALSE;
	}
	
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(empty($options['api_key'])) {
		$options['api_key'] = $api_key;	
	} else {		
		$options_array = explode(',', $options['api_key']);
		if(!in_array($api_key, $options_array)) {
			$options['api_key'] = $options['api_key'].','.$api_key;	
		}
	}
	$options['lacandsnw_id'] = $response->results->id;

	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	echo '<div class="msg_success">API Key has been added successfully</div>';
	return TRUE;	
}

function lacandsnw_networkpub_load() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (empty($options['api_key'])) {		
		$html = '<div class="msg_error">You have not added any API Key</div>';
		echo $html;
		return;
	}
	
	$link = 'http://www.linksalpha.com/a/networkpubget';
	
	$body = array('key'=>$options['api_key'], 'version'=>2);	
	
	$response_full = lacandsnw_networkpub_http_post($link, $body);
	$response_code = $response_full[0];

	if ($response_code != 200) {
		$errdeschtml = lacandsnw_error_msgs($response_full[1]); 
		echo $errdeschtml;
		return;		
	}
	
	$response = lacandsnw_networkpub_json_decode($response_full[1]);
	if($response->errorCode > 0) {
		$html = '<div class="msg_error">Error occured while trying to load the API Keys. Please try again later.</div>';
		echo $html;
		return;
	}
	$html = '<div style="padding:10px ;">You are currently Publishing your Blog to '.count($response->results).' Social Networks</div>';
	$html .= '<table class="networkpub_added"><tr><th>API Key</th><th>Network</th><th>Option</th></tr>';
	if (count($response->results)) {
		foreach($response->results as $row) {
			$html .= '<tr id="r_key_'.$row->api_key.'">';
			$html  .= '<td>'.$row->api_key.'</td><td><a href="'.$row->profile_url.'">'.$row->name.'</a></td>';
			$html .= '<td><a href="#" id="key_'.$row->api_key.'" class="lanetworkpubre">Remove</a></td></tr>';
		}
	} else {
		$html .= '<tr><td colspan="3" style="text-align:center;padding:5px 0px 5px 0px;">No API Keys have been added</td></tr>';
	}
	$html .= '</table>';
	echo $html;
	return;
}

function lacandsnw_networkpub_ajax() {
	if(!empty($_POST['type'])) {
		if(in_array($_POST['type'],array('remove','load'))) {
			if($_POST['type']=='remove') {
				lacandsnw_networkpub_remove($_POST['key']);				
			}					
			if($_POST['type']=='load') {
				lacandsnw_networkpub_load();				
			}			
		}		
	}
}

function lacandsnw_networkpub_remove($key_full) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
		
	if ($key_full) {	
		$key_only = substr($key_full, 4);
		$link = 'http://www.linksalpha.com/a/networkpubremove?id='.$options['lacandsnw_id'].'&key='.$key_only;
		$response_full = lacandsnw_networkpub_http($link);
		$response_code = $response_full[0];
		
		if ($response_code != 200) {
			$errdesc = lacandsnw_error_msgs($response_full[1]); 
			echo $errdesc;		
			return FALSE;
		}
		
		$api_key = $options['api_key'];
		$api_key_array = explode(',', $api_key);
		$loc = array_search($key_only, $api_key_array);
		
		if($loc !== FALSE) {
			unset($api_key_array[$loc]);
		}
		
		$api_key = implode(",", $api_key_array);
		$options['api_key'] = $api_key;
		update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
		
		print_r($options);
		
		return $key_full;
	}
}

function lacandsnw_networkpub_json_decode($str) {
	if (function_exists("json_decode")) {
	    return json_decode($str);
	} else {
		if (!class_exists('Services_JSON')) {
			require_once("JSON.php");
		}
	    $json = new Services_JSON();
	    return $json->decode($str);
	}
}

function lacandsnw_networkpub_http($link) {
	if (!$link) {
		return array(500, 'invalid url');
	}
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
	$snoop = new Snoopy;
	$snoop->agent = LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url');
	if($snoop->fetchtext($link)){
		if (strpos($snoop->response_code, '200')) {
			$response = $snoop->results;
			return array(200, $response);
		} 
	}
	if( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );	
	}
	if (!class_exists('WP_Http')) {
		return array(500, 'internal error');	
	}
	$request = new WP_Http;
	$headers = array( 'Agent' => LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url') );
	$response_full = $request->request( $link );
	
	if(isset($response_full->errors)) {			
		return array(500, 'internal error');				
	}	
	
	$response_code = $response_full['response']['code'];
	if ($response_code === 200) {
		$response = $response_full['body'];
		return array($response_code, $response);
	}
	$response_msg = $response_full['response']['message'];
	return array($response_code, $response_msg);
}

function lacandsnw_networkpub_http_post($link, $body) {
	if (!$link) {
		return array(500, 'invalid url');
	}	
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
	$snoop = new Snoopy;
	$snoop->agent = LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url');
	if($snoop->submit($link, $body)){
		if (strpos($snoop->response_code, '200')) {
			$response = $snoop->results;
			return array(200, $response);
		} 
	}	
	if( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );	
	}	
    if (!class_exists('WP_Http')) {
		return array(500, 'internal error');	
	}	
	$request = new WP_Http;
	$headers = array( 'Agent' => LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url') );
	$response_full = $request->request( $link, array( 'method' => 'POST', 'body' => $body, 'headers'=>$headers) );
	
	if(isset($response_full->errors)) {			
		return array(500, 'internal error');				
	}	
	
	$response_code = $response_full['response']['code'];
	if ($response_code === 200) {
		$response = $response_full['body'];
		return array($response_code, $response);
	}
	$response_msg = $response_full['response']['message'];
	return array($response_code, $response_msg);
}


function lacandsnw_error_msgs($errMsg) {

	$arr_errCodes  = explode(";", $errMsg);
	$errCodesCount = count($arr_errCodes);

	switch (trim($arr_errCodes[0])) {
	
		case 'internal error':
			$html = '<div class="msg_error">	
							<b>Please try again. Wait for sometime and try again.</b> There was an unknown error. We will keep re-trying and send you an email when the request is successful. 
							You can also email us at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> with error description (your blog URL and the error).							
					</div>';
			return $html;		
			break;
	
		case 'invalid url':
			$html  = '<div class="msg_error"> <b>Your blog URL is invalid: </b>'.$arr_errCodes[$errCodesCount-1];			
			if($errCodesCount == 3) {
				$html .= '. Error Code='.$arr_errCodes[$errCodesCount-2];
			}			
			$html .= '<br/> You can also <a href="http://www.linksalpha.com/user/siteadd" target="_blank">Click here</a> to enter blog URL on LinksAlpha manually. 
					  Also ensure that in <b>Settings->General->"Blog address (URL)"</b> the URL is filled-in correctly. 
					  <br/>If you still face issues then email us at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> with error description.							
					  </div>';			
			return $html;
			break;
			
		case 'remote url error':		
			$html  = '<div class="msg_error"> <b>Remote URL error: </b>'.$arr_errCodes[$errCodesCount-1];			
			if($errCodesCount == 3) {
				$html .= '. Error Code='.$arr_errCodes[$errCodesCount-2];
			}
			$html .= '<br/> <b>Description: </b>
							<b>Please try again. Wait for sometime and try again. </b> Your site either did not respond (it is extremely slow) or it is not operational.							 
							<br/> You can also <a href="http://www.linksalpha.com/user/siteadd" target="_blank">Click here</a> to enter blog URL on LinksAlpha manually. 
							Also ensure that in <b>Settings->General->"Blog address (URL)"</b> the URL is filled-in correctly. 
							<br/>If you still face issues then email us at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> with error description.							
					</div>';
			return $html;		
			break;
			
		case 'feed parsing error':
			$html  = '<div class="msg_error"> <b>Feed parsing error: </b>'.$arr_errCodes[$errCodesCount-1];			
			if($errCodesCount == 3) {
				$html .= '. Error Code='.$arr_errCodes[$errCodesCount-2];
			}
			$html .= '<br/> <b>Description: </b>
							Your RSS feed has errors. Pls go to <a href=http://beta.feedvalidator.org/ target="_blank">href=http://beta.feedvalidator.org/</a> 
							to validate your RSS feed. 
							<br/>If it comes out to be correct, try again and email as at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> with your blog URL and error description.
					</div>';			
			return $html;		
			break;

		case 'feed not found':
			$html = '<div class="msg_error">
							<b>We could not find feed URL for your blog.</b> 
							<br/><a href="http://www.linksalpha.com/user/siteadd" target="_blank">Click here</a> to enter feed URL on LinksAlpha manually. 
							Also ensure that in <b>Settings->General->"Blog address (URL)"</b> the URL is filled-in correctly. 
							<br/>If you still face issues then email us at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> with error description.							
					</div>';			
			return $html;		
			break;
			
		case 'invalid key':
			$html = '<div class="msg_error">
							<b>Invalid Key: </b>the key that you entered is incorrect. Please try again.
							<br/><span style="color:#d12424;">Getting Errors?</span> See help page <a href="http://help.linksalpha.com/errors" target="_blank">here</a> 
							<br/>Or, <a href="http://www.linksalpha.com/user/siteadd" target="_blank">Click here</a> to enter your blog URL on LinksAlpha manually. 
							If you still face issues then email us at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> with error description.							
					</div>';			
			return $html;
			break;
			
		case 'subscription upgrade required':
			$html = '<div class="msg_error">
							<b>Upgrade account.</b> Please <a href="http://www.linksalpha.com/account" target="_blank">upgrade your subscription</a> to add more networks.
					</div>';
			return $html;
			break;
			
		default:
			$html = '<div class="msg_error">	
							Sorry we are undergoing maintenance at this time - this happens very rarely but is critical to ensure continued availability. We apologize for the inconvenience. 
							This can take upto 2 hours maximum. Please try again after sometime and it is guaranteed to work. 
							You can also email us at <a href="mailto:discuss@linksalpha.com">discuss@linksalpha.com</a> if issue persists. Thanks for your understanding.							
					</div>';
			return $html;		
			break;			
	}	
}

function lacandsnw_pushpresscheck() {
	$active_plugins = get_option('active_plugins');
	$pushpress_plugin = 'pushpress/pushpress.php';
	$this_plugin_key = array_search($pushpress_plugin, $active_plugins);
	if ($this_plugin_key) {
		$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
		if(array_key_exists('lacandsnw_id', $options)) {
			if($options['lacandsnw_id']) {
				$link = 'http://www.linksalpha.com/a/pushpress';
				$body = array('id'=>$options['lacandsnw_id']);
				$response_full = lacandsnw_networkpub_http_post($link, $body);
				$response_code = $response_full[0];	
			}	
		}
	}
}

?>
