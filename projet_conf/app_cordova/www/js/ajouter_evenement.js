$.get( "http://localhost/projet_conf/projet_conf/server/controler.php",'getOrganisateur',function( data ) {

  $( '.liste' ).html( data['id']);
},"json");