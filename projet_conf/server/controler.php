<?php

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/presentation.class.php";

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
            	header('location:..\app_cordova\www\connexion.html');
            }
            else header('location:..\app_cordova\www\accueil.html');
	}
}

$currentevent = Evenement::getEventArray();


if(isset($_REQUEST['accueil'])){
	$event = Evenement::getCurrentEventArray();
	
	echo json_encode($event);
}

if(isset($_REQUEST['current_pres'])){
    $current_pres = Presentation::getCurrentPres();
    echo json_encode($current_pres);
}

if(isset($_REQUEST['next_pres'])){
    $next_pres = Presentation::getNextPres();
    echo json_encode($next_pres);
}

if(isset($_REQUEST['pres'])){
    $pres = Presentation::getPresentation();
    echo json_encode($pres);
}

if(isset($_REQUEST['consulter_evenement'])){
    $event = Evenement::getEventArray();
    echo json_encode($event);
}

if(isset($_REQUEST['haut'])){
    $event = Evenement::getCurrentEventArray();
	echo json_encode($event);
};

