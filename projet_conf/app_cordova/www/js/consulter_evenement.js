$.get( "http://localhost/projet_conf/projet_conf/server/controler.php",'consulter_evenement',function( data ) {

  $( '.info' ).html( '<td>"'+data['titre']+'"');
  $( '.info' ).html( '<td>"'+data['heure_deb']+'"');
  $( '.info' ).html( '<td>"'+data['heure_fin']+'"');
  $( '.info' ).html( '<td>"'+data['date_deb']+'"');
  $( '.info' ).html( '<td>"'+data['date_fin']+'"');
  $( '.info' ).html( '<td>"'+data['logo']+'"');
  $( '.info' ).html( '<td>"'+data['titre']+'"');
  $( '.info' ).html( '<td>"'+data['adresse']+'"');
  $( '.info' ).html( '<td>"'+data['latitude']+'"');
  $( '.info' ).html( '<td>"'+data['longitude']+'"');

},"json");