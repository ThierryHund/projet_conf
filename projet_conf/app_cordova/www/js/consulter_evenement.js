$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_evenement',function( data ) {
  $.each(data, function() {
	    $('.info').append(
	        '<tr><td>'
	        // + this.id+ '</td><td>'
	        + this.titre +'</td><td>'
	        + this.heure_deb+ '</td><td>'
	        + this.heure_fin +'</td><td>'
	        + this.date_deb + '</td><td>'
	        + this.date_fin+ '</td><td>'
	        + this.adresse +'</td><td>'
	        + this.description +'</td><td>'
	        // + '<button type="button" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-pencil" </span> </button>'
	        // +'<button type="button" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-remove" </span> </button>'
 
	        +'<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret" ></span></button> <ul class="dropdown-menu" role="menu"> <li><a href="ajout_presentation.html">Ajouter présentation</a></li> <li><a href="#">Editer</a></li> <li class="divider"></li> <li><a href="#">Supprimer</a></li> </ul></div>'
	        +'</td></tr>'


	    );

	});
},"json");