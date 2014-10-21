$(document).ready(function(){
	var identifiant;
	var supprimer = document.getElementById('supprEvnt');

	$(supprimer).click(function() {
		supprimeEvent();
	});

});

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_evenement',function( data ) {
	
	var d = new Date();
	var date_auj = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() +" " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
	
	var count = data.length;
		
			
			
		for ( var i = 0 ; i < count ; i++){
			if ( data[i]['tmp_fin'] > date_auj ){		
				$('.next_event').append('<h2>Evénements en cours et à venir </h2><table class="table table-striped table-bordered "> <thead><tr class="warning"><th class="hidden">Id</th><th>Titre événement</th><th>Adresse</th><th>Description</th><th></th></tr></thead><tbody class="infoEvent"> </tbody></table>');
			break;
			}
		}
			$.each(data, function() {
				if(this.tmp_fin > date_auj){
					$('.infoEvent').append(
						'<tr><td class="hidden">'
						+ this.id+ '</td><td>'
						+ this.titre +"<br/>Du "+ this.date_deb +' à ' + this.heure_deb+"<br/>Au "+this.date_fin +' à ' + this.heure_fin+'</td><td id="adresse">'
						+ this.adresse +'</td><td class="text-justify">'
						+((this.description.length<300)?this.description:(this.description.substring(0,300)+"...")) +'</td><td>'
						+'<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="consulter_presentation.html?consulter_presentation=0?id_evt='+this.id+'">Consulter </a></li> <li><a href="modifier_evenement.html?id_evt='+this.id+'"> Modifier </a></li> <li class="divider"></li> <li> <a href="javascript:supprimeEvent('+this.id+');" id="supprEvnt">Supprimer</a></li> </ul></div>'
						+'</td></tr>'

					);
				}
			});
			
		 
		for ( var i = 0 ; i < count ; i++){
			if ( data[i]['tmp_fin'] < date_auj ){		
				$('.past_event').append('<h2>Evénements passés </h2><table class="table table-bordered "> <thead><tr><th class="hidden">Id</th><th>Titre événement</th><th>Adresse</th><th>Description</th><th></th></tr></thead><tbody class="infoPastEvent"> </tbody></table>');
			break;
			}
		}
		
			$.each(data, function() {
				if(this.tmp_fin < date_auj){
					$('.infoPastEvent').append(
						'<tr class="success"><td class="hidden">'
						+ this.id+ '</td><td>'
						+ this.titre +"<br/>Du "+ this.date_deb +' à ' + this.heure_deb+"<br/>Au "+this.date_fin +' à ' + this.heure_fin+'</td><td id="adresse">'
						+ this.adresse +'</td><td class="text-justify">'
						+((this.description.length<300)?this.description:(this.description.substring(0,300)+"...")) +'</td><td>'
						+'<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="consulter_presentation.html?consulter_presentation=0?id_evt='+this.id+'">Consulter </a></li> <li><a href="modifier_evenement.html?id_evt='+this.id+'"> Modifier </a></li> <li class="divider"></li> <li> <a href="javascript:supprimeEvent('+this.id+');" id="supprEvnt">Supprimer</a></li> </ul></div>'
						+'</td></tr>'

					);
				}
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
