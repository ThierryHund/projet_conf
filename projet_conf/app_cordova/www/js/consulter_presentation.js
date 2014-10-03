$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_presentation',function( data ) {
	$.each(data, function() {
	    $('.info').append(
	        '<tr><td>'
	        + this.id+ '</td><td>'
	        + this.titre +'</td><td>'
	        + this.description+ '</td><td>'
	        + this.nom_orateur +'</td><td>'
	        + this.prenom_orateur + '</td><td>'
	        + this.nom_entreprise +'</td></tr>'
	    );
	});
},"json");