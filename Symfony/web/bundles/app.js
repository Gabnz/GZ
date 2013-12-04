
main();

function main(){

	$(document).ready(function(){

		$(window).stellar();
		login();
		register();
		reserve();
		availability();
		formContact();
	});
}

function login(){

	$("#log-div").on('click' , '#log-send-button', function () {

		form = $("#log-form");

		var inform = function(result){

			if(result[0] == '/'){
				alert('Ha ingresado exitosamente.');
				window.location.replace(result);
			}else
				form.replaceWith(result);
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

function register(){

	$("#reg-div").on('click' , '#reg-send-button', function () {

		form = $("#reg-form");

		var inform = function(result){

			if(result[0] == '/'){
				alert('bien.');
				window.location.replace(result);
			}else
				form.replaceWith(result);
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

function reserve(){

	$("#res-div").on('click' , '#res-send-button', function () {

		form = $("#res-form");

		var inform = function(result){

			if(result == 'success')
				alert('bien.');
			else{
				
				form.replaceWith(result);
				//recarga los markups de foundation
				$(document).foundation();
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

function availability(){

	$("#res-div").on("click", "a.small", function(){
		//this.id contiene el id del boton presionado, el cual
		//sera el mismo id del div que se mostrara u ocultara.
		$("div#" + this.id).slideToggle("slow");
	});
}

function formContact(){

	$("#footerr").on('click' , '#contact_send_button', function () {

		form = $("#contact_form");
		
		var inform = function(result){

			if(result == 'success')
				alert('bien.');
			else
				form.replaceWith(result);
		};

		$.ajax({
			type: form.attr('method'),
			async: true,
			url: form.attr('action'),
			data: form.serialize(),
			success: inform
		});
		//alert(form.attr('action'));
	
	});
    
}

