$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_presentation',function( data ) {
	$( '.id' ).html('<td>'+data['id']+'</td>');
	$( '.titre' ).html('<td>'+data['titre']+'</td>');
	$( '.description' ).html('<td>'+data['description']+'</td>');
	$( '.nom_orateur' ).html('<td>'+data['nom_orateur']+'</td>');
	$( '.prenom_orateur' ).html('<td>'+data['prenom_orateur']+'</td>');
	$( '.nom_entreprise' ).html('<td>'+data['nom_entreprise']+'</td>');
},"json");