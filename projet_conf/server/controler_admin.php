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

if(isset($_POST['ajout_evenement'])){
    $img = new UploadImages('avatar');
    $imgName = $img->getName();
    $dir = dirname("http://localhost/webprojet/projet_conf/projet_conf/server/images");

    if(true == $img->validUpload()){    


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
        $checkbox='';

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
            echo 'Erreur dans l\'un des champs';
        }
        else {
            $req = $conn->prepare('INSERT INTO evenement (titre_evnt, adresse, logo, date_debut, date_fin, heure_debut, heure_fin, latitude, longitude, desc_evnt) VALUES ("'.$titre_evenement.'","'.$lieu_evenement.'","'.$dir.'/images/'.$imgName.'","'.$date_debut.'","'.$date_fin.'","'.$heure_debut.'","'.$heure_fin.'",0,0,"'.$desc_evnt.'")');
            $req->execute(array(
            'titre_evnt'=>$titre_evenement,
            'adresse'=>$lieu_evenement,
            'logo'=>$imgName,
            'date_debut'=>$date_debut,
            'date_fin'=>$date_fin,
            'heure_debut'=>$heure_debut,
            'heure_fin'=>$heure_fin,
            'latitude'=>"0",
            'longitude'=>"0",
            'desc_evnt'=>$desc_evnt));

            $chercheID = $conn->query('SELECT id_evnt as id FROM evenement WHERE titre_evnt LIKE "'.$titre_evenement.'"');
            $donnees = $chercheID->fetchAll();
            foreach ($donnees as $ligne){
                $id_evnt=$ligne['id'];
            }    
        
            echo'<p style=color:green;font-weight:bold;> Evénement ajouté avec succès </p> <br/>';
        }
    }
    if(isset($_POST['checkbox'])){
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

            $chercheID2 = $conn->query('SELECT id_organisateur as id FROM organisateur WHERE societe_organisateur LIKE "'.$soc_orga.'"');
            $donnees = $chercheID2->fetchAll();
            foreach ($donnees as $ligne){
                $id_organisateur=$ligne['id'];
            }

            $req = $conn->prepare('INSERT INTO organise (id_evnt, id_organisateur) VALUES ("'.$id_evnt.'","'.$id_organisateur.'")');
            $req->execute(array(
            'id_evnt'=>$id_evnt,
            'id_organisateur'=>$id_organisateur));

            echo'<p style=color:green;font-weight:bold;> Organisateur ajouté avec succès </p> <br/>';
        }
    }
}

if(isset($_POST['ajout_presentation'])){
    $img = new UploadImages('avatar');
    $imgName = $img->getName();
    $dir = dirname("http://localhost/webprojet/projet_conf/projet_conf/server/images");

    if(true == $img->validUpload()){ 
        $select_evenement='';
        $titre_presentation='';
        $select_type_presentation='';
        $desc_presentation='';
        $select_orateur='';
        $nom_orateur='';
        $prenom_orateur='';
        $courriel_orateur='';
        $tel_orateur='';
        $select_entreprise='';
        $nom_entreprise='';
        $adresse_entreprise='';
        $url_entreprise='';
        $checkbox='';
        $checkbox2='';

        if (isset($_POST['select_evenement']) && !empty($_POST['select_evenement'])){     
            $select_evenement=$_POST['select_evenement'];
        }
        if (isset($_POST['titre_presentation']) && !empty($_POST['titre_presentation'])){
            $titre_presentation=$_POST['titre_presentation'];
        }
        if (isset($_POST['select_type_presentation']) && !empty($_POST['select_type_presentation'])){
            $select_type_presentation=$_POST['select_type_presentation'];
        }
        if (isset($_POST['desc_presentation']) && !empty($_POST['desc_presentation'])){
            $desc_presentation=$_POST['desc_presentation'];
        }
        if (isset($_POST['select_orateur']) && !empty($_POST['select_orateur'])){
            $select_orateur=$_POST['select_orateur'];
        }
        if ((isset($_POST['select_evenement']) && empty($_POST['select_evenement'])) || (isset($_POST['titre_presentation']) && empty($_POST['titre_presentation'])) || (isset($_POST['desc_presentation']) && empty($_POST['desc_presentation'])) || (isset($_POST['select_type_presentation']) && empty($_POST['select_type_presentation'])) || (isset($_POST['select_orateur']) && empty($_POST['select_orateur']))){
            echo 'Erreur dans l\'un des champs';
        }
        else {
            $req = $conn->prepare('INSERT INTO presentation(id_evnt, titre_presentation, id_type, description) VALUES ("'.$select_evenement.'","'.$titre_presentation.'","'.$select_type_presentation.'","'.$desc_presentation.'")');
            $req->execute(array(
            'id_evnt'=>$select_evenement,
            'titre_presentation'=>$titre_presentation,
            'id_type'=>$select_type_presentation,
            'description'=>$desc_presentation));

            $chercheID = $conn->query('SELECT id_presentation as id FROM presentation WHERE titre_presentation LIKE "'.$titre_presentation.'"');
            $donnees = $chercheID->fetchAll();
            foreach ($donnees as $ligne){
                $id_presentation=$ligne['id'];
            }

            $req = $conn->prepare('INSERT INTO presente (id_presentation,id_orateur) VALUES ("'.$id_presentation.'","'.$select_orateur.'")');
            $req->execute(array(
            'id_presentation'=>$id_presentation,
            'id_orateur'=>$select_orateur));

            echo'<p style=color:green;font-weight:bold;> Présentation ajouté avec succès </p> <br/>';
        }

        if(($_POST['checkbox2']) && ($_POST['checkbox'])){
            if (isset($_POST['nom_entreprise']) && !empty($_POST['nom_entreprise'])){     
                $nom_entreprise=$_POST['nom_entreprise'];
            }
            if (isset($_POST['adresse_entreprise']) && !empty($_POST['adresse_entreprise'])){
                $adresse_entreprise=$_POST['adresse_entreprise'];
            }
            if (isset($_POST['url_entreprise']) && !empty($_POST['url_entreprise'])){
                $url_entreprise=$_POST['url_entreprise'];
            }
            if (isset($_POST['courriel_orga']) && !empty($_POST['courriel_orga'])){
                $courriel_orga=$_POST['courriel_orga'];
            }
            if (isset($_POST['tel_orga']) && !empty($_POST['tel_orga'])){     
                $tel_orga=$_POST['tel_orga'];
            }
            if (isset($_POST['nom_orateur']) && !empty($_POST['nom_orateur'])){
                $nom_orateur=$_POST['nom_orateur'];
            }
            if (isset($_POST['prenom_orateur']) && !empty($_POST['prenom_orateur'])){
                $prenom_orateur=$_POST['prenom_orateur'];
            }
            if (isset($_POST['courriel_orateur']) && !empty($_POST['courriel_orateur'])){
                $courriel_orateur=$_POST['courriel_orateur'];
            }
            if (isset($_POST['tel_orateur']) && !empty($_POST['tel_orateur'])){     
                $tel_orateur=$_POST['tel_orateur'];
            }
            if (isset($_POST['select_entreprise']) && !empty($_POST['select_entreprise'])){
                $select_entreprise=$_POST['select_entreprise'];
            }
            if ((isset($_POST['nom_entreprise']) && empty($_POST['nom_entreprise'])) || (isset($_POST['adresse_entreprise']) && empty($_POST['adresse_entreprise'])) || (isset($_POST['url_entreprise']) && empty($_POST['url_entreprise'])) || (isset($_POST['nom_orateur']) && empty($_POST['nom_orateur'])) || (isset($_POST['prenom_orateur']) && empty($_POST['prenom_orateur'])) || (isset($_POST['courriel_orateur']) && empty($_POST['courriel_orateur'])) || (isset($_POST['tel_orateur']) && empty($_POST['tel_orateur'])) || (isset($_POST['select_entreprise']) && empty($_POST['select_entreprise']))){
                echo 'Erreur dans l\'un des champs';
            }
            else {
                $req = $conn->prepare('INSERT INTO entreprise (nom_entp, adresse_entp, url_entp, logo_entp) VALUES ("'.$nom_entreprise.'","'.$adresse_entreprise.'","'.$url_entreprise.'","'.$dir.'/images/'.$imgName.'")');
                $req->execute(array(
                'nom_entp'=>$nom_entreprise,
                'adresse_entp'=>$adresse_entreprise,
                'url_entp'=>$url_entreprise,
                'logo_entp'=>$imgName));

                $chercheID2 = $conn->query('SELECT id_entp as id FROM entreprise WHERE nom_entp LIKE "'.$nom_entreprise.'"');
                $donnees = $chercheID2->fetchAll();
                foreach ($donnees as $ligne){
                    $id_entreprise=$ligne['id'];
                }

                $req = $conn->prepare('INSERT INTO orateur (nom_orateur, prenom_orateur, courriel_orateur, tel_orateur, id_entp) VALUES ("'.$nom_orateur.'","'.$prenom_orateur.'","'.$courriel_orateur.'","'.$tel_orateur.'","'.$id_entreprise.'")');
                $req->execute(array(
                'nom_orateur'=>$nom_orateur,
                'prenom_orateur'=>$prenom_orateur,
                'courriel_orateur'=>$courriel_orateur,
                'tel_orateur'=>$tel_orateur,
                'id_entp'=>$id_entreprise));

                echo'<p style=color:green;font-weight:bold;> Entreprise et orateur ajouté avec succès </p> <br/>';
            }
        }

        if($_POST['checkbox']){
            if (isset($_POST['nom_orateur']) && !empty($_POST['nom_orateur'])){
                $nom_orateur=$_POST['nom_orateur'];
            }
            if (isset($_POST['prenom_orateur']) && !empty($_POST['prenom_orateur'])){
                $prenom_orateur=$_POST['prenom_orateur'];
            }
            if (isset($_POST['courriel_orateur']) && !empty($_POST['courriel_orateur'])){
                $courriel_orateur=$_POST['courriel_orateur'];
            }
            if (isset($_POST['tel_orateur']) && !empty($_POST['tel_orateur'])){     
                $tel_orateur=$_POST['tel_orateur'];
            }
            if (isset($_POST['select_entreprise']) && !empty($_POST['select_entreprise'])){
                $select_entreprise=$_POST['select_entreprise'];
            }
            if ((isset($_POST['nom_orateur']) && empty($_POST['nom_orateur'])) || (isset($_POST['prenom_orateur']) && empty($_POST['prenom_orateur'])) || (isset($_POST['courriel_orateur']) && empty($_POST['courriel_orateur'])) || (isset($_POST['tel_orateur']) && empty($_POST['tel_orateur'])) || (isset($_POST['select_entreprise']) && empty($_POST['select_entreprise']))){
                echo 'Erreur dans l\'un des champs';
            }
            else {
                $req = $conn->prepare('INSERT INTO orateur (nom_orateur, prenom_orateur, courriel_orateur, tel_orateur, id_entp) VALUES ("'.$nom_orateur.'","'.$prenom_orateur.'","'.$courriel_orateur.'","'.$tel_orateur.'","'.$select_entreprise.'")');
                $req->execute(array(
                'nom_orateur'=>$nom_orateur,
                'prenom_orateur'=>$prenom_orateur,
                'courriel_orateur'=>$courriel_orateur,
                'tel_orateur'=>$tel_orateur,
                'id_entp'=>$select_entreprise));

                echo'<p style=color:green;font-weight:bold;> Orateur ajouté avec succès </p> <br/>';
            }
        } 
    } 
}