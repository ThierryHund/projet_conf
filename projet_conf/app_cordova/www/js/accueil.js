$(document).on('pagecreate',function(){

$.get( "http://localhost/webprojet/projet_conf/server/controler.php",'accueil',function( data ) {

//ajout titre evenement
  $( '.navbar-brand' ).html( data['titre_evnt'] );
  //ajout description evt
  $( 'body .container .row:nth-child(2) .col-lg-12' ).html( data['desc_evnt'] );
  //ajout logo
  $( 'body .container .row:nth-child(1) .col-sm-6:nth-child(1)' ).html('<img class="img-responsive" src="'+data['logo']+'">' )
},"json");});
