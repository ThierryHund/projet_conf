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
					select_orateur: {
						require_from_group: [1, ".orateur_group"]
					},
					checkbox_orateur: {
						require_from_group: [1, ".orateur_group"]
					},
					nom_orateur: {
						required: true
					},
					prenom_orateur: {
						required: true
					},
					courriel_orateur: {
						require_from_group: [1, ".contact_nv_orateur"],
						email: true
					},
					tel_orateur: {
						require_from_group: [1, ".contact_nv_orateur"],
						number:true,
						minlength:10,
						maxlength:10
					},
					select_entreprise: {
						require_from_group: [1, ".entp_group"]
					},
					checkbox_entreprise: {
						require_from_group: [1, ".entp_group"]
					},
					nom_entreprise: {
						required: true,
						minlength: 2
					},
					avatar: {
						required: true
					}
				
				  },
				messages: {
					titre_presentation: {
						required: "Saisissez un titre",
						minlength: jQuery.validator.format("Le titre doit contenir au moins 2 caractères")					
					},
					date: {
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
					select_orateur: {
						require_from_group: "Saisissez un de ces champs"
					},
					checkbox_orateur: {
						require_from_group: "Saisissez un de ces champs"
					},
					nom_orateur: {
						required: "Saisissez le nom de l'orateur"
					},
					prenom_orateur: {
						required: "Saisissez le prénom de l'orateur"
					},
					courriel_orateur: {
						require_from_group: "Saisissez un de ces champs",
						email: "Saisissez un format de courriel valide"
					},
					tel_orateur: {
						require_from_group: "Saisissez un de ces champs",
						minlength: jQuery.validator.format("Saisissez au moins 10 chiffres"),
						maxlength: jQuery.validator.format("Ne saisissez pas plus de 10 chiffres"),
						number: jQuery.validator.format("Chiffres uniquement")
					},
					select_entreprise: {
						require_from_group: "Saisissez un de ces champs"
					},
					checkbox_entreprise: {
						require_from_group: "Saisissez un de ces champs"
					},
					nom_entreprise: {
						required: "Saisissez un titre",
						minlength: jQuery.validator.format("Le nom doit contenir au moins 2 caractères")					
					},
					avatar: {
						required: "Le logo de l'événement est obligatoire"			
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