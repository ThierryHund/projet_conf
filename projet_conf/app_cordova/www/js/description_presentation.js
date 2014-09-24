$.get( "http://127.0.0.1/projet_conf/projet_conf/projet_conf/server/controler.php",'description_presentation',function( data ) {

	//ajout titre presentation
  $( 'body .container .row:nth-child(1) .col-lg-6:nth-child(1)' ).html( data['titre_presentation'] );
	//ajout presentation orateur nom et prénom
  $( 'body .container .row:nth-child(2) .col-md-3:nth-child(1)' ).html( data['prenom_orateur'] +" " +data['nom_orateur'] );
  //ajout du logo
  $( 'body .container .row:nth-child(2) .col-md-3:nth-child(2)' ).html('<a href="'+data['url_entp']+'" target="_blank"><img src="'+data['logo_entp']+'"></a>');
  //ajout date
  $( 'body .container .row:nth-child(3) .col-sm-3:nth-child(1)' ).html( data['date_presentation'] );
  //ajout heure debut presentation
  $( 'body .container .row:nth-child(3) .col-sm-3:nth-child(2)' ).html( data['heure_debut_presentation'] );
  //ajout heure fin presentation
  $( 'body .container .row:nth-child(3) .col-sm-3:nth-child(3)' ).html( data['heure_fin_presentation'] );
	//ajout description de la présentation
  $( 'body .container .row:nth-child(4) .col-lg-6:nth-child(1)' ).html( data['description'] )
	
},"json");



