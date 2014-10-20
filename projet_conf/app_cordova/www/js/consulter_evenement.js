$(document).ready(function(){
	var identifiant;
	var supprimer = document.getElementById('supprEvnt');

	$(supprimer).click(function() {
		supprimeEvent();
	});

});

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_evenement',function( data ) {
   $.each(data, function() {
	    $('.infoEvent').append(
	        '<tr><td class="hidden">'
	        + this.id+ '</td><td>'
	        + this.titre +"<br/>Du "+ this.date_deb +' à ' + this.heure_deb+"<br/>Au "+this.date_fin +' à ' + this.heure_fin+'</td><td id="adresse">'
	        + this.adresse +'</td><td class="text-justify">'
	        +((this.description.length<300)?this.description:(this.description.substring(0,300)+"...")) +'</td><td>'
	        +'<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="consulter_presentation.html?consulter_presentation=0?id_evt='+this.id+'">Consulter </a></li> <li><a href="modifier_evenement.html?id_evt='+this.id+'"> Modifier </a></li> <li class="divider"></li> <li> <a href="javascript:supprimeEvent('+this.id+');" id="supprEvnt">Supprimer</a></li> </ul></div>'
	        +'</td></tr>'


	    );

	});

},"json");


function supprimeEvent(identifiant) {

    var confirmation = confirm( "Voulez vous vraiment supprimer cet événement ?" );
		if( confirmation )
			{	

				$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id_event : identifiant },function( data ) {
				$('.infoEvent').html('');
				$.each(data, function() {
				$('.infoEvent').append(
							'<tr><td class="hidden">'
							+ this.id+ '</td><td>'
							+ this.titre +"<br/>Du "+ this.date_deb +' à ' + this.heure_deb+"<br/>Au "+this.date_fin +' à ' + this.heure_fin+'</td><td id="adresse">'
							+ this.adresse +'</td><td class="text-justify">'
							+((this.description.length<300)?this.description:(this.description.substring(0,300)+"...")) +'</td><td>'
							+'<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="consulter_presentation.html?id_event='+this.id+'">Consulter </a></li> <li><a href="modifier_evenement.html?id_evt='+this.id+'"> Modifier </a></li> <li class="divider"></li> <li> <a href="javascript:supprimeEvent('+this.id+');" id="supprEvnt">Supprimer</a></li> </ul></div>'
							+'</td></tr>'


						);

						});

						},"json");
			  document.location.href = "accueil.html";

			}

}
