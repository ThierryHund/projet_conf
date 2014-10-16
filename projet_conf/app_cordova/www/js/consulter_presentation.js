	var url = window.location.href;
	var id_evt= url.split("?")[1].split("=")[1];

$('.button_ajout').append(
	'<a href="ajout_presentation.html?id_evt='+id_evt+'" role="button" class="btn btn-primary">Ajouter Présentation</a>'
);

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{ consulter_presentation: 0, id_event: id_evt },function( data ) {
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
	        + entreprises+ '</td><td>'
	        +'<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="modifier_presentation.html?id='
	        +this.id+'">Editer</a></li> <li class="divider"></li> <li><a href="#" id="suppr">Supprimer</a></li> </ul></div>'
	        +'</td></tr>'

	    );
	});
	
	var supprimer = document.getElementById('suppr');

  	$(supprimer).click(function() {
		if(confirm("Voulez-vous supprimer cette présentation ?")){
			alert("Présentation supprimée !");
			location.reload();

				// $.get( "http://localhost/~Apple/webprojet/projet_conf/projet_conf/server/controler_admin.php", 'supprEvenement', function( data ) {
				// 	console.log(data);
					
				// }, "json");
				
		}

	});

},"json");