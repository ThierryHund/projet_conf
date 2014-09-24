<?php

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";

$conn = Connection::get ();

if(isset($_POST['connexion']))
{
	if(isset($_POST['login']) && isset($_POST['password'])){
		$login=$_POST['login'];
		$password=$_POST['password'];

		$verif_login = $conn->query('SELECT *
            FROM admin
            WHERE admin.identifiant_admin LIKE "'.$login.'"
            AND admin.mdp_admin LIKE "'.$password.'"');

            $liste = $verif_login->fetchAll();
            if (count($liste) == 0) { 
            	header('location:..\app_cordova\www\connexion.html')
            }
            else //lancement variable session
	}
}

 elseif(isset($_REQUEST['accueil'])){
	$event = Evenement::getCurrentEventArray();
	echo json_encode($event);

};  



