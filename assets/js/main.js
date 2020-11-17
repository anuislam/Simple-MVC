var $doc = jQuery(document);
$doc.ready(function($){
	$doc.on('click', 'a[href="#for_logout"]', function(e){
		e.preventDefault();
		$('#for_logout').submit();
	});
	$doc.on('click', 'a[delete_user="alluser_delete"]', function(e){
		e.preventDefault();
		$conf = confirm('Want to delete?');
		if ($conf) {
			var $csrf = $('#dataTable').attr('csrf');
			$(this).find('form[method="post"]').append('<input type="hidden" name="csrf_token" value="'+$csrf+'" >').submit();
		}
	});
});
