$(document).ready(function(){
  
  
	$("#submit").click(function(e){
		e.preventDefault();
	   $.post('http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php', 
            {login : $("#login").val(), password : $("#password").val()}, function(data){            
				
				//console.log('avant boucle : '+data);
					if(data[0] == "yes"){
						
						document.location.href = "http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html";						
						 
					}
					if(data[0] == "no"){
						
						$("#erreur").html("<p>Identifiant ou mot de passe incorrect.</p>");
					}
			
			}, 
			'json' 
        );
    });

	
});