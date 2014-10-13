$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_evenement',function( data ) {
   $.each(data, function() {
	    $('.infoEvent').append(
	        '<tr><td class="hidden">'
	        + this.id+ '</td><td>'
	        + this.titre +"<br/>Du "+ this.date_deb +' à ' + this.heure_deb+"<br/>Au "+this.date_fin +' à ' + this.heure_fin+'</td><td id="adresse">'
	        + this.adresse +'</td><td class="text-justify">'
	        + this.description +'</td><td>'
	        +'<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="consulter_presentation.html">Consulter / Editer </a></li> <li class="divider"></li> <li><a href="#" id="supprEvnt">Supprimer</a></li> </ul></div>'
	        +'</td></tr>'


	    );

	});

	var supprimer = document.getElementById('supprEvnt');

  	$(supprimer).click(function() {
		if(confirm("Voulez-vous supprimer cet événement ?")){
			alert("Evénement supprimé !");
			location.reload();

				// $.get( "http://localhost/~Apple/webprojet/projet_conf/projet_conf/server/controler_admin.php", 'supprEvenement', function( data ) {
				// 	console.log(data);
					
				// }, "json");
				
		}

	});




},"json");