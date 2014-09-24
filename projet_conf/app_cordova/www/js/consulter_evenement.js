$.get( "http://localhost/projet_conf/projet_conf/server/controler.php",'consulter_evenement',function( data ) {

  $( '.titre' ).html( data['titre']);
  $( '.heure_deb' ).html( data['heure_deb']);
  $( '.heure_fin' ).html( data['heure_fin']);
  $( '.date_deb' ).html( data['date_deb']);
  $( '.date_fin' ).html( data['date_fin']);
  $( '.logo' ).html( data['logo']);
  $( '.adresse' ).html( data['adresse']);
  $( '.latitude' ).html( data['latitude']);
  $( '.longitude' ).html( data['longitude']);
  $( '.id' ).html( data['id']);
},"json");