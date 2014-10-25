$(document).ready(function() {

	//on recupere la liste d'organisateur pour le formulaire
	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",'getOrganisateur',function( data ) {
		$.each(data, function() {
			$('.liste').append(
				'<option value="'+ this.id+ '">'+this.soc_orga+'</option>'
			);
		});
	},"json");


		// validation de saisie des champs avec messages
		$("#ajout_evenement").validate({
			
				rules: {
					titre_evenement: {
						required: true,
						minlength: 2
					},
					lieu_evenement: {
						required: true,
						minlength: 2
					},
					lat: {
						required: true
					},
					lng: {
						required: true
					},
					avatar: {
						required: true
					},
					date_debut: {
						required: true
					},
					date_fin: {
						required: true
					},
					heure_debut: {
						required: true
					},
					heure_fin: {
						required: true
					},
					select_organisateur: {
						required: true
					}
				
				  },
				messages: {
					titre_evenement: {
						required: "Saisissez un titre",
						minlength: jQuery.format("Le titre doit contenir au moins 2 caractères")					
					},
					lieu_evenement: {
						required: "Saisissez un lieu",
						minlength: jQuery.format("Le lieu doit contenir au moins 2 caractères")
					},
					lat: {
						required: "Générez la latitude"
					},
					lng: {
						required: "Générez la longitude"
					},
					avatar: {
						required: "La photo de l'événement est obligatoire"
					},
					date_debut: {
						required: "Saisissez une date de début"
					},
					date_fin: {
						required: "Saisissez une date de fin"
					},
					heure_debut: {
						required: "Saisissez l'heure de début"
					},
					heure_fin: {
						required: "Saisissez l'heure de fin"
					},
					select_organisateur: {
						required: "Saisissez un organisateur"
					}
					
				},
				submitHandler: function(form) {
					 //$('#submit').attr('disabled','disabled');
					//envoi du formulaire
					$(form).submit(function(e){
						e.preventDefault();
						var formData= new FormData(this);
						formData.append('ajout_evenement','ajout');
						console.log(formData);
						$.ajax({
							type: 'POST',
							data: formData,
							url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
							processData: false,
							contentType: false,
							success: function(){
								
								alert("Evénement ajouté avec succès, retour vers la page d'accueil administrateur.");
								document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";
								
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



