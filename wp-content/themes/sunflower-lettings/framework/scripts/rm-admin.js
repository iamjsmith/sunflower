jQuery(document).ready(function($){ 
    
    // Initial load Page Switcher
    var hash = window.location.hash;
    if(hash != ''){
		$('#page-' + hash.replace(/#/, '')).show();
        $('#rm-framework .nav li a[href="'+ hash +'"]').addClass('active');
	} else {
        $('#rm-framework .page:first').show();
        $('#rm-framework .nav li a:first').addClass('active');
    }
    
    // Page Switcher
    $('#rm-framework .nav li a').bind('click', function(){
        $('#rm-framework .page').hide();
        var loc = $(this).attr('href');
        $('#page-' + loc.replace(/#/, '')).show();
        $('#rm-framework .nav li a').removeClass('active');
        $(this).addClass('active');
    });
    
    // AJAX Save
    $('#rm-framework form').submit(function(){
        var form = $(this);
        form.trigger('rm-before-save');
        var button = $('#rm-framework #save-button');
        var buttonVal = button.val();
        button.val('Saving...');
		$.post(form.attr("action"), form.serialize(), function(data){
            button.val(buttonVal);
			//$('#rm-framework-messages').html(data.message);
			if(data.error){
				$.jGrowl(data.message, { header:'Error' });
			} else {
				$.jGrowl(data.message);
			}
            form.trigger('rm-saved');
		}, 'json');
		return false;
    });
    
    // Reset Button
    $('#rm-framework #reset-button').live('click', function(){
    	if(confirm('Click to reset. Any settings will be lost!')){
    		$(this).val('Reseting...');
	    	$.post(ajaxurl, { action:'rm_framework_reset', nonce:$('#rm_noncename').val() }, function(data){
				if(data.error){
					$.jGrowl(data.message, { header:'Error' });
				} else {
					window.location.reload(true);
				}
			}, 'json');
		}
		return false;
    });
    
    // Custom Layout Switcher
    $('#rm-framework .main-layout br').remove();
    $('#rm-framework .main-layout input[type="radio"]').each(function(){
    	var label = $(this).parent();
    	label.addClass($(this).val());
    	if($(this).is(':checked')) label.addClass('checked');
    });
    $('#rm-framework .main-layout label').live('click', function(){
    	$('#rm-framework .main-layout label').removeClass('checked');
    	$('#rm-framework .main-layout input[type="radio"]').attr('checked', false);
    	var id = $(this).attr('for');
    	$(this).addClass('checked');
    	$('#rm-framework .main-layout #'+ id).attr('checked', true);
    });
    
    // Color Picker
    $('.colorSelector').each(function(){
        var Othis = this; //cache a copy of the this variable for use inside nested function
        var initialColor = $(Othis).next('input').attr('value');
        $(this).ColorPicker({
            color: initialColor,
            onShow: function (colpkr) {
                $(colpkr).stop(true,true).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).stop(true,true).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $(Othis).children('div').css('backgroundColor', '#' + hex);
                $(Othis).next('input').attr('value','#' + hex);
            }
        });
    }); //end color picker
});