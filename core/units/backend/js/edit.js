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
    
    jQuery('.add-media-button').click(function(){
        var self = this;
        new VhFiles(function(html, json){ 
              /* this will insert image into active tinymce editor */
              htmlToInsert = "<img src='"+siteurl+"vhfiles?file="+json.id+"' alt='"+json.value.name+"'/>";
//              console.log(json);
              tinymce.execCommand('mceInsertContent',false,htmlToInsert);
        }, siteurl+"vhfiles");
    });
    
    
    jQuery('.id-field').each(function(){
       params = {
           list: jQuery(this).attr('data-list'),
           name: jQuery(this).attr('data-name'),
           value: jQuery(this).attr('data-value'),
           multiid: jQuery(this).attr('data-multiid')
       };
       jQuery(this).load(siteurl+"au-manage/select/", params, function(){
           jQuery(this).find('select.multiselect').multiselect({
                multiple: true,
                selectedList: 4 // 0-based index
             });

             jQuery(this).find('select.singleselect').multiselect({
                multiple: false,
                selectedList: 4 // 0-based index
             });
       });
    });
});


