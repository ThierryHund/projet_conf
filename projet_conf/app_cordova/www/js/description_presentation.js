	$(document).on('ready',function(){
	
	var url = window.location.href;
var id_prez= url.split("?")[1].split("=")[1];

var donnee = new Array();
donnee['id'] = 4;
$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",{id:id_prez},function( data ) {
	//ajout titre presentation
  $( '.titre' ).html( data[0]['titre_presentation'] );
	

	 $.each(data[0]['auteurs'], function(i, val){
			$('.orateur' ).append( "<div class='text-center'>"+val['prenom']+" "+val['nom']+"</div>");
		
			//$.each(val, function(j, val2){ $('#'+i ).append( "<p class='list-group-item'>"+val2['prenom']+" "+val2['nom']+"</p>")});			 
	});
		
  //ajout du logo
  $.each(data[0]['auteurs'], function(i, val){
		$( '.logo' ).append('<a href="'+val['url_entp']+'" target="_blank"><img src="'+val['logo_entp']+'" class="img-thumbnail"></a>')});
	
  //ajout date
  $( '.date' ).html( data[0]['date_presentation'] );
  //ajout heure debut presentation
  $( '.debut' ).html( data[0]['heure_debut_presentation'] );
  //ajout heure fin presentation
  $( '.fin' ).html( data[0]['heure_fin_presentation'] );
	//ajout description de la présentation
  $( '.desc' ).html( data[0]['description'] )
	
},"json");})



