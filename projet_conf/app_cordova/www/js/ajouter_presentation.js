$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getEvent',function( data ) {
	$.each(data, function() {
	    $('.liste_event').append(
	        '<option value="'+this.id+'">'+this.titre+'</option>'
	    );
	});
},"json");

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getType',function( data ) {
	$.each(data, function() {
	    $('.liste_type').append(
	        '<option value="'+this.id+'">'+this.nom_type+'</option>'
	    );
	});
},"json");

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getOrateur',function( data ) {
	$.each(data, function() {
	    $('.liste_orateur').append(
	        '<option value="'+this.id+'">'+this.nom_orateur+'</option>'
	    );
	});
},"json");

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getEntreprise',function( data ) {
	$.each(data, function() {
	    $('.liste_entreprise').append(
	        '<option value="'+this.id+'">'+this.nom_entp+'</option>'
	    );
	});
},"json");