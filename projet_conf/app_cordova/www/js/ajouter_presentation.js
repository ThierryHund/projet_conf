$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getEvent',function( data ) {
	$.each(data, function() {
	    $('.liste_event').append(
	        '<option value="'+ this.id+'">'+this.titre+'</option>'
	    );
	});
},"json");

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getTypePres',function( data ) {
	$.each(data, function() {
	    $('.liste_type').append(
	        '<option value="'+ this.id+'">'+this.nom+'</option>'
	    );
	});
},"json");