	$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'accueil',function( data ) {

	//ajout date evenement jour 1 
  $( 'body .container .row:nth-child(4) .panel-title span.date_jour1' ).html( data['date_debut'] );
  //ajout description evt
  $( 'body .container .row:nth-child(2) .col-lg-12' ).html( data['desc_evnt'] );
  //ajout logo
  $( 'body .container .row:nth-child(1) .col-sm-6:nth-child(1)' ).html('<img class="img-responsive" src="'+data['logo']+'">' )
},"json");});

//////////////////////////////////////
////Infos pour la présentations actuelle
//////////////////////////////////////
$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'current_pres',function( data ) {

  //ajout titre présentation en cours
  $( 'body .container .row:nth-child(3) .col-lg-12:nth-child(1) .panel-title' ).html( data['titre_presentation'] );
  //ajout description en cours
  $( 'body .container .row:nth-child(3) .col-lg-12:nth-child(1) .panel-body .col-lg-11' ).html( data['description'] )
  
},"json");});

//////////////////////////////////////
////Infos pour la prochaine présentations
//////////////////////////////////////
$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'next_pres',function( data ) {


  //ajout titre présentation suivante
  $( 'body .container .row:nth-child(3) .col-lg-12:nth-child(2) .panel-title' ).html( data['titre_presentation'] );
  //ajout description suivante
  $( 'body .container .row:nth-child(3) .col-lg-12:nth-child(2) .panel-body .col-lg-11' ).html( data['description'] );
  
},"json");});

//////////////////////////////////////
////Infos pour les présentations du planning correspondant à l'événement
//////////////////////////////////////
$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'pres',function( data ) {

	//ajout titre presentation
  $( 'body .container #collapseOne .panel-body .titre_pres' ).html( data['titre_presentation'] );
  //ajout description presentation
  $( 'body .container #collapseOne .panel-body .description' ).html( data['description'] )
  
},"json");});







