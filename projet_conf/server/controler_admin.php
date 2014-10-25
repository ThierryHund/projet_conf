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

session_start ();

if(isset($_REQUEST['deconnexion'])){
    session_unset();
	session_destroy();

}

$conn = Connection::get ();

//Vérification identifiant et mdp avec BdD. si oui accueil admin et ouverture session
if ((! empty ( $_POST ['login'] ) && ! empty ( $_POST ['password'] )) or isset ( $_SESSION ['connecte'] )) {

	if (! empty ( $_POST ['login'] ) && ! empty ( $_POST ['password'] )) {

	
			$listeAdmin = Admin::getAdmin();
            $data = array();
			
			foreach ( $listeAdmin as $value ) {
			
				if ($value ['identifiant_admin'] == $_POST ['login'] && crypt ( $_POST ['password'], $value ['mdp_admin']) == $value ['mdp_admin']) {
					
					header("Cache-Control: private");
					$_SESSION ['admin'] = Admin::get ( $value ['identifiant_admin'] );
					$_SESSION ['connecte'] = true;
				
					$data[0] = 'yes';
					$data[1] = $_SESSION ['connecte'];
					break;
					
				} else {
					$data[0] = 'no';
				}
				
			}
			
		echo json_encode($data);
	}
	// Sinon, on est déja connecté et toutes les fonctions sont activées
	else{
	
		//accueil admin (liste evt)
		if(isset($_REQUEST['consulter_evenement'])){
		$event = Evenement::getEventArray();
		$event[] = $_SESSION ['connecte'];
		echo json_encode($event);
		}

		// supprime l'événement dans la BdD
		if(isset($_GET['id_event'])){    
		$idEvenement  = $_GET["id_event"];
		Evenement::supprEvent($idEvenement); 
		}


		if(isset($_REQUEST['getNbType'])){
			$type = type_presentation::getNbType();
			echo json_encode($type);
		}

		if(isset($_REQUEST['supprimer_categorie'])){
			type_presentation::supprimerCategorie($_REQUEST['id_categ']);
			$type = type_presentation::getNbType();
			echo json_encode($type);
		}

		if(isset($_REQUEST['ajout_categorie'])){
			type_presentation::creer($_REQUEST['nom_type']);
			$type = type_presentation::getNbType();
			echo json_encode($type);
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

				$id_evnt = Evenement::insertEvent($_POST['titre_evenement'],$_POST['lieu_evenement'],$dir.'/images/'.$imgName,$_POST['date_debut'],$_POST['date_fin'],$_POST['heure_debut'],$_POST['heure_fin'],addslashes($_POST['lat']),addslashes($_POST['lng']),$_POST['desc_evnt'],$_POST['organisateurs']);
			}

			if(isset($_POST['checkbox'])){
				$id_organisateur = Organisateur::insertOrganisateur($_POST['soc_orga'],$_POST['nom_orga'],$_POST['prenom_orga'],$_POST['courriel_orga'],$_POST['tel_orga'],$id_evnt);
			}
			
		}

		if(isset($_POST['ajout_presentation'])){
			$img = new UploadImages('avatar');
			$imgName = $img->getName();
			$dir = dirname("/images");
			$checkbox='';
			$checkbox2='';
			 
			
				$id_presentation = Presentation::insertPres($_POST['titre_presentation'],$_POST['desc_presentation'],$_POST['heure_debut'],$_POST['heure_fin'],$_POST['date'],$_POST['id_evt'],$_POST['select_type_presentation']);
				Presentation::insertPresenteOratExist($_POST['select_orateur']);
			
			if((isset($_POST['checkbox_orateur'])) && ( !isset($_POST['checkbox_entp']))){
				$id_orateur = Orateur::insertOrateurEntpExist($_POST['nom_orateur'],$_POST['prenom_orateur'],$_POST['courriel_orateur'],$_POST['tel_orateur'],$_POST['select_entreprise']);
				Presentation::insertPresenteNvOrateur();
			} 
			
			else if((isset($_POST['checkbox_orateur'])) && (isset($_POST['checkbox_entp']))){
				if(true == $img->validUpload()){
					$id_entreprise = Entreprise::insertEntreprise($_POST['nom_entreprise'], $_POST['adresse_entreprise'], $dir.'/images/'.$imgName, $_POST['url_entreprise']);
					$id_orateur = Orateur::insertOrateurNvEntp($_POST['nom_orateur'], $_POST['prenom_orateur'], $_POST['courriel_orateur'], $_POST['tel_orateur']);
					Presentation::insertPresenteNvOrateur();
				}
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
			Evenement::updateEvnt($_POST['id_evenement'],$_POST['titre_evenement'],$_POST['description'],$_POST['adresse'],$_POST['date_debut'],$_POST['date_fin'],$_POST['heure_debut'],$_POST['heure_fin'],$_POST['lat'],$_POST['lng']);
		}

	}
}

?>