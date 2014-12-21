jQuery(document).ready(function(){
    jQuery('.img-field').click(function(){
	console.log('clicked');
        var self = this;
	vhfiles = new VhFiles(function(html, json) {
	    console.log(json);
            jQuery(self).children('input').val(json.id)
	    jQuery(self).children('.img-container').html("<img src='"+siteurl+"vhfiles?file="+json.id+"&w=100'/>");
//	    jQuery('#imagePic').html(html);
	}, siteurl+"vhfiles");
    });
});


