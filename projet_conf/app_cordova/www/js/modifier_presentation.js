	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_prez= url.split("?")[1].split("=")[1];

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id:id_prez},function( data ) {
	$.each(data, function() {
	$('.info').append(
	        '<tr><td class="hidden">'
	        + this.id+ '</td><td>'
	        + this.titre_presentation +'</td><td>'
	        + this.description+ '</td><td>'
	        + this.nom +' ' + this.prenom +'</td><td>'
	        + this.entreprise+ '</td><td>'
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

},"json");})