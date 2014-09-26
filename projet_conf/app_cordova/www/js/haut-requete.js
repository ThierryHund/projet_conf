$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'haut',function( data ) {

//ajout titre evenement
  $( '.navbar-brand' ).html( data['titre_evnt'] )
  
},"json");});
