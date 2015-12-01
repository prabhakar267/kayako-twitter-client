
// to avoid jQuery conflicts
// var $ = function(id){return document.getElementById(id)};

/**
 * getDocHeight() - Cross browser solution for detecting the dimensions of the window
 * @return actual height of the document(window)
 */
function getDocHeight() {
	var D = document;
	return Math.max(
		D.body.scrollHeight, D.documentElement.scrollHeight,
		D.body.offsetHeight, D.documentElement.offsetHeight,
		D.body.clientHeight, D.documentElement.clientHeight
	);
}

$(document).ready(function(){

	var ajax_call_sent = false;

	$(window).scroll(function(){
		
		if( !ajax_call_sent && $(window).scrollTop() + $(window).height() == getDocHeight() ) {

			// Proceed with Ajax request only if #next_results_hidden element is present
			if( $('#next_results_hidden').length ){
				
				// fetch max_id from the hidden input
				var next_results = $('#next_results_hidden').val();

				// setting flag to set debounce time for next ajax call
				ajax_call_sent = true;

				var encoded_data = {};
				encoded_data.next_results = next_results;

				// show the loading image
				$('.loader_gif').html('<img src="https://gadgets360.com/shop/static/web/images/loading_icon_small.gif">');

				jQuery.ajax({
					type: "GET",
					url: "index.php/get-more-tweets",
					data: { next_results : next_results },
					cache: false,

					/**
					 * success() - callback function that gets called if AJAX request is successful
					 * @param  response, Response received from the AJAX request
					 * @return Appends the new tweets fetched from this AJAX call
					 */
					success: function( response ) {

						// hide loading image
						$('.loader_gif').html('');

						var data = JSON.parse( response );

						if( data["status"] == 200 ){

							// append the new tweets at the end
							$('#instant_results').append( data["html"] );

							// put new max_id into the same hidden field
							$('#next_results_hidden').val( data["new_next_results"] );

						}
						else if( data["status"] == 400 ){

							// show error text
							$('.loader_gif').html('<p>Error fetching tweets. Please try again.</p>');

						}

						// unset the flag to let the dom call another ajax call when reached bottom
						ajax_call_sent = false;
					},

					/**
					 * error() - callback function if there is an error in AJAX request
					 */
					error: function() {

						// hide loading image, and show error text
						$('.loader_gif').html('<p>Error fetching tweets. Please try again.</p>');

						// unset the flag to let the dom call another ajax call when reached bottom
						ajax_call_sent = false;
					}
				});

			}
			else{

				// hide loading image, and show error text
				$('.loader_gif').html('<p>Error fetching tweets. Please try again.</p>');

			}

		}

	});
});