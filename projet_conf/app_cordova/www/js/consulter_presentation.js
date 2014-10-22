$(document).ready(function(){
	var id_presentation;
	var supprime = document.getElementById('supprPres');

	$(supprime).click(function() {
		supprimePres();
	});

});


var url = window.location.href;
var id_evt= url.split("?")[2].split("=")[1];

$('.button_ajout').append(
	'<a href="ajout_presentation.html?id_evt='+id_evt+'" role="button" class="btn btn-primary btn-resp">Ajouter Présentation</a>'
);
$('.button_retour').append(
		'<a href="editer_categories.html" role="button" class="btn btn-primary btn-resp">Modifier les catégories</a>'
	);

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{ consulter_presentation: 0, id_evenement: id_evt },function( data ) {
	$.each(data, function() {
		var auteurs = new Array();
		var entreprises = new Array();
		$.each(this.auteurs, function() {auteurs += this.nom_orateur +' '+ this.prenom_orateur+'<br/>';
											entreprises +=this.nom_entreprise+'<br/>'});
	$('.infoPres').append(
	        '<tr><td class="hidden">'
	        + this.id+ '</td><td>'
	        + this.titre +'</td><td class="text-justify">'
	        + ((this.description.length<300)?this.description:(this.description.substring(0,300)+"..."))+ '</td><td>'
	        + auteurs + '</td><td>'
	        + entreprises + '</td><td>'
	        +'<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="modifier_presentation.html?id='
	        +this.id+'">Editer</a></li> <li class="divider"></li> <li> <a href="javascript:supprimePres('+this.id+');" id="supprPres">Supprimer</a></li></ul></div>'
	        +'</td></tr>'

	    );

	});
	

},"json");

function supprimePres(id_presentation) {

    var confirmation = confirm( "Voulez vous vraiment supprimer cette présentation ?" );
		if( confirmation )
			{	

				$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php", { consulter_presentation: 0, id_evenement: id_evt, id_prez : id_presentation }, function( data ) {
					$.each(data, function() {
					var auteurs = new Array();
					var entreprises = new Array();
					$.each(this.auteurs, function() {auteurs += this.nom_orateur +' '+ this.prenom_orateur+'<br/>';
												entreprises +=this.nom_entreprise+'<br/>'});
					$('.infoPres').html('');
					$('.infoPres').append(
						        '<tr><td class="hidden">'
						        + this.id+ '</td><td>'
						        + this.titre +'</td><td class="text-justify">'
						        + ((this.description.length<300)?this.description:(this.description.substring(0,300)+"..."))+ '</td><td>'
						        + auteurs + '</td><td>'
						        + entreprises + '</td><td>'
						        +'<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="modifier_presentation.html?id='
						        +this.id+'">Editer</a></li> <li class="divider"></li> <li> <a href="javascript:supprimePres('+this.id+');" id="supprPres">Supprimer</a></li></ul></div>'
						        +'</td></tr>'

						);

				
					});


				},"json");
			  location.reload();
			}

}