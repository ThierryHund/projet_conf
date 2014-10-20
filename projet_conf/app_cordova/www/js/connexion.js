$(document).ready(function(){
   
/*
   //envoi du formulaire
$('form').submit(function(e){
	e.preventDefault();
	var formData= new FormData(this);
	//formData.append('connexion','ajout');
	//console.log(formData);
	$.ajax({
		type: 'POST',
		data: formData,
		url: 'http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php',
		processData: false,
		contentType: false,
		dataType : 'text',
		success: function(data){
		//console.log(data);

		
			if(data == "yes"){
				console.log(data);
				document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";
			}else{	
			
				$("#erreur").html("<p>Erreur lors de la connexion...</p>");
			}
			//your comment was successfully added');
			//document.location.href="http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";
		},
		error: function(){
			console.log('error');
			//alert('error');
			
		}
		
	});
	
});
 */
  
  
	$("#submit").click(function(e){
		e.preventDefault();
	   $.post('http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php', 
            {login : $("#login").val(), password : $("#password").val()}, function(data){            
				
				var count = data.length;
				for($i = 0; $i < count; $i ++) {

					if(data[$i] == "yes"){

						console.log(data);
						 document.location.href = "http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";
						//$("#erreur").html("<p>connectéééééééé...</p>");
						 
					}
					else{

						$("#erreur").html("<p>Erreur lors de la connexion...</p>");
						//$(location).attr('href','http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/index.html');
					}
				}
			
			}, 
			'json' 
        );
    });

	
});