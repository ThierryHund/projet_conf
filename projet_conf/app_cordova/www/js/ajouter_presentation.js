$(document).ready(function() {
		var url = window.location.href;
		var id_evt= url.split("?")[1].split("=")[1];

	$('.id_hidden').val(
		id_evt
	);


	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getType',function( data ) {
		$.each(data, function() {
			$('.liste_type').append(
				'<option value="'+this.id+'">'+this.nom_type+'</option>'
			);
		});
	},"json");

	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getOrateur',function( data ) {
		$.each(data, function() {
			$('.liste_orateur').append(
				'<option value="'+this.id+'">'+this.nom_orateur+'</option>'
			);
		});
	},"json");

	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getEntreprise',function( data ) {
		$.each(data, function() {
			$('.liste_entreprise').append(
				'<option value="'+this.id+'">'+this.nom_entp+'</option>'
			);
		});
	},"json");

	
	// validation de saisie des champs avec messages
		$("#ajout_presentation").validate({
			
				rules: {
					titre_presentation: {
						required: true,
						minlength: 2
					},
					date: {
						required: true
					},
					heure_debut: {
						required: true
					},
					heure_fin: {
						required: true
					}
				
				  },
				messages: {
					titre_presentation: {
						required: "Saisissez un titre",
						minlength: jQuery.format("Le titre doit contenir au moins 2 caractères")					
					},
					date: {
						required: "Saisissez une date"				
					},
					heure_debut: {
						required: "Saisissez une heure de début"				
					},
					heure_fin: {
						required: "Saisissez une heure de fin"				
					}
				},
				success: function(label) {
				// set &nbsp; as text for IE
				label.html("&nbsp;").addClass("checked");
				},
				highlight: function(element, errorClass) {
					$(element).parent().next().find("." + errorClass).removeClass("checked");
				},
				submitHandler: function(form) {
					 //$('#submit').attr('disabled','disabled');
	
					//envoi du formulaire
					$('form').submit(function(e){
						e.preventDefault();
						var formData= new FormData(this);
						formData.append('ajout_presentation','ajout');
						//console.log(formData);
						$.ajax({
							type: 'POST',
							data: formData,
							url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
							processData: false,
							contentType: false,
							success: function(){
								
								alert("Présentation ajoutée avec succès, retour vers la page de consultation.");
								document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/consulter_presentation.html?consulter_presentation=0?id_event="+id_evt;
							},
							error: function(){
								console.log();
								alert('error');
							}
						});
						//document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html"
					});
				}
			
		});
	
});