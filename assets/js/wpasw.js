jQuery(document).ready(function($) {

	jQuery('.wpasw-widget form').on('submit', function(e) {
		
		e.preventDefault();
		
		var $results = jQuery(this).parent().find('.wpasw-results');

		jQuery.ajax({
			type: "POST",
			url: wpasw.ajax_url,
			data: jQuery(this).serialize(),
			success: function(data) {
				console.log(jQuery(this));
				$results.html(data);
			}
		});
		
		return false;
	});

});