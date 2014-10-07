	$(document).on('ready',function(){

$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'accueil',function( data ) {

  //ajout description evt
  $( '.desc_event' ).html( data['event']['desc_evnt'] );
  
  //ajout logo
  $( '.logo' ).html('<img class="img-responsive" src="'+data['event']['logo']+'">' );
  
  //ajout info evenement et organisateur
  
    if(data['event']['titre_evnt']){
		$( '.organisateur' ).append('<h3>'+data['event']['titre_evnt']+'</h3>');
	}
	
	$( '.organisateur' ).append('<p>');
	
	$( '.organisateur p' ).append('<ul class="list-unstyled">');
	
    if(data['event']['date_debut']){
		$( '.organisateur p' ).append('<li>'+data['event']['date_debut']+'</li>');
	}
	
    if(data['event']['date_fin']){
		$( '.organisateur p' ).append('<li>'+data['event']['date_fin']+'</li>');
	}	
	
    if(data['event']['heure_debut']){
		$( '.organisateur p' ).append('<li>'+data['event']['heure_debut']+'</li>');
	}		
	
    if(data['event']['heure_fin']){
		$( '.organisateur p' ).append('<li>'+data['event']['heure_fin']+'</li>');
	}	
	
	
    if(data['event']['nom_organisateur']){
		$( '.organisateur p' ).append('<li>'+data['event']['nom_organisateur']+'</li>');
	}

    if(data['event']['prenom_organisateur']){
		$( '.organisateur p' ).append('<li>'+data['event']['prenom_organisateur']+'</li>');
	}	

    if(data['event']['societe_organisateur']){
		$( '.organisateur p' ).append('<li>'+data['event']['societe_organisateur']+'</li>');
	}	

    if(data['event']['tel_organisateur']){
		$( '.organisateur p' ).append('<li>'+data['event']['tel_organisateur']+'</li>');
	}	
	
    if(data['event']['courriel_organisateur']){
		$( '.organisateur p' ).append('<li>'+data['event']['courriel_organisateur']+'</li>');
	}
	
    if(data['event']['adresse']){
		$( '.organisateur p' ).append('<li>'+data['event']['adresse']+'</li>');
	}
	
	
	
  //ajout prez suivantes
  $.each(data['prezs']['prez_suivante'], function(i, val){
		$('.next_prez' ).append( "<a href='description_presentation.html?id="+val['id_presentation']+"' class='list-group-item "+((i%2!=0)?'active':'')+"'><h4>"+val['heure_debut_presentation']+" "+val['heure_fin_presentation']+"</h4><p>"+val['titre_presentation']+"</p></a>")});
		
  //ajout prez en cours
  $.each(data['prezs']['prez_en_cours'], function(i, val){
		$('.current_prez' ).append( "<a href='description_presentation.html?id="+val['id_presentation']+"' class='list-group-item "+((i%2!=0)?'active':'')+"'><h4>"+val['heure_debut_presentation']+" "+val['heure_fin_presentation']+"</h4><p>"+val['titre_presentation']+"</p></a>")});
		
   //ajout planning
   $.each(data['prezs']['liste_prez'], function(i, val){
   
		$('.planning' ).append( "<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title' class='text-center'><a data-toggle='collapse' class='btn-block text-center' data-parent='#accordion' href='#"+i+"'>"+i+"</a></h4></div><div id='"+i+"' class='panel-collapse collapse'></div></div>");
	
		$.each(val, function(j, val2){ $('#'+i ).append( "<a href='description_presentation.html?id="+val2['id_presentation']+"' class='list-group-item "+((j%2==0)?'active':'')+"'><h4>"+val2['heure_debut_presentation']+" "+val2['heure_fin_presentation']+"</h4><p>"+val2['titre_presentation']+"</p></a>")});
	
	
	
	});
							
},"json");});








