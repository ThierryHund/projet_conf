$.get( "http://localhost/projet_conf/projet_conf/server/controler.php",'consulter_presentation',function( data ) {

  $( '.titre' ).html( data['titre']);
  $( '.description' ).html( data['description']);
  $( '.nom_orateur' ).html( data['nom_orateur']);
  $( '.prenom_orateur' ).html( data['prenom_orateur']);
  $( '.nom_entreprise' ).html( data['nom_entreprise']);
  $( '.logo_entreprise' ).html( data['logo_entreprise']);
  $( '.id' ).html( data['id']);
},"json");