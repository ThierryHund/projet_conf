	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_prez= url.split("?")[1].split("=")[1];

	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id:id_prez},function( data ) {
		$.each(data, function() {
		$('.info').append(
		        '<tr><td class="hidden">'
		        + this.id+ '</td><td>'
		        + this.titre_presentation +'</td><td>'
		        + this.description+ '</td><td>Le '
		        + this.date_presentation +' de ' 
		        + this.heure_debut +' à ' 
		        + this.heure_fin+'</td><td>'
		        + this.nom_orateur +' ' + this.prenom_orateur+ '</td></tr>'

		    );
		});
	},"json")
;})

