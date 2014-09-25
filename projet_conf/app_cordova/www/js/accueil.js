$(document).on('ready',function(){

$.get( "http://127.0.0.1/projet_conf/projet_conf/server/controler.php",'accueil',function( data ) {


  //ajout description evt
  $( 'body .container .row:nth-child(2) .col-lg-12' ).html( data['desc_evnt'] );
  //ajout logo
  $( 'body .container .row:nth-child(1) .col-sm-6:nth-child(1)' ).html('<img class="img-responsive" src="'+data['logo']+'">' )
},"json");});
