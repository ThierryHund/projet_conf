$(document).ready(function(){
    $("#connexion").click(function{
        $.post('http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php', 
            {login : $("#login").val(), password : $("#password").val()}, function(data){ 
            
			},
            'text' 
        );
    });
});