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

if(isset($_POST['ajout_evenement']))
{
    $titre_evenement='';
    $lieu_evenement='';
    $logo_even='';
    $date_debut='';
    $date_fin='';
    $organisateurs='';
    $soc_orga='';
    $logo_orga='';
    $nom_orga='';
    $prenom_orga='';
    $courriel_orga='';
    $tel_orga='';

    if (isset($_POST['titre_evenement']) && !empty($_POST['titre_evenement'])){     
        $titre_evenement=$_POST['titre_evenement'];
    }
    if (isset($_POST['lieu_evenement']) && !empty($_POST['lieu_evenement'])){
        $lieu_evenement=$_POST['lieu_evenement'];
    }
    if (isset($_POST['logo_even']) && !empty($_POST['logo_even'])){
        $logo_even=$_POST['logo_even'];
    }
    if (isset($_POST['date_debut']) && !empty($_POST['date_debut'])){
        $date_debut=$_POST['date_debut'];
    }
    if (isset($_POST['date_fin']) && !empty($_POST['date_fin'])){
        $date_fin=$_POST['date_fin'];
    }
    if (isset($_POST['organisateurs']) && !empty($_POST['organisateurs'])){
        $organisateurs=$_POST['organisateurs'];
    }
    if ((isset($_POST['titre_evenement']) && empty($_POST['titre_evenement'])) || (isset($_POST['lieu_evenement']) && empty($_POST['lieu_evenement'])) || (isset($_POST['organisateurs']) && empty($_POST['organisateurs'])) || (isset($_POST['logo_even']) && empty($_POST['logo_even'])) || (isset($_POST['date_debut']) && empty($_POST['date_debut'])) || (isset($_POST['date_fin']) && empty($_POST['date_fin']))){
        echo '<br><div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Erreur dans l\'un des champs</strong>
              </div>';
    }
    else {
        $req = $conn->prepare('INSERT INTO article (titre_evenement, lieu_evenement, logo_even, date_debut, date_fin,  organisateurs) VALUES ("'.$titre_evenement.'","'.$lieu_evenement.'","'.$logo_even.'","'.$date_debut.'","'.$date_fin.'","'.$organisateurs.'")');
        $req->execute(array(
        'titre_evenementerence'=>$titre_evenement,
        'lieu_evenement_article'=>$lieu_evenement,
        'logo_even'=>$logo_even,
        'date_debut'=>$date_debut,
        'date_fin'=>$date_fin,
        'organisateurs'=>$organisateurs));
    }
    if(!empty($_POST['oui'])){
        if (isset($_POST['soc_orga']) && !empty($_POST['soc_orga'])){     
            $soc_orga=$_POST['soc_orga'];
        }
        if (isset($_POST['logo_orga']) && !empty($_POST['logo_orga'])){
            $logo_orga=$_POST['logo_orga'];
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
        if ((isset($_POST['soc_orga']) && empty($_POST['soc_orga'])) || (isset($_POST['logo_orga']) && empty($_POST['logo_orga'])) || (isset($_POST['nom_orga']) && empty($_POST['nom_orga'])) || (isset($_POST['prenom_orga']) && empty($_POST['prenom_orga'])) || (isset($_POST['courriel_orga']) && empty($_POST['courriel_orga'])) || (isset($_POST['tel_orga']) && empty($_POST['tel_orga']))){
            echo '<br><div class="alert alert-dismissable alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Erreur dans l\'un des champs</strong>
                  </div>';
        }
        else {
            $req = $conn->prepare('INSERT INTO article (soc_orga, logo_orga, nom_orga, prenom_orga, courriel_orga,  tel_orga) VALUES ("'.$soc_orga.'","'.$logo_orga.'","'.$nom_orga.'","'.$prenom_orga.'","'.$courriel_orga.'","'.$tel_orga.'")');
            $req->execute(array(
            'soc_orga'=>$soc_orga,
            'logo_orga'=>$logo_orga,
            'nom_orga'=>$nom_orga,
            'prenom_orga'=>$prenom_orga,
            'courriel_orga'=>$courriel_orga,
            'tel_orga'=>$tel_orga));
        }
    }
}

