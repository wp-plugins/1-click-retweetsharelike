var blog_url;

jQuery.noConflict(); 

jQuery(document).ready(function()
{
	blog_url = jQuery("#la-networkpub_plugin_url").val();
	
	jQuery.post(blog_url+"la-click-and-share-networkpub_ajax.php", {type:'load'}, function(data) {
		if(data == '500') {
			jQuery("#la-idAPIBox").html('<div class="msg_error">Error occured while removing the API Key. As a workaround, you can remove this publishing at the following link: <a href="http://www.linksalpha.com/user/publish">LinksAlpha Publisher</a> </div>');
		} else {
			//jQuery("#la-idAPIBox").html(data);	
		}
	});

	jQuery(".lanetworkpubre").live("click", function(e) {
		var key = jQuery(this).attr("id");
		if(key) {
			jQuery.post(blog_url+"la-click-and-share-networkpub_ajax.php", {key:key, type:'remove'}, function(data) {
				if(data == '500') {
					jQuery("#la-networkpub_msg").html('<div class="msg_error">Error occured while removing the API Key. As a workaround, you can remove this publishing at the following link: <a href="http://www.linksalpha.com/user/publish">LinksAlpha Publisher</a> </div>');
				} else {
					jQuery("#r_"+key).remove();
					jQuery("#la-networkpub_msg").html('<div class="msg_success">API Key has been removed successfully</div>');	
				}
		    });
		} 
		return false;
	});	
	
		
});