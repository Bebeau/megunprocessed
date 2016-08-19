var ajaxurl = meta_image.ajaxurl;

var init = {
	onReady: function() {
		init.removeItem();
		init.lockPhotos();
		init.ordering();
	},
	removeItem: function(postID, key, type) {
		jQuery.ajax({
	        url: ajaxurl,
	        type: "GET",
	        data: {
	            action: 'removeItem',
	            postID: postID,
	            type: type,
	            key: key
	        },
	        dataType: 'html',
	        error : function(jqXHR, textStatus, errorThrown) {
	            window.alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	        }
	    });
	    jQuery(".button-remove").click(function(e){
            e.preventDefault();
            var postID = jQuery(this).parent().parent().attr("data-post");
            var video_type = jQuery(this).parent().parent().attr("data-type");
            var key = jQuery(this).parent().attr("data-key");
            jQuery(this).parent().remove();
            init.removeItem(postID, key, video_type);
        });
	},
    lockPhotos: function() {
    	jQuery(document).on("DOMNodeInserted", function(){
	        // Lock uploads to "Uploaded to this post"
	        jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
	    });
    },
    saveOrder: function(order, type, postID) {
        jQuery.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
            	order : order,
            	type: type,
            	postID: postID,
                action: 'setOrder'
            },
            dataType: 'JSON'
        });
    },
    ordering: function() {
    	jQuery( ".sortable" ).sortable({
			placeholder: "ui-state-highlight",
			// Do callback function on jquery ui drop
			update: function( event, ui ) {
				var order = [];
				if(jQuery(".sortable").hasClass("videoWrap")) {
					jQuery(".sortable li").each(function() {
						order.push({
							id: jQuery(this).attr("data-order"),
							type: jQuery(this).attr("data-video")
						});
					});
				} else {
					jQuery(".sortable li").each(function() {
						order.push(jQuery(this).attr("data-order"));
					});
				}
				var postID = jQuery('.sortable').attr("data-post");
				var type = jQuery('.sortable').attr("data-type");
				init.saveOrder(order, type, postID);
			}
		});
		jQuery( ".sortable" ).disableSelection();
    }
};

jQuery(document).ready(function() {
	init.onReady();
});