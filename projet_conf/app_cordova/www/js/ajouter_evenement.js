//on recupere la liste d'organisateur pour le formulaire
$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getOrganisateur',function( data ) {
	$.each(data, function() {
	    $('.liste').append(
	        '<option value="'+ this.id+ '">'+this.soc_orga+'</option>'
	    );
	});
},"json");

//envoi du formulaire
$('form').submit(function(e){
	e.preventDefault();
	var formData= new FormData(this);
	formData.append('ajout_evenement','ajout');
	//console.log(formData);
	$.ajax({
		type: 'POST',
		data: formData,
		url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
		processData: false,
		contentType: false,
		success: function(){
			
			alert('Your comment was successfully added');
			document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";
		},
		error: function(){
			console.log();
			alert('There was an error adding your event');
		}
	});
	//document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html"
});