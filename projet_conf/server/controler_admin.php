<?php

require_once "modele/dao/connection.class.php";
require_once "modele/dao/evenement.class.php";
require_once "modele/dao/presentation.class.php";
require_once "modele/dao/organisateur.class.php";

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

if(isset($_POST['ajout_evenement']))
{
    if(!empty($_FILES['logo_even']['tmp_name'])){
        $content_dir = 'img/'; // dossier où sera déplacé le fichier
        $tmp_file = $_FILES['logo_even']['tmp_name'];
        if( !is_uploaded_file($tmp_file) )
        {
            exit("Le fichier est introuvable");
        }
        // on vérifie maintenant l'extension
        $type_file = $_FILES['logo_even']['type'];
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
        {
            exit("Le fichier n'est pas une image");
        }
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['logo_even']['name'];
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir");
        }
         echo $directory=$content_dir.'""'.$name_file;
    }
    $titre_evenement='';
    $lieu_evenement='';
    $date_debut='';
    $date_fin='';
    $organisateurs='';
    $soc_orga='';
    $nom_orga='';
    $prenom_orga='';
    $courriel_orga='';
    $tel_orga='';
    $desc_evnt='';
    $heure_debut='';
    $heure_fin='';
    $latitude='';
    $longitude='';

    if (isset($_POST['titre_evenement']) && !empty($_POST['titre_evenement'])){     
        $titre_evenement=$_POST['titre_evenement'];
    }
    if (isset($_POST['lieu_evenement']) && !empty($_POST['lieu_evenement'])){
        $lieu_evenement=$_POST['lieu_evenement'];
    }
    if (isset($_POST['date_debut']) && !empty($_POST['date_debut'])){
        $date_debut=$_POST['date_debut'];
    }
    if (isset($_POST['date_fin']) && !empty($_POST['date_fin'])){
        $date_fin=$_POST['date_fin'];
    }
    if (isset($_POST['heure_debut']) && !empty($_POST['heure_debut'])){
        $heure_debut=$_POST['heure_debut'];
    }
    if (isset($_POST['heure_fin']) && !empty($_POST['heure_fin'])){
        $heure_fin=$_POST['heure_fin'];
    }
    if (isset($_POST['desc_evnt']) && !empty($_POST['desc_evnt'])){
        $desc_evnt=$_POST['desc_evnt'];
    }
    if ((isset($_POST['titre_evenement']) && empty($_POST['titre_evenement'])) || (isset($_POST['lieu_evenement']) && empty($_POST['lieu_evenement'])) 
        || (isset($_POST['desc_evnt']) && empty($_POST['desc_evnt'])) || (isset($_POST['date_debut']) && empty($_POST['date_debut'])) || (isset($_POST['date_fin']) && empty($_POST['date_fin'])) || (isset($_POST['heure_debut']) && empty($_POST['heure_debut'])) || (isset($_POST['heure_fin']) && empty($_POST['heure_fin']))){
        echo '<br><div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Erreur dans l\'un des champs</strong>
              </div>';
    }
    else {
        $req = $conn->prepare('INSERT INTO evenement (titre_evnt, adresse, logo, date_debut, date_fin, heure_debut, heure_fin, latitude, longitude, desc_evnt) VALUES ("'.$titre_evenement.'","'.$lieu_evenement.'","'.$directory.'","'.$date_debut.'","'.$date_fin.'","'.$heure_debut.'","'.$heure_fin.'",0,0,"'.$desc_evnt.'")');
        $req->execute(array(
        'titre_evnt'=>$titre_evenement,
        'adresse'=>$lieu_evenement,
        'logo'=>$directory,
        'date_debut'=>$date_debut,
        'date_fin'=>$date_fin,
        'heure_debut'=>$heure_debut,
        'heure_fin'=>$heure_fin,
        'latitude'=>"0",
        'longitude'=>"0",
        'desc_evnt'=>$desc_evnt));
    }
    if(!empty($_POST['oui'])){
        if (isset($_POST['soc_orga']) && !empty($_POST['soc_orga'])){     
            $soc_orga=$_POST['soc_orga'];
        }
        if (isset($_POST['nom_orga']) && !empty($_POST['nom_orga'])){
            $nom_orga=$_POST['nom_orga'];
        }
        if (isset($_POST['prenom_orga']) && !empty($_POST['prenom_orga'])){
            $prenom_orga=$_POST['prenom_orga'];
        }
        if (isset($_POST['courriel_orga']) && !empty($_POST['courriel_orga'])){
            $courriel_orga=$_POST['courriel_orga'];
        }
        if (isset($_POST['tel_orga']) && !empty($_POST['tel_orga'])){     
            $tel_orga=$_POST['tel_orga'];
        }
        if ((isset($_POST['soc_orga']) && empty($_POST['soc_orga'])) || (isset($_POST['nom_orga']) && empty($_POST['nom_orga'])) || (isset($_POST['prenom_orga']) && empty($_POST['prenom_orga'])) || (isset($_POST['courriel_orga']) && empty($_POST['courriel_orga'])) || (isset($_POST['tel_orga']) && empty($_POST['tel_orga']))){
            echo '<br><div class="alert alert-dismissable alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Erreur dans l\'un des champs</strong>
                  </div>';
        }
        else {
            $req = $conn->prepare('INSERT INTO organisateur (societe_organisateur, nom_organisateur, prenom_organisateur, courriel_organisateur, tel_organisateur) VALUES ("'.$soc_orga.'","'.$nom_orga.'","'.$prenom_orga.'","'.$courriel_orga.'","'.$tel_orga.'")');
            $req->execute(array(
            'societe_organisateur'=>$soc_orga,
            'nom_organisateur'=>$nom_orga,
            'prenom_organisateur'=>$prenom_orga,
            'courriel_organisateur'=>$courriel_orga,
            'tel_organisateur'=>$tel_orga));
        }
    }

    $chercheID = $conn->query('SELECT id_evnt as id FROM evenement WHERE titre_evnt LIKE "'.$titre_evenement.'"');
    $donnees = $chercheID->fetchAll();
    foreach ($donnees as $ligne){
        $id_evnt=$ligne['id'];
    }

    $chercheID2 = $conn->query('SELECT id_organisateur as id FROM organisateur WHERE societe_organisateur LIKE "'.$soc_orga.'"');
    $donnees = $chercheID2->fetchAll();
    foreach ($donnees as $ligne){
        $id_organisateur=$ligne['id'];
    }

    $req = $conn->prepare('INSERT INTO organise (id_evnt, id_organisateur) VALUES ("'.$id_evnt.'","'.$id_organisateur.'")');
    $req->execute(array(
    'id_evnt'=>$id_evnt,
    'id_organisateur'=>$id_organisateur));

}

if(isset($_REQUEST['getOrganisateur'])){
    $event = Organisateur::getOrganisateur();
    echo json_encode($event);
}
