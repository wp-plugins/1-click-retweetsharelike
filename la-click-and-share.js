jQuery(document).ready(function($) {
	$.receiveMessage(
		function(e){
			$("#networkpub_postbox").height(e.data.split("=")[1]+'px');
		},
		'http://www.linksalpha.com'
	);
	$("#site_links").live("change", function(event) {
		$.postMessage(
			$(this).val(),
			'http://www.linksalpha.com/post',
			parent
		);
	});
	setTimeout(function(){
		if($("#linksalpha_browser").length>0){
			if($("#linksalpha_post_extension_chrome").length == 0) {
				if($("#linksalpha_browser").val() == 'chrome') {
					$("#linksalpha_post_download_chrome").show();
				} else if($("#linksalpha_browser").val() == 'firefox') {
					$("#linksalpha_post_download_firefox").show();
				} else if($("#linksalpha_browser").val() == 'safari') {
					$("#linksalpha_post_download_safari").show();
				}
			} else {
				$("#linksalpha_post_download_chrome").remove();
				$("#linksalpha_post_download_firefox").remove();
				$("#linksalpha_post_download_safari").remove();
				$(".lacandsnw_post_meta_box_first").css('border-top-color', 'transparent');
			}
		}
	},3000);
	if($("#lacandsnw_post_update").length) {
		$("#lacandsnw_post_update").live("click", function() {
			$("body").append('<div id="lacandsnw_overlay"><iframe id="linksalpha_post_plugin" src="http://www.linksalpha.com/post2/postpopup?'+$("#lacandsnw_post_data").val()+'" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="no"></iframe></div>');
			return false;
		});
	}
	$.receiveMessage(
		function(e){
			if(e.data=='["close"]') {
				$("#lacandsnw_overlay").remove();
			}
		},
		'http://www.linksalpha.com'
	);
});

function oneclick_msg_fade(this_elem) {
	setTimeout(function(){
		this_elem.fadeOut();
	}, 5000);
}