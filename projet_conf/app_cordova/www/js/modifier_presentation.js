	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_prez= url.split("?")[1].split("=")[1];

	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id:id_prez},function( data ) {
		$.each(data, function() {
			$('.id_hidden').val(
				this.id
			);

			$('.info').append(
		        '<tr><td class="hidden">'
		        + this.id+ '</td><td>'
		        + this.titre_presentation +'</td><td>'
		        + this.description+ '</td><td>Le '
		        + this.date_presentation.replace(/\./g, "/") +' de ' 
		        + this.heure_debut.replace(':','h') +' à ' 
		        + this.heure_fin.replace(':','h')+'</td><td>'
		        + this.type+'</td></tr>'
		    );

			$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php","getType",function( data ) {
				$.each(data, function() {
				    $('.liste2').append(
				        '<option value="'+this.id+'">'+this.nom_type+'</option>'
				    );
				});
			},"json");

			$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id_orateur:this.id_orateur},function( data ) {
				$.each(data, function() {
				     $('.multiple').append(
						'<option value="'+this.id+'">'+this.nom_orateur+' '+this.prenom_orateur+'</option>'
				    );
				});
			},"json");

			$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id_presentation:id_prez},function( data ) {
				$.each(data, function() {
				    $('.info2').append(
						'<tr><td>'+this.nom_orateur+' '+this.prenom_orateur+'</td></tr>'
				    );
				});
			},"json");

		});

	},"json");
;

//envoi du formulaire
$('form').submit(function(e){
	e.preventDefault();
	var formData= new FormData(this);
	formData.append('modifier_presentation','modifier');
	//console.log(formData);
	$.ajax({
		type: 'POST',
		data: formData,
		url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
		processData: false,
		contentType: false,
		success: function(){
			
			alert('Your comment was successfully added');
			document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/modifier_presentation.html?id="+id_prez;
			
			
		},
		error: function(){
			console.log();
			alert('There was an error adding your event');
		}
	});
	//document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html"
});
})