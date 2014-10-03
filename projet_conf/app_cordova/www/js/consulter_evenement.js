$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_evenement',function( data ) {
  $.each(data, function() {
	    $('.info').append(
	        '<tr><td>'
	        + this.id+ '</td><td>'
	        + this.titre +'</td><td>'
	        + this.heure_deb+ '</td><td>'
	        + this.heure_fin +'</td><td>'
	        + this.date_deb + '</td><td>'
	        + this.date_fin+ '</td><td>'
	        + this.adresse +'</td><td>'
	        + this.description +'</td></tr>'
	    );
	});
},"json");