$(document).ready(function(){

	
	noti1();
	noti2();
	$(window).stellar();
	contact();
});

function contact(){

	$("#contact-div").on('click' , '#contact-send-button', function(event) {
		event.preventDefault();
		form = $("#contact-form");
		
		var inform = function(result){

			if(result == 'true'){

				$('#noti3').foundation('reveal', 'open');
				setTimeout(function() {
  					window.location.href = Routing.generate('main_welcome');
				}, 1500);

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
			dataType: 'text',
			success: inform
		});
	});
}

// notificacion - inicio de sesion
function noti1(){

	$("#user-login-div").on('click' , '#loggin-user-button', function(event) {
		event.preventDefault();
		form = $("#loggin-form");
		
		var inform = function(result){
			if(result == 'true'){

				$('#noti1').foundation('reveal', 'open');
				setTimeout(function() {
  					window.location.href = Routing.generate('main_welcome');
				}, 1500);

			}else{
				form.remove();
				$("#user-login-div").prepend(result);
			}
		};

		$.ajax({
			type: form.attr('method'),
			async: true,
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'text',
			success: inform
		});
	});
}

// notificacion - creacion de usuario
function noti2(){

	$("#user-new-div").on('click' , '#new-user-button', function(event) {
		event.preventDefault();
		form = $("#newuser-form");
		
		var inform = function(result){

			if(result == 'true'){

				$('#noti2').foundation('reveal', 'open');
				setTimeout(function() {
  					window.location.href = Routing.generate('main_welcome');
				}, 1500);
			} 
			if(result == 'trueadmin'){

				$('#noti2').foundation('reveal', 'open');
				setTimeout(function() {
  					window.location.href = Routing.generate('user');
				}, 1500);
			}
			if ( result != 'true' && result != 'trueadmin' ){
	
				form.remove();
				$("#user-new-div").prepend(result);
			}
		};

		$.ajax({
			type: form.attr('method'),
			async: true,
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'text',
			success: inform
		});
	});
}

