<?php

header('Content-type: text/html; charset=UTF-8'); 

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/entreprise.class.php";
require_once "modele/dao/presentation.class.php";
require_once "modele/dao/organisateur.class.php";
require_once "modele/dao/type_presentation.class.php";
require_once "modele/dao/orateur.class.php";
require_once "uploadImages.class.php";

$conn = Connection::get ();

if(isset($_POST['connexion'])){
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

if(isset($_REQUEST['getOrganisateur'])){
    $orga = Organisateur::getOrganisateur();
    echo json_encode($orga);
}

if(isset($_REQUEST['getEvent'])){
    $event = Evenement::getEventArray();
    echo json_encode($event);
}

if(isset($_REQUEST['getType'])){
    $type = Type_presentation::getType();
    echo json_encode($type);
}

if(isset($_REQUEST['getOrateur'])){
    $orateur = Orateur::getOrateur();
    echo json_encode($orateur);
}

if(isset($_REQUEST['consulter_evenement'])){
    $event = Evenement::getEventArray();
    echo json_encode($event);
}

if(isset($_REQUEST['consulter_presentation'])){
    $pres = Presentation::getPresArray();
    echo json_encode($pres);
}

if(isset($_REQUEST['getEntreprise'])){
    $entp = Entreprise::getEntreprises();
    echo json_encode($entp);
}

if(isset($_REQUEST['id'])){
    $prez = Presentation::getPresArrayByPresId($_REQUEST['id']);
    echo json_encode($prez);
}

if(isset($_POST['ajout_evenement'])){
    $img = new UploadImages('avatar');
    $imgName = $img->getName();
    $dir = dirname("http://localhost/webprojet/projet_conf/projet_conf/server/images");
    $checkbox = '';

    if( true == $img->validUpload() && isset($_POST['lat']) && isset($_POST['lng']) ){

        $id_evnt = Evenement::insertEvent($_POST['titre_evenement'],$_POST['lieu_evenement'],$imgName,$_POST['date_debut'],$_POST['date_fin'],$_POST['heure_debut'],$_POST['heure_fin'],addslashes($_POST['lat']),addslashes($_POST['lng']),$_POST['desc_evnt']);
    }

    if(isset($_POST['checkbox'])){
        $id_organisateur = Organisateur::insertOrganisateur($_POST['soc_orga'],$_POST['nom_orga'],$_POST['prenom_orga'],$_POST['courriel_orga'],$_POST['tel_orga'],$id_evnt);
    }
}

if(isset($_POST['ajout_presentation'])){
    $img = new UploadImages('avatar');
    $imgName = $img->getName();
    $dir = dirname("http://localhost/webprojet/projet_conf/projet_conf/server/images");
    $checkbox='';
    $checkbox2='';

    $id_presentation = Presentation::insertPres($_POST['titre_presentation'],$_POST['desc_presentation'],$_POST['heure_debut'],$_POST['heure_fin'],$_POST['date'],$_POST['select_evenement'],$_POST['select_type_presentation'],$_POST['select_orateur']);

    if((isset($_POST['checkbox2'])) && (isset($_POST['checkbox']))){
        if(true == $img->validUpload()){
            $id_entreprise = Entreprise::insertEntreprise($_POST['nom_entreprise'],$_POST['adresse_entreprise'],$imgName,$_POST['url_entreprise']);

            $id_orateur = Orateur::insertOrateur($_POST['nom_orateur'],$_POST['prenom_orateur'],$_POST['courriel_orateur'],$_POST['tel_orateur'],$id_entreprise);
        }
    }

    if(isset($_POST['checkbox']) && !($_POST['checkbox2'])){
        $id_orateur = Orateur::insertOrateur($_POST['nom_orateur'],$_POST['prenom_orateur'],$_POST['courriel_orateur'],$_POST['tel_orateur'],$_POST['select_entreprise']);
    } 
}