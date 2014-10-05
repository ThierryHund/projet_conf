<?php

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/presentation.class.php";

$currentevent = Evenement::getEventArray();


if(isset($_REQUEST['accueil'])){
	$event = Evenement::getCurrentEventArray();
	$prezs = Presentation::getPrezByEvent($event['id_evnt']);
	$array['event'] = $event;
	$array['prezs'] = $prezs;
	echo json_encode($array);
}


if(isset($_REQUEST['haut'])){
    $event = Evenement::getCurrentEventArray();
	echo json_encode($event);
};

