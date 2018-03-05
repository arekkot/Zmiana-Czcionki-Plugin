jQuery.fn.fontresizermanager = function () {

    var medwayResizer_value = jQuery('#medwayResizer_value').val();
    var medwayResizer_ownid = jQuery('#medwayResizer_ownid').val();
    var medwayResizer_ownelement = jQuery('#medwayResizer_ownelement').val();
    var medwayResizer_resizeSteps = jQuery('#medwayResizer_resizeSteps').val();
    var medwayResizer_cookieTime = jQuery('#medwayResizer_cookieTime').val();
    var medwayResizer_maxFontsize = jQuery('#medwayResizer_maxFontsize').val();
    var medwayResizer_minFontsize = jQuery('#medwayResizer_minFontsize').val();
    var medwayResizer_element = medwayResizer_value;
 
	if(medwayResizer_value == "innerbody") {
		medwayResizer_element = "div#innerbody";
	} else if(medwayResizer_value == "ownid") {
		medwayResizer_element = "div#" + medwayResizer_ownid;
	} else if(medwayResizer_value == "ownelement") {
		medwayResizer_element = medwayResizer_ownelement;
	}

	var startFontSize = parseFloat(jQuery(medwayResizer_element+"").css("font-size"));
	var savedSize = jQuery.cookie('fontSize');
	if(savedSize > 4) {
		jQuery(medwayResizer_element).css("font-size", savedSize + "px");
	}

	jQuery('.medwayResizer_add').css("cursor","pointer");
	jQuery('.medwayResizer_minus').css("cursor","pointer");
	jQuery('.medwayResizer_reset').css("cursor","pointer");


	jQuery('.medwayResizer_add').click(function(event) {
		event.preventDefault();
		var newFontSize = parseFloat(jQuery(medwayResizer_element+"").css("font-size"));
		newFontSize=newFontSize+parseFloat(medwayResizer_resizeSteps);
		if( newFontSize <= medwayResizer_maxFontsize || medwayResizer_maxFontsize == 0 || medwayResizer_maxFontsize == '' ) {
			jQuery(medwayResizer_element+"").css("font-size",newFontSize+"px");
			jQuery.cookie('fontSize', newFontSize, {expires: parseInt(medwayResizer_cookieTime), path: '/'});
		}
	});

	jQuery('.medwayResizer_minus').click(function(event) {
		event.preventDefault();
		var newFontSize = parseFloat(jQuery(medwayResizer_element+"").css("font-size"))
		newFontSize=newFontSize-medwayResizer_resizeSteps;
		if( newFontSize >= medwayResizer_minFontsize || medwayResizer_minFontsize == 0 || medwayResizer_minFontsize == '' ) {
			jQuery(""+medwayResizer_element+"").css("font-size",newFontSize+"px");			 
			jQuery.cookie('fontSize', newFontSize, {expires: parseInt(medwayResizer_cookieTime), path: '/'});
		}
	});

	jQuery('.medwayResizer_reset').click(function(event) {
		event.preventDefault();
		jQuery(""+medwayResizer_element+"").css("font-size",startFontSize);			 
		jQuery.cookie('fontSize', startFontSize, {expires: parseInt(medwayResizer_cookieTime), path: '/'});
	});

	jQuery('.medwayResizer_minus, .medwayResizer_reset, .medwayResizer_add').keypress(function (e) {
	var key = e.which;
		if(key == 13) {
			$(this).click();
			return false;  
		}
	});

}
