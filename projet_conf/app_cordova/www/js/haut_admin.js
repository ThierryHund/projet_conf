$('body').prepend(
"	<div class='navbar navbar-default' role='navigation'>" +
"		<div class='container'>" +
"			<div class='navbar-header'>" +
"				<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>" +
"					<span class='icon-bar'></span>" +
"					<span class='icon-bar'></span>" +
"					<span class='icon-bar'></span>" +				
"				</button>" +
"				<a class='navbar-brand' href='http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/index.html'></a>" +
"			</div>" +
"			<div class='collapse navbar-collapse'>" +
"				<ul class='nav navbar-nav'>" +
"					<li class='active'><a href='accueil.html'>Accueil</a></li>" +
"				</ul>" +
"				 <ul class='nav navbar-nav navbar-right'>" +
"            			<li><a class='deconnexion' href='connexion.html'>Déconnexion</a></li>" +
"         		 </ul>" +
"			</div>" +
"			<!--/.nav-collapse -->" +
"		</div>" +
"	</div>" 
);

$('.deconnexion').click(function(){
		   $.get('http://localhost/webprojet/projet_conf/projet_conf/server/controler_admin.php', 
            'deconnexion', function(data){   
					
			},"json");});