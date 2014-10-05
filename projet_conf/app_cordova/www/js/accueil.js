	$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'accueil',function( data ) {

  //ajout description evt
  $( '.desc_event' ).html( data['event']['desc_evnt'] );
  
  //ajout logo
  $( '.logo' ).html('<img class="img-responsive" src="'+data['event']['logo']+'">' );
  
  //ajout prez suivantes
  $.each(data['prezs']['prez_suivante'], function(i, val){
		$('.next_prez' ).append( "<a href='#' class='list-group-item'><h4>"+val['heure_debut_presentation']+" "+val['heure_fin_presentation']+"</h4><p>"+val['titre_presentation']+"</p></a>")});
		
  //ajout prez en cours
  $.each(data['prezs']['prez_en_cours'], function(i, val){
		$('.current_prez' ).append( "<a href='#' class='list-group-item'><h4>"+val['heure_debut_presentation']+" "+val['heure_fin_presentation']+"</h4><p>"+val['titre_presentation']+"</p></a>")});
		
   //ajout planning
   $.each(data['prezs']['liste_prez'], function(i, val){
   
		$('.planning' ).append( "<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title' class='text-center'><a data-toggle='collapse' class='btn-block' data-parent='#accordion' href='#"+i+"'>"+i+"</a></h4></div><div id='"+i+"' class='panel-collapse collapse'></div></div>");
	
		$.each(val, function(j, val2){ $('#'+i ).append( "<a href='#' class='list-group-item'><h4>"+val2['heure_debut_presentation']+" "+val2['heure_fin_presentation']+"</h4><p>"+val2['titre_presentation']+"</p></a>")});
	
	
	
	});
							
},"json");});








