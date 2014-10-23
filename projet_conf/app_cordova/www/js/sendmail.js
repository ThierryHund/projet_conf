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
				document.location.href="contact.html";
			
		},
		error: function(){
			console.log();
			alert('error');
		}
	});
});