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
		        + this.date_presentation +' de ' 
		        + this.heure_debut +' à ' 
		        + this.heure_fin+'</td><td>'
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
				
				    $('.liste').append(
				        '<option value="'+this.id+'">'+this.nom_orateur+' '+this.prenom_orateur+'</option>'
				    );

				    $('.info2').append(
				        '<tr><td>'
				        + this.nom_orateur+' '+this.prenom_orateur+'</td></tr>'
				    );
				});
			},"json");
		});
			
	},"json")
;})



