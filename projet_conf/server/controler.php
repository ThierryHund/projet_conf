<?php

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/presentation.class.php";

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

if(isset($_REQUEST['haut'])){
    $event = Evenement::getCurrentEventArray();
	echo json_encode($event);
};

