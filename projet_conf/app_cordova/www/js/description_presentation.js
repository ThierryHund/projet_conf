	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_prez= url.split("?")[1].split("=")[1];

	var donnee = new Array();
	donnee['id'] = 4;
$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",{id:id_prez},function( data ) {
		//ajout titre presentation
		$( '.titre' ).html( data[0]['titre_presentation'] );
	

		$.each(data[0]['auteurs'], function(i, val){
			$('.orateur' ).append( "<div class='text-center'>"+val['prenom']+" "+val['nom']+"</div>"+" "+"<a href="+val['url_entp']+'" target="_blank"><img src="'+val['logo_entp']+" class='img-thumbnail'></a>");
				 
		});
		
		//ajout du logo
		$.each(data[0]['auteurs'], function(i, val){
			$( '.logo-entp' ).append('<a href="'+val['url_entp']+'" target="_blank"><img src="'+val['logo_entp']+'" class="img-responsive logo-entp"></a>')
		});
	
		//ajout date
		$( '.date' ).append( '<div>'+"Le "+data[0]['date_presentation']+'</div>' ); 
		
		//ajout type de presentation
		$( '.orateur' ).prepend( '<div>'+data[0]['type_presentation']+'</div>' );
		
		//ajout heure debut presentation
		$( '.horaires' ).append( '<div>'+"De "+data[0]['heure_debut_presentation']+" à "+data[0]['heure_fin_presentation']+'</div>' );
  
		//ajout description de la présentation
		$( '.desc' ).html( data[0]['description'] )
	
},"json");})



