<?php

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/presentation.class.php";
require_once "modele/dao/sendmail.class.php";

$currentevent = Evenement::getEventArray();


if(isset($_REQUEST['accueil'])){
	$event = Evenement::getCurrentEventArray();
	$prezs = Presentation::getPrezByEvent($event['id_evnt']);
	$array['event'] = $event;
	$array['prezs'] = $prezs;
	echo json_encode($array);
}

if(isset($_REQUEST['id'])){
	$event = Evenement::getCurrentEventArray();
	$prezs = Presentation::getPrezsOrdered($event['id_evnt']);
    $prez = Presentation::getPresentation($_REQUEST['id']);	
	$array['liste_prezs'] = $prezs;
	$array['detail_prez'] = $prez;
	echo json_encode($array);
}

if(isset($_REQUEST['haut'])){
    $event = Evenement::getCurrentEventArray();
	echo json_encode($event);
}

if(isset($_REQUEST['getPosition'])){
    $position = Evenement::getCurrentEventArray();
    echo json_encode($position);
}

if(isset($_POST['send_mail'])) {
	$subject = $_POST['subject'];
	$texte = $_POST['message'];
	$mailFrom = $_POST['email'];
    SendMail::SendEmail($subject,$texte,$mailFrom);
}

