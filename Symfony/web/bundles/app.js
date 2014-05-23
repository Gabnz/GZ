$(document).ready(function(){

	$(window).stellar();
	contact();
});

function contact(){

	$("#contact-div").on('click' , '#contact-send-button', function () {

		form = $("#contact-form");
		
		var inform = function(result){

			if(result == 'true'){
				alert('Tu mensaje ha sido enviado.');
				var var1 = document.getElementById("hotel_mainbundle_contact_email");
				var var2 = document.getElementById("hotel_mainbundle_contact_message");
				var1.value = ''; var2.value = '';

				form.find(".error").remove();

			}else{
				form.remove();
				$("#contact-div").prepend(result);
			}
		};

		$.ajax({
			type: form.attr('method'),
			async: true,
			url: form.attr('action'),
			data: form.serialize(),
			success: inform
		});
	});
}

