
// POST AJAX
function post_ajax_data ( url, encoded_data, before_send, success ){
	jQuery.ajax({
		type: "POST",
		url			: url,
		data 		: encoded_data,
		restful		: true,
		contentType	: 'application/json',
		dataType	: "json",
		cache		: false,
		timeout 	: 20000,
		async		: true,
		beforeSend 	: before_send,
		success		: function(data){
						success.call( this, data );
					},
		error		: function(data){
						console.log("POST ajax failed");
					}
	});
}

// GET and DELETE AJAX
function ajax_data ( type, url, before_send, success ){
	jQuery.ajax({
		type    	: type,
		url			: url,
		dataType	: "json",
		restful 	: true,
		cache 		: false,
		timeout 	: 20000,
		async		: false,
		beforeSend  : before_send,
		success		: success,
		error		: function(data){
						console.log("GET ajax failed");
					}
	});
}