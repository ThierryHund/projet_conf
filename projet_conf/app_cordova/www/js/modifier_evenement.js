	$(document).on('ready',function(){
	
	var url = window.location.href;
	var id_evt= url.split("?")[1].split("=")[1];

	$.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php",{id_evt:id_evt},function( data ) {
		$.each(data, function() {
			$('.id_hidden').val(
				this.id
			);

			$('.info').append(
		        '<tr><td class="hidden">'
		        + this.id+ '</td><td>'
		        + this.titre +'</td><td>'
		        + this.description+ '</td></tr>'
		    );

			$('.info2').append(
		        '<tr><td>'
		        + this.adresse+'</td><td>Du '
		        + this.date_deb.replace(/\./g, "/")+' au '
		        + this.date_fin.replace(/\./g, "/")+'</td><td>De '
		        + this.heure_deb.replace(':','h')+' à '
		        + this.heure_fin.replace(':','h')+'</td></tr>'
		    );
		    
		});

	},"json");

//envoi du formulaire
$('form').submit(function(e){
	e.preventDefault();
	var formData= new FormData(this);
	formData.append('modifier_evenement','modifier');
	//console.log(formData);
	$.ajax({
		type: 'POST',
		data: formData,
		url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
		processData: false,
		contentType: false,
		success: function(){
			
			//alert('Your comment was successfully added');
			document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/modifier_evenement.html?id="+id_evt;
			
			
		},
		error: function(){
			console.log();
			alert('error');
		}
	});
	
});


;})

