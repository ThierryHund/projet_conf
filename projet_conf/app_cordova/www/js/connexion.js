$(document).ready(function(){
  
  
	$("#submit").click(function(e){
		e.preventDefault();
	   
					
		if($("#login").val().length === 0 || $("#password").val().length === 0){
			$('#erreur').html('<p>Tous les champs doivent être remplis!</p>');
							
			 
		}

	   $.post('http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php', 
            {login : $("#login").val(), password : $("#password").val()}, function(data){            
				
					if(data[0] == "yes"){
						
						document.location.href = "http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";						
						 
					}
					//if(data[0] == "no")
					else{
						
						$("#erreur").html("<p>Identifiant ou mot de passe incorrect!</p>");
					}
			
			}, 
			'json' 
        );
    });

	
});