	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_prez= url.split("?")[1].split("=")[1];

	var donnee = new Array();
	donnee['id'] = 4;
$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",{id:id_prez},function( data ) {
		//ajout titre presentation
		$( '.titre' ).html( data[0]['titre_presentation'] );
	
		//ajout date et heure
		$( '.date' ).append( '<p class="col-lg-12 panel align">'+"Le "+data[0]['date_presentation']+" de "+data[0]['heure_debut_presentation']+" à "+data[0]['heure_fin_presentation']+'</p>' ); 
	
		//ajout type de presentation
		$( '.orateur' ).prepend( '<h4>'+data[0]['type_presentation']+" présenté(e) par "+'</h4><br/>' );
		
		//ajout orateurs et logo/lien entreprises
		$.each(data[0]['auteurs'], function(i, val){
			$('.orateur' ).append( '<div class="align"><span class="col-md-3">'+val['prenom']+" "+val['nom']+" "+
			'</span><a class="col-md-offset-3 align" href="'+val['url_entp']+'" target="_blank"><img src="'+val['logo_entp']+'" class="img-responsive logo-entp"></a></div></br>');			 
		});
		
		//ajout description de la présentation
		$( '.desc' ).html( data[0]['description'] )
	
},"json");})



