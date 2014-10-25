<?php
require_once "connection.class.php";
class evenement {
	private $id_evnt;
	private $titre_evnt;
	private $heure_debut;
	private $heure_fin;
	private $date_debut;
	private $date_fin;
	private $logo;
	private $adresse;
	private $latitude;
	private $longitude;
	private $desc_evnt;
	public function __construct($id_evnt, $titre_evnt, $heure_debut, $heure_fin, $date_debut, $date_fin, $logo, $adresse, $latitude, $longitude, $desc_evnt) {
		$this->id_evnt = $id_evnt;
		$this->titre_evnt = $titre_evnt;
		$this->heure_debut = $heure_debut;
		$this->heure_fin = $heure_fin;
		$this->date_debut = $date_debut;
		$this->date_fin = $date_fin;
		$this->logo = $logo;
		$this->adresse = $adresse;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->desc_evnt = $desc_evnt;
	}
	
	// //////////////////////////////
	// retourne l'evenement en cours
	// //////////////////////////////
	public static function getCurrentEvent() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_evnt,titre_evnt, heure_debut, heure_fin, date_debut, date_fin, logo, adresse, latitude, longitude desc_evnt; FROM evenement WHERE date_fin >= CURRENT_DATE ORDER BY date_debut" );
		$result = array ();
		
		$row = $select->fetch ( PDO::FETCH_ASSOC );
		
		$result = new evenement ( $row ['id_evnt'], $row ['titre_evnt'], $row ['heure_debut'], $row ['heure_fin'], $row ['date_debut'], $row ['date_fin'], $row ['logo'], $row ['adresse'], $row ['latitude'], $row ['longitude'], $row ['desc_evnt'] );
		return $result;
	}
	
	// ///////////////////////////////
	// renvoi l'evnt en cours ou le prochain evt (avec l'organisateur)
	// utilisé par thierry et fonctionnel
	// //////////////////////////////////////////
	public static function getCurrentEventArray() {
		$conn = Connection::get ();
		
		$conn->query ( "SET lc_time_names = 'fr_FR'" );
		$select = $conn->query ( "SELECT evenement.id_evnt,titre_evnt, DATE_FORMAT(heure_debut, '%Hh%i') as heure_debut, DATE_FORMAT(heure_fin, '%Hh%i') as heure_fin, DATE_FORMAT(date_debut, '%W %d %M %Y') as date_debut, DATE_FORMAT(date_fin, '%W %d %M %Y') as date_fin, logo, adresse, latitude, longitude, desc_evnt, societe_organisateur, nom_organisateur, prenom_organisateur, courriel_organisateur, tel_organisateur
									FROM evenement, organise, organisateur 
									WHERE DATE_FORMAT(date_fin, '%Y-%m-%d') >= CURRENT_DATE
									AND evenement.id_evnt = organise.id_evnt
									AND organise.id_organisateur = organisateur.id_organisateur
									ORDER BY DATE_FORMAT(date_debut, '%Y-%m-%d')" );
		$result = array ();
		
		$result = $select->fetch ( PDO::FETCH_ASSOC );
		// var_dump($result);
		return $result;
	}
	
	// ///////////////////////////////
	// renvoi les événements
	// JC, fonctionne
	// //////////////////////////////////////////
	public static function getEventArray() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_evnt as id,
			titre_evnt as titre, 
			DATE_FORMAT(heure_debut, '%Hh%i') as heure_deb, 
			DATE_FORMAT(heure_fin, '%Hh%i') as heure_fin, 
			DATE_FORMAT(date_debut, '%d/%m/%Y') as date_deb, 
			DATE_FORMAT(date_fin, '%d/%m/%Y') as date_fin,
			TIMESTAMP(date_debut, heure_debut) as tmp_deb,
			TIMESTAMP(date_fin, heure_fin) as tmp_fin,
			adresse as adresse,
			desc_evnt as description
			FROM evenement 
			ORDER BY date_debut" );
		
		$result = array ();
		
		$result = $select->fetchAll ( PDO::FETCH_ASSOC );
		
		return $result;
	}

	// ///////////////////////////////
	// renvoi les info en fonction de l'événement
	// JC, fonctionne
	// //////////////////////////////////////////
	public static function getEventArrayById($id_evt) {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_evnt as id,
			titre_evnt as titre, 
			DATE_FORMAT(heure_debut, '%Hh%i') as heure_deb, 
			DATE_FORMAT(heure_fin, '%Hh%i') as heure_fin, 
			DATE_FORMAT(date_debut, '%d/%m/%Y') as date_deb, 
			DATE_FORMAT(date_fin, '%d/%m/%Y') as date_fin,
			adresse as adresse,
			desc_evnt as description
			FROM evenement
			WHERE id_evnt='".$id_evt."'
			ORDER BY date_debut" );
		
		$result = array ();
		
		$result = $select->fetchAll ( PDO::FETCH_ASSOC );
		
		return $result;
	}

	// //////////////////////////////
	// Met à jours un événement
	// JC Fonctionne
	// //////////////////////////////
	public static function updateEvnt($id_evenement,$titre_evenement,$description,$adresse,$date_debut,$date_fin,$heure_debut,$heure_fin,$latitude,$longitude) {
		$conn = Connection::get ();

		//On test si le titre est modifié etc...
	    if (!empty($titre_evenement)) {
	        $maj = $conn->prepare('UPDATE evenement set titre_evnt = "'.$titre_evenement.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'titre_presentation'=>$titre_evenement ));
	    }
	    if (!empty($description)) {
	        $maj = $conn->prepare('UPDATE evenement set desc_evnt = "'.$description.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'description'=>$description ));
	    }
	    if (!empty($adresse)) {
	        $maj = $conn->prepare('UPDATE evenement set adresse = "'.$adresse.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'adresse'=>$adresse ));
	    }
	    if (!empty($date_debut)) {
	        $maj = $conn->prepare('UPDATE evenement set date_debut = "'.$date_debut.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'date_debut'=>$date_debut ));
	    }
	    if (!empty($date_fin)) {
	        $maj = $conn->prepare('UPDATE evenement set date_fin = "'.$date_fin.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'date_fin'=>$date_fin ));
	    }
	    if (!empty($heure_debut)) {
	        $maj = $conn->prepare('UPDATE evenement set heure_debut = "'.$heure_debut.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'heure_debut'=>$heure_debut ));
	    }
	    if (!empty($heure_fin)) {
	        $maj = $conn->prepare('UPDATE evenement set heure_fin = "'.$heure_fin.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'heure_fin'=>$heure_fin ));
	    }
	    if (!empty($latitude)) {
	        $maj = $conn->prepare('UPDATE evenement set latitude = "'.$latitude.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'latitude'=>$latitude ));
	    }
	    if (!empty($longitude)) {
	        $maj = $conn->prepare('UPDATE evenement set longitude = "'.$longitude.'" WHERE id_evnt='.$id_evenement);
	        $maj->execute(array(
	        'longitude'=>$longitude ));
	    }
	}
	
	// ///////////////////////////////
	// Insert un événement
	// JC, modifié par Max fonctionne
	// //////////////////////////////////////////
	public static function insertEvent($titre_evenement, $lieu_evenement, $imgName, $date_debut, $date_fin, $heure_debut, $heure_fin, $latitude, $longitude, $desc_evnt) {
		$conn = Connection::get ();
		
		
			$req = $conn->prepare ( 'INSERT INTO evenement (titre_evnt, adresse, logo, date_debut, date_fin, heure_debut, heure_fin, latitude, longitude, desc_evnt) VALUES ("' . $titre_evenement . '","' . $lieu_evenement . '","' . $imgName . '","' . $date_debut . '","' . $date_fin . '","' . $heure_debut . '","' . $heure_fin . '","' . $latitude . '","' . $longitude . '","' . $desc_evnt . '")' );
			$req->execute ( array (
					'titre_evnt' => $titre_evenement,
					'adresse' => $lieu_evenement,
					'logo' => $imgName,
					'date_debut' => $date_debut,
					'date_fin' => $date_fin,
					'heure_debut' => $heure_debut,
					'heure_fin' => $heure_fin,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'desc_evnt' => $desc_evnt 
			) );
	
		
	}
	
	// ///////////////////////////////
	// insert la table organise à partir de last insert id de evenement et organisateur
	// Max, fonctionne
	// //////////////////////////////////////////
	public static function insertOrganiseNvOrganisateur() {
		$conn = Connection::get ();

        $evenement = $conn->query("SELECT max(last_insert_id(id_evnt)) as last_evnt_inserted FROM evenement");
		$id_evenement = $evenement->fetch();
		
		$organisateur = $conn->query("SELECT max(last_insert_id(id_organisateur)) as last_organisateur_inserted FROM organisateur");
		$id_organisateur = $organisateur->fetch();
		
		$req = $conn->prepare ( "INSERT INTO organise (id_evnt, id_organisateur) VALUES (:id_evenement, :id_organisateur)" );	
		$req->execute ( array ('id_evenement' => $id_evenement['last_evnt_inserted'], 
								'id_organisateur' => $id_organisateur['last_organisateur_inserted']
								) );
       
	}
	
	// ///////////////////////////////
	// insert la table organise à partir de last insert id de evenement et id organisateur passé en paramètre
	// Max, fonctionne
	// //////////////////////////////////////////
	public static function insertOrganiseOrganisateurExist($select_organisateur) {
		$conn = Connection::get ();

        $evenement = $conn->query("SELECT max(last_insert_id(id_evenement)) as last_evnt_inserted FROM presentation");
		$id_evenement = $evenement->fetch();
		
		
		$req = $conn->prepare ( "INSERT INTO presente (id_evnt, id_organisateur) VALUES (:id_evenement, :select_organisateur)" );	
		$req->execute ( array ('id_evenement' => $id_evenement['last_evnt_inserted'], 
								'select_organisateur' => $select_organisateur
								) );
       
	}


	// ///////////////////////////////
	// supprime un événement et les présentations associées
	// Michel, fonctionne
	// //////////////////////////////////////////

	public static function supprEvent($id_evnt) {
		$conn = Connection::get ();

		  $sql = " 	DELETE evenement, presentation, organise
					FROM evenement 
					LEFT JOIN presentation ON evenement.id_evnt = presentation.id_evnt 
					LEFT JOIN organise ON evenement.id_evnt = organise.id_evnt 
					WHERE evenement.id_evnt = ".$id_evnt;

		$result = $conn->exec($sql);
		return $result;
	}

	
	
	// //////////////////////////////
	// retourne id
	// //////////////////////////////
	public function getIdEvnt() {
		return $this->id_evnt;
	}
	
	// //////////////////////////////
	// retourne titre
	// //////////////////////////////
	public function getTitreEvnt() {
		return $this->titre_evnt;
	}
	
	// //////////////////////////////
	// retourne date_debut
	// //////////////////////////////
	public function getDateDebut() {
		return $this->date_debut;
	}
	
	// //////////////////////////////
	// retourne date_fin
	// //////////////////////////////
	public function getDateFin() {
		return $this->date_fin;
	}
	
	// //////////////////////////////
	// retourne heure_debut
	// //////////////////////////////
	public function getHeureDebut() {
		return $this->heure_debut;
	}
	
	// //////////////////////////////
	// retourne heure_fin
	// //////////////////////////////
	public function getHeureFIn() {
		return $this->heure_fin;
	}
	
	// //////////////////////////////
	// retourne logo
	// //////////////////////////////
	public function getLogo() {
		return $this->logo;
	}
	
	// //////////////////////////////
	// retourne adresse
	// //////////////////////////////
	public function getAdresse() {
		return $this->adresse;
	}
	
	// //////////////////////////////
	// retourne latitude
	// //////////////////////////////
	public function getLatitude() {
		return $this->latitude;
	}
	
	// //////////////////////////////
	// retourne longitude
	// //////////////////////////////
	public function getLongitude() {
		return $this->longitude;
	}
	
	// //////////////////////////////
	// retourne longitude
	// //////////////////////////////
	public function getDescEvnt() {
		return $this->desc_evnt;
	}
}
