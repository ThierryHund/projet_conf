	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_prez= url.split("?")[1].split("=")[1];

	var donnee = new Array();
	var nextPres;
	var prevPres;
	var pres;
	donnee['id'] = 4;
$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",{id:id_prez},function( data ) {
		//ajout titre presentation
		$( '.titre' ).html( data['detail_prez'][0]['titre_presentation'] );
	
		//ajout date et heure
		$( '.date' ).append( '<p class="col-lg-12 panel text-center align">'+"Le "+data['detail_prez'][0]['date_presentation']+" de "+data['detail_prez'][0]['heure_debut_presentation']+" à "+data['detail_prez'][0]['heure_fin_presentation']+'</p>' ); 
	
		//ajout type de presentation
		$( '.orateur' ).prepend( '<h4>'+data['detail_prez'][0]['type_presentation']+" présenté(e) par "+'</h4><br/>' );
		
		//ajout orateurs et logo/lien entreprises
		$.each(data['detail_prez'][0]['auteurs'], function(i, val){
			$('.orateur' ).append( '<div class="align"><span class="col-md-4">'+val['prenom']+" "+val['nom']+" "+
			'</span><a class="col-md-offset-2 align" href="'+val['url_entp']+'" target="_blank"><img src="'+val['logo_entp']+'" class="img-responsive logo-entp"></a></div></br>');			 
		});
		
		//ajout description de la présentation
		$( '.desc' ).html( data['detail_prez'][0]['description'] );
		
		//assigne les liens des pres precedente et suivante aux boutons ajoutés
		var count = data['liste_prezs'].length;
		
		GetPrevNextPres(id_prez);
		
				$('#pres_prec' ).append( "<a href='description_presentation.html?id="+prevPres+"' class='btn btn-primary btn-resp'>Présentation précédente</a>");
				$('#pres_suiv' ).append( "<a href='description_presentation.html?id="+nextPres+"' class='btn btn-primary btn-resp'>Présentation suivante</a>");
	
	
	// Permet d'obtenir les prez précédente et suivante à partir de celle dans l'URL
	function GetPrevNextPres(id_prez) {
			for($i = 0; $i < count; $i ++) {
				if(id_prez == data['liste_prezs'][$i]['id_presentation']){
						
					if($i == 0){
						
						prevPres = data['liste_prezs'][count-1]['id_presentation'];
						nextPres = data['liste_prezs'][$i+1]['id_presentation'];
				
					}else if ($i == count-1){
						
						prevPres = data['liste_prezs'][$i-1]['id_presentation'];
						nextPres = data['liste_prezs'][0]['id_presentation'];
						
					}else {
					
						prevPres = data['liste_prezs'][$i-1]['id_presentation'];
						nextPres = data['liste_prezs'][$i+1]['id_presentation'];
					}
				}
			}
			
		}
		
	
},"json");})

		



