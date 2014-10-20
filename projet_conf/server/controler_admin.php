<?php

header('Content-type: text/html; charset=UTF-8'); 

require_once "modele/dao/connection.class.php";
require_once "modele/dao/admin.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/entreprise.class.php";
require_once "modele/dao/presentation.class.php";
require_once "modele/dao/organisateur.class.php";
require_once "modele/dao/type_presentation.class.php";
require_once "modele/dao/orateur.class.php";
require_once "uploadImages.class.php";

$conn = Connection::get ();

//session_start ();
//header("Cache-Control: private");

/*
//if(isset($_POST['connexion'])){
	if(isset($_POST['login']) && isset($_POST['password'])){
		$login=$_POST['login'];
		$password=$_POST['password'];

			
		$verif_login = $conn->query('SELECT *
            FROM admin
            WHERE admin.identifiant_admin LIKE "'.$login.'"
            AND admin.mdp_admin LIKE "'.$password.'"');

            $liste = $verif_login->fetchAll();
            if (count($liste) == 0) { 
            	header('location:http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/connexion.html');
            }
            else header('location:http://localhost/webprojet/projet_conf/projet_conf/app_cordova/www/accueil.html');
	}
//}

*/

if ((! empty ( $_POST ['login'] ) && ! empty ( $_POST ['password'] )) or isset ( $_SESSION ['connecte'] )) {

	if (! empty ( $_POST ['login'] ) && ! empty ( $_POST ['password'] )) {

	
			$listeAdmin = Admin::getAdmin();
            
			foreach ( $listeAdmin as $value ) {
			//var_dump ($value['identifiant_admin']);
			//var_dump($_POST ['login']);
			
				$data = array();
				
				if ($value ['identifiant_admin'] == $_POST ['login'] && crypt ( $_POST ['password'], $value ['mdp_admin']) == $value ['mdp_admin']) {
					session_start ();
					$_SESSION ['admin'] = Admin::get ( $value ['identifiant_admin'] );
					//var_dump($_SESSION ['admin']);	
					//echo "yes";
					//$_SESSION ['connecte'] = true;
					
					$ok = true;
						$data[] = 'yes';
						//echo json_encode($data);
									
				} else {
					$ok = false;
					$data[] = 'no';
					//echo json_encode($data);
				}
				
				if($ok){
					
					//var_dump ($data);
					echo json_encode($data);
				}
			}
		
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
    $pres = Presentation::getPresArray($_REQUEST['id_evenement']);
    echo json_encode($pres);
}

if(isset($_REQUEST['getEntreprise'])){
    $entp = Entreprise::getEntreprises();
    echo json_encode($entp);
}

//Renvoi les infos de la présentation en fonction de l'id de la présentation
if(isset($_REQUEST['id'])){
    $prez = Presentation::getPresArrayByPresId($_REQUEST['id']);
    echo json_encode($prez);
}

//Renvoi la liste des orateurs de la présentation de la même entreprise que l'orateur existant pour la présentation.
if(isset($_REQUEST['id_orateur'])){
    $orateurs = Orateur::getOrateursArray($_REQUEST['id_orateur']);
    echo json_encode($orateurs);
}

// supprime l'événement dans la BdD
if(isset($_GET['id_event'])){    
    $idEvenement  = $_GET["id_event"];
    Evenement::supprEvent($idEvenement); 
}

// supprime une presentation dans la BdD
if(isset($_GET['id_prez'])){
    $idPres  = $_GET["id_prez"];
    Presentation::supprPres($idPres); 
}

if(isset($_POST['ajout_evenement'])){
    $img = new UploadImages('avatar');
    $imgName = $img->getName();
    $dir = dirname("http://localhost/webprojet/projet_conf/projet_conf/server/images");
    $checkbox = '';

    if( true == $img->validUpload() && isset($_POST['lat']) && isset($_POST['lng']) ){

        $id_evnt = Evenement::insertEvent($_POST['titre_evenement'],$_POST['lieu_evenement'],$dir.'/images/'.$imgName,$_POST['date_debut'],$_POST['date_fin'],$_POST['heure_debut'],$_POST['heure_fin'],addslashes($_POST['lat']),addslashes($_POST['lng']),$_POST['desc_evnt']);
    }

    if(isset($_POST['checkbox'])){
        $id_organisateur = Organisateur::insertOrganisateur($_POST['soc_orga'],$_POST['nom_orga'],$_POST['prenom_orga'],$_POST['courriel_orga'],$_POST['tel_orga'],$id_evnt);
    }
	//echo json_encode($_POST);
}

if(isset($_POST['ajout_presentation'])){
    $img = new UploadImages('avatar');
    $imgName = $img->getName();
    $dir = dirname("http://localhost/webprojet/projet_conf/projet_conf/server/images");
    $checkbox='';
    $checkbox2='';
    $id_presentation = Presentation::insertPres($_POST['titre_presentation'],$_POST['desc_presentation'],$_POST['heure_debut'],$_POST['heure_fin'],$_POST['date'],$_POST['id_evt'],$_POST['select_type_presentation'],$_POST['select_orateur']);

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

//Envoi les nouvelles infos pour la presentation et la met à jours.
if(isset($_POST['modifier_presentation'])){
    Presentation::updatePres($_POST['id_presentation'],$_POST['titre_presentation'],$_POST['description'],$_POST['date'],$_POST['heure_debut'],$_POST['heure_fin'],$_POST['orateurs'],$_POST['type_event']);
}

//Renvoi la liste des orateurs en fonction de la présentation
if(isset($_REQUEST['id_presentation'])){
    $orateur = Orateur::getOrateursArrayByPres($_REQUEST['id_presentation']);
    echo json_encode($orateur);
}

if(isset($_REQUEST['id_evt'])){
    $evt = Evenement::getEventArrayById($_REQUEST['id_evt']);
    echo json_encode($evt);
}

//Envoi les nouvelles infos pour l'événement et le met à jours.
if(isset($_POST['modifier_evenement'])){
    echo $_POST['lat'];
    echo $_POST['lng'];
    Evenement::updateEvnt($_POST['id_evenement'],$_POST['titre_evenement'],$_POST['description'],$_POST['adresse'],$_POST['date_debut'],$_POST['date_fin'],$_POST['heure_debut'],$_POST['heure_fin'],$_POST['lat'],$_POST['lng']);
}

?>