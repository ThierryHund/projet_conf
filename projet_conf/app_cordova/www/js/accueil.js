	$(document).on('ready',function(){

$.get( "http://thierryhund.perso.sfr.fr/server/controler.php",'accueil',function( data ) {

  //ajout description evt
  $( '.desc_event' ).html( data['event']['desc_evnt'] );
  
    if(data['event']['titre_evnt']){
		$( '.titre' ).append('<h1>'+data['event']['titre_evnt']+'</h1>');
	}
  
  //ajout logo
  $( '.logo' ).append('<img class="img-responsive center" src="'+data['event']['logo']+'">' );
  
  //ajout info evenement et organisateur
  

	
	
	
	//$( '.organisateur p' ).append('<ul class="list-unstyled">');
	
    if(data['event']['date_debut']){
		$( '.organisateur' ).append('<h4>Du '+data['event']['date_debut']+' '+data['event']['heure_debut'].replace(':','h')+' au '+data['event']['date_fin']+' '+data['event']['heure_fin'].replace(':','h'))+'</h4>';
	}	
		
    if(data['event']['adresse']){
		$( '.organisateur' ).append('<h4>Lieu : '+data['event']['adresse']+'</h4>');
	}
	
	$( '.organisateur' ).append('<h4 class="contact">');
	if(data['event']['nom_organisateur']){
		$( '.organisateur .contact' ).append('Organisé par '+data['event']['prenom_organisateur']+' '+data['event']['nom_organisateur']);
	}	

    if(data['event']['societe_organisateur']){
		$( '.organisateur .contact' ).append('Organisé par '+data['event']['societe_organisateur']+'<br/>');
	}	

    if(data['event']['tel_organisateur']){
		$( '.organisateur .contact' ).append(data['event']['tel_organisateur'])+'<br/>';
	}	
	
    if(data['event']['courriel_organisateur']){
		$( '.organisateur .contact' ).append('Mail : '+data['event']['courriel_organisateur']+'<br/>');
	}
	

	
	
	
  //ajout prez suivantes
  $.each(data['prezs']['prez_suivante'], function(i, val){
		$('.next_prez' ).append( "<a href='description_presentation.html?id="+val['id_presentation']+"' class='list-group-item "+((i%2!=0)?'active':'')+"'>De "+val['heure_debut_presentation'].replace(':','h')+" à "+val['heure_fin_presentation'].replace(':','h')+" : "+val['titre_presentation']+"</a>")});
		
  //ajout prez en cours
  $.each(data['prezs']['prez_en_cours'], function(i, val){
		$('.current_prez' ).append( "<a href='description_presentation.html?id="+val['id_presentation']+"' class='list-group-item "+((i%2!=0)?'active':'')+"'>De "+val['heure_debut_presentation'].replace(':','h')+" à "+val['heure_fin_presentation'].replace(':','h')+" : "+val['titre_presentation']+"</a>")});
		
   //ajout planning
   $.each(data['prezs']['liste_prez'], function(i, val){
   
		$('.planning' ).append( "<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title' class='text-center'><a data-toggle='collapse' class='btn-block text-center' data-parent='#accordion' href='#"+i+"'>"+i.replace(/-/g,'/')+"</a></h4></div><div id='"+i+"' class='panel-collapse collapse'></div></div>");
	
		$.each(val, function(j, val2){ $('#'+i ).append( "<a href='description_presentation.html?id="+val2['id_presentation']+"' class='list-group-item "+((j%2==0)?'active':'')+"'>De "+val2['heure_debut_presentation'].replace(':','h')+" à "+val2['heure_fin_presentation'].replace(':','h')+" : "+val2['titre_presentation']+"</h4></a>")});
	
	
	
	});
							
},"json");});








