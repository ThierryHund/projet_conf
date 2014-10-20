//envoi du formulaire
$('form').submit(function(e){
	e.preventDefault();
	var formData= new FormData(this);
	formData.append('send_mail','mail');

	$.ajax({
		type: 'POST',
		data: formData,
		url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler.php',
		processData: false,
		contentType: false,
		success: function(){

				alert("Message envoyé avec succès!")
				document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/contact.html";
				//setTimeout(function(){$('Message envoyé avec succès!').fadeOut();}, 1500);
			
		},
		error: function(){
			console.log();
			alert('error');
		}
	});
});