$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'consulter_evenement',function( data ) {

  $( '.titre' ).html( data['titre']);
  $( '.heure_deb' ).html( data['heure_deb']);
  $( '.heure_fin' ).html( data['heure_fin']);
  $( '.date_deb' ).html( data['date_deb']);
  $( '.date_fin' ).html( data['date_fin']);
  $( '.adresse' ).html( data['adresse']);
  $( '.id' ).html( data['id']);
  $( '.desc' ).html( data['description']);
},"json");