$(function() {
    $('.commentmessage').onclick(function() {
		$('.commentmessage').hide();
		//var md5pass = md5($("#loginname").val() + $("#loginpass").val());
		//$('.commentmessage').val(md5pass);
		return true;
    });
});