function Unitmanagement() {
    jQuery('.enable-unit, .disable-unit').unbind('click');
    jQuery('.enable-unit').click(function(){
        var unit = jQuery(this).parent().parent().parent();
        var self = this;
        slug = jQuery(this).attr('data-slug');
        jQuery.post(siteurl+"au-manage/units",{ slug: slug, action: 'enable' }, function(data){
            unit.addClass('active');
            jQuery(self).removeClass('enable-unit');
            jQuery(self).addClass('disable-unit');
            Unitmanagement();
        }, 'json');
    });
    jQuery('.disable-unit').click(function(){
        var unit = jQuery(this).parent().parent().parent();
        var self = this;
        slug = jQuery(this).attr('data-slug');
        jQuery.post(siteurl+"au-manage/units",{ slug: slug, action: 'disable' }, function(data){
            unit.removeClass('active');
            jQuery(self).removeClass('disable-unit');
            jQuery(self).addClass('enable-unit');
            Unitmanagement();
        }, 'json');
    });
}

jQuery(document).ready(function(){
    Unitmanagement();
});


