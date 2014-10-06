$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getOrganisateur',function( data ) {
	$.each(data, function() {
	    $('.liste').append(
	        '<option value="'+ this.id+ '">'+this.soc_orga+'</option>'
	    );
	});
},"json");