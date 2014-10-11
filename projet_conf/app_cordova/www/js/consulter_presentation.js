$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_presentation',function( data ) {
	$.each(data, function() {
	$('.info').append(
	        '<tr><td class="hidden">'
	        + this.id+ '</td><td>'
	        + this.titre +'</td><td>'
	        + this.description+ '</td><td>'
	        + this.nom_orateur +'</td><td>'
	        + this.prenom_orateur + '</td><td>'
	        + this.nom_entreprise+ '</td><td>'
	        // + '<button type="button" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-pencil" </span> </button>'
	        // +'<button type="button" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-remove" </span> </button>'
 
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