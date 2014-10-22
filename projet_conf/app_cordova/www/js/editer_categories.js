$(document).ready(function(){
	var identifiant;
	var supprimer = document.getElementById('supprEvnt');

	//on rempli la page
	
	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getNbType',function( data ) {
	   $.each(data, function() {
			$('.categories').append(
				'<tr><td class="hidden">'
				+ this.id+ '</td><td>'
				+ this.type+'</td><td>'
				+((this.nb!=0)?('<span class="pull-right badge">'+this.nb+'</span>'):'<a href="javascript:supprimerCategorie('+this.id+');" class="glyphicon glyphicon-remove pull-right" ></a>')+'</td></tr>'


			);

		});

	},"json");
	
	
	//envoi du formulaire
$('form').submit(function(e){
	e.preventDefault();
	var formData= new FormData(this);
	formData.append('ajout_categorie','ajout');
	//console.log(formData);
	$.ajax({
		type: 'POST',
		data: formData,
		url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(data){
			//alert('Your comment was successfully added');
			$('.categories').html('');
			   	   $.each(data, function() {

			$('.categories').append(
				'<tr><td class="hidden">'
				+ this['id']+ '</td><td>'
				+ this['type']+'</td><td>'
				+((this['nb']!=0)?('<span class="pull-right badge">'+this.nb+'</span>'):'<a href="javascript:supprimerCategorie('+this.id+');" class="glyphicon glyphicon-remove pull-right" ></a>')+'</td></tr>'


				);

			});

						
		},
		error: function(){
			console.log();
			alert('error');
		}
	});
	//document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html"
});


});


function supprimerCategorie(identifiant) {

    var confirmation = confirm( "Voulez-vous vraiment supprimer ce type de présentation?" );
		if( confirmation )
			{	

				$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id_categ : identifiant,supprimer_categorie : 'supprime'},function( data ) {
				$('.categories').html('');
			   	   $.each(data, function() {
			$('.categories').append(
				'<tr><td class="hidden">'
				+ this.id+ '</td><td>'
				+ this.type+'</td><td>'
				+((this.nb!=0)?('<span class="pull-right badge">'+this.nb+'</span>'):'<a href="javascript:supprimerCategorie('+this.id+');" class="glyphicon glyphicon-remove pull-right" ></a>')+'</td></tr>'


			);

		});

						},"json");
			  //document.location.href = "accueil.html";

			}

}


