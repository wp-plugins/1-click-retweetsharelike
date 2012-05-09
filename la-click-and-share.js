var blog_url;
jQuery(document).ready(function() {
	blog_url = jQuery("#la-networkpub_plugin_url").val();
	jQuery(".lacandsnw_remove").live("click", function() {
		var lacandsnw_ajax_msg = jQuery(this).parents(".lacandsnw_content_box:first").prev();
		lacandsnw_ajax_msg.show();
		lacandsnw_ajax_msg.html('Removing...');
        var key = jQuery(this).attr("id");
        jQuery(this).parent().parent().css('opacity','.30');
        jQuery.post(blog_url+"la-click-and-share-networkpub_ajax.php", {lacandsnw_networkpub_key:key, type:'remove'}, function(data) {
            if (data == '500') {
            	lacandsnw_ajax_msg.html('Error occured while removing the Network. As a workaround, you can remove this publishing at the following link: <a target="_blank" href="http://www.linksalpha.com/publisher/pubs">LinksAlpha Publisher</a>');
            } else {
                jQuery("#r_"+key).remove();
                lacandsnw_ajax_msg.html('Network has been removed successfully');
            }
            oneclick_msg_fade(lacandsnw_ajax_msg);
        });
        return false;
    });
	jQuery.receiveMessage(
		function(e){
			jQuery("#networkpub_postbox").height(e.data.split("=")[1]+'px');
		},
		'http://www.linksalpha.com'
	);
	jQuery("#site_links").live("change", function(event) {
		jQuery.postMessage(
			jQuery(this).val(),
			'http://www.linksalpha.com/post',
			parent
		);
	});
});


function oneclick_msg_fade(this_elem) {
	setTimeout(function(){
		this_elem.fadeOut();
	}, 5000);
}