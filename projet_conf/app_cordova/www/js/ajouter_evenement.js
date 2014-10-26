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
						required: true,
						date: true
					},
					date_fin: {
						required: true,
						date: true
					},
					heure_debut: {
						required: true,
						time: true
					},
					heure_fin: {
						required: true,
						time: true
					},
					select_organisateur: {
						require_from_group: [1, ".orga_group"]
					},
					checkbox_organisateur: {
						require_from_group: [1, ".orga_group"]
					},
					soc_orga: {
						require_from_group: [1, ".orga_nv_nom"]
					},
					nom_orga: {
						require_from_group: [1, ".orga_nv_nom"]
					},
					prenom_orga: {
						require_from_group: [1, ".orga_nv_nom"]
					},
					courriel_orga: {
						require_from_group: [1, ".orga_nv_contact"],
						email: true
					},
					tel_orga: {
						require_from_group: [1, ".orga_nv_contact"],
						number:true,
						minlength:10,
						maxlength:10
					}
					
				
				  },
				messages: {
					titre_evenement: {
						required: "Saisissez un titre",
						minlength: jQuery.validator.format("Le titre doit contenir au moins 2 caractères")					
					},
					lieu_evenement: {
						required: "Saisissez un lieu",
						minlength: jQuery.validator.format("Le lieu doit contenir au moins 2 caractères")
					},
					lat: {
						required: "Générez la latitude"
					},
					lng: {
						required: "Générez la longitude"
					},
					avatar: {
						required: "Le logo de l'événement est obligatoire"
					},
					date_debut: {
						required: "Saisissez une date de début",
						date: "Saisissez une date valide"
					},
					date_fin: {
						required: "Saisissez une date de fin",
						date: "Saisissez une date valide"
					},
					heure_debut: {
						required: "Saisissez l'heure de début",
						time: "Saisissez une heure valide"
					},
					heure_fin: {
						required: "Saisissez l'heure de fin",
						time: "Saisissez une heure valide"
					},
					select_organisateur: {
						require_from_group: "Saisissez un de ces champs"
					},
					checkbox_organisateur: {
						require_from_group: "Saisissez un de ces champs"
					},
					soc_orga: {
						require_from_group: "Saisissez un de ces champs"
					},
					nom_orga: {
						require_from_group: "Saisissez un de ces champs"
					},
					prenom_orga: {
						require_from_group: "Saisissez un de ces champs"
					},
					courriel_orga: {
						require_from_group: "Saisissez un de ces champs",
						email: "Saisissez un format de courriel valide"
					},
					tel_orga: {
						require_from_group: "Saisissez un de ces champs",
						minlength: jQuery.validator.format("Saisissez au moins 10 chiffres"),
						maxlength: jQuery.validator.format("Ne saisissez pas plus de 10 chiffres"),
						number: jQuery.validator.format("Chiffres uniquement")
					}
					
				},
				success: function(label) {
					// set &nbsp; as text for IE
					label.html("&nbsp;").addClass("checked");
				},
				highlight: function (element, errorClass) {
					$(element).siblings('label').removeClass('checked');
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



