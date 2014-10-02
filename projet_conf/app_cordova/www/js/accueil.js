	$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'accueil',function( data ) {

	//ajout date evenement jour 1 
  $( 'body .container .row:nth-child(4) .panel-title .btn-block' ).html( data['date_debut'] );
  //ajout description evt
  $( '.desc_event' ).html( data['desc_evnt'] );
  //ajout logo
  $( '.logo' ).html('<img class="img-responsive" src="'+data['logo']+'">' );
  $( '.test' ).html(data['titre_evnt'] )
},"json");});

//////////////////////////////////////
////Infos pour la présentations actuelle
//////////////////////////////////////
$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'current_pres',function( data ) {

  //ajout titre présentation en cours
  $( '.pres_titre_cur' ).html( data['titre_presentation'] );
  //ajout description en cours
  $( '.pres_desc_cur' ).html( data['description'] )
  
},"json");});

//////////////////////////////////////
////Infos pour la prochaine présentations
//////////////////////////////////////
$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'next_pres',function( data ) {


  //ajout titre présentation suivante
  $( '.pres_titre_next' ).html( data['titre_presentation'] );
  //ajout description suivante
  $( 'pres_desc_next' ).html( data['description'] );
  
},"json");});

//////////////////////////////////////
////Infos pour les présentations du planning correspondant à l'événement
//////////////////////////////////////
$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'pres',function( data ) {
	/* en essai Max créé blocs du planning	
		$(' <div class="panel-group" id="accordion"><div class="panel panel-default"><div class="panel-heading"> <h4 class="panel-title" class="text-center"><a data-toggle="collapse" class="btn-block" data-parent="#accordion" href="#collapseOne"> </a></h4></div><div id="collapseOne" class="panel-collapse collapse in"><div class="panel-body"><div class="row"></div></div></div> </div></div>').appendTo('.planning');
	*/
	$('<h4 class="titre_pres" ></h4>').prependTo('body .container #collapseOne .panel-body');
	$('<div class="col-sm-4 panel" >date</div>').prependTo('body .container #collapseOne .panel-body .row');
	$('<div class="col-sm-4 panel" >heure_deb</div>').prependTo('body .container #collapseOne .panel-body .row');
	$('<div class="col-sm-4 panel" >heure_fin</div>').prependTo('body .container #collapseOne .panel-body .row');


	//ajout titre presentation
  $( 'body .container #collapseOne .panel-body .titre_pres' ).html( data['titre_presentation'] );
  //ajout date presentation
  $( 'body .container #collapseOne .panel-body .col-sm-4:nth-child(1)' ).html( data['date_presentation'] );
  //ajout heure debut presentation
  $( 'body .container #collapseOne .panel-body .col-sm-4:nth-child(2)' ).html( data['heure_debut_presentation'] );
  //ajout heure fin presentation
  $( 'body .container #collapseOne .panel-body .col-sm-4:nth-child(3)' ).html( data['heure_fin_presentation'] );
  
},"json");});







