jQuery(document).ready(function($) {
	$('.upload_image_button').click(function() {
		formfield = $(this).prev().attr('id');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src');
		$('#' + formfield).val(imgurl);
		tb_remove();
	}
});