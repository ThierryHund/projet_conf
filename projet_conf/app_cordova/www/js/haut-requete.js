$(document).on('ready',function(){

$.get( "http://127.0.0.1/projet_conf/projet_conf/server/controler.php",'haut',function( data ) {

//ajout titre evenement
  $( '.navbar-brand' ).html( data['titre_evnt'] )
  
},"json");});
