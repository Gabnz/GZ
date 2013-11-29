
main();

function main(){

	$(document).ready(function(){

		$(window).stellar();

		topbar();
		formContact();
		login();
		register();
		reserve();
		availability();

		$( "#accordion" ).accordion();

		$("#standard-header").on("click", function(){

			//alert('1');

		});

		$("#bussiness-header").on("click", function(){

			//alert('2');

		});

		$("#high-header").on("click", function(){

			//alert('3');

		});
		
	});
}

function topbar(){

	$("#log-button").on("click", function(){
		$("#reg-div").slideUp("slow", function(){

			$("#log-div").slideToggle("slow");
		});
	});

	$("#reg-button").on("click", function(){
		$("#log-div").slideUp("slow", function(){

			$("#reg-div").slideToggle("slow");
		});
	});
}

function login(){

	$("#log-div").on('click' , '#log-send-button', function () {

		form = $("#log-form");

		var inform = function(result){

			if(result[0] == '/'){
				alert('Ha ingresado exitosamente.');
				$('#aviso_inicio_sesion').foundation('reveal', 'open');
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
				$('#aviso_registro_usuario').foundation('reveal', 'open');
				window.location.replace(result);
			}else{
				
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

