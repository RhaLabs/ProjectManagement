jQuery(document).ready(function($) { 
    var shadowify = function (e) {
        var color = jQuery(e).css('color'),
            size  = jQuery(e).css('font-size');

        // Got Hex color?  Modify with: http://stackoverflow.com/questions/1740700/get-hex-value-rather-than-rgb-value-using-jquery
        if ( color.search('rgb') == -1 )
            return;

        var rgba = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
        jQuery(e).css('text-shadow', '0 0 1px rgba('+rgba[1]+','+rgba[2]+','+rgba[3]+',1)');

    // To use calculated shadow of say, 1/15th of the font height 
    //var fsize = size.match(/(\d+)px/);
    //jQuery(e).css('text-shadow', '0 0 '+(fsize[1]/15)+'px rgba('+rgba[1]+','+rgba[2]+','+rgba[3]+',0.3)')
    }


    if(navigator.platform.indexOf('Win') != -1)
        $('.header-logo , h1 a, h2 a, h3 a').each(function(){shadowify(this)});
        //^ Your appropriately targeted list of elements here ^
});
