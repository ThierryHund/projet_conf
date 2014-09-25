$(document).on('ready',function(){

$.get( "http://127.0.0.1/projet_conf/projet_conf/server/controler.php",'accueil',function( data ) {


  //ajout description evt
  $( 'body .container .row:nth-child(2) .col-lg-12' ).html( data['desc_evnt'] );
  //ajout logo
  $( 'body .container .row:nth-child(1) .col-sm-6:nth-child(1)' ).html('<img class="img-responsive" src="'+data['logo']+'">' )
},"json");});

$(document).on('ready',function(){

$.get( "http://127.0.0.1/projet_conf/projet_conf/server/controler.php",'description_presentation',function( data ) {

/*	//ajout date jour 1 presentation
  $( 'body .container .row:nth-child(4) .col-lg-12 panel:nth-child(1) .panel panel-default:nth-child(1) .panel-heading .panel-title .a #date_jour1' ).html( data['date_presentation'] );
  */
  //ajout date jour 1 presentation
  $( 'body .container .row:nth-child(4) span.date_jour1' ).html( data['date_presentation'] );
	//ajout titre presentation
  $( 'body .container #collapseOne .panel-body .titre_pres' ).html( data['titre_presentation'] );
  //ajout description presentation
  $( 'body .container #collapseOne .panel-body .description' ).html( data['description'] )
  
},"json");});
