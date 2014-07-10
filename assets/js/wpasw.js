jQuery(document).ready(function($) {

	var wpaswxhr;
	var $form;
	var $button = null;
	var buttontype;
	var buttoncontent;
	var wpaswcount = 1;
	var wpaswcounter;

	jQuery('.wpasw-widget form').on('submit', function(e) {

		e.preventDefault();

		var $results = jQuery(this).parent().find('.wpasw-results');
		$form = jQuery(this);

		// cancel previous requests
		if (wpaswxhr) wpaswxhr.abort();

		wpaswxhr = jQuery.ajax({
			type: "POST",
			url: wpasw.ajax_url,
			data: jQuery(this).serialize(),
			success: function(data) {

				if ($button.length) {
					wpaswupdatebutton(buttoncontent);
					clearInterval(wpaswcounter);
				}

				$results.html(data);
			},
			beforeSend: function() {

				$button = $form.find(':submit');

				if ($button.length) {
					buttontype = $button.prop("tagName").toLowerCase();
					buttoncontent =  wpaswgetbutton();
					wpaswupdatebutton('...');
					wpaswcounter = setInterval(wpaswloading, 333);
				}
			}
		});

		return false;
	});

	function wpaswloading() {

		if (wpaswcount == 3) {
			wpaswupdatebutton('...');
		} else {
			wpaswupdatebutton( wpaswgetbutton() + '.' );
		}

		wpaswcount++;
		if (wpaswcount == 4) wpaswcount = 0;
	}

	function wpaswupdatebutton(text) {
		if (buttontype == 'button') {
			$button.html(text);
		} else {
			$button.val(text);
		}
	}

	function wpaswgetbutton() {
		if (buttontype == 'button') {
			return $button.html();
		} else {
			return $button.val();
		}
	}
});