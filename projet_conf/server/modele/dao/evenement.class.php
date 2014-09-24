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
		
		$row = $select->fetch(PDO::FETCH_ASSOC);
		
		$result = new evenement($row['id_evnt'], $row['titre_evnt'], $row['heure_debut'], $row['heure_fin'], $row['date_debut'], $row['date_fin'], $row['logo'], $row['adresse'], $row['latitude'], $row['longitude'],$row['desc_evnt']);
		return $result;
	}
	
		public static function getCurrentEventArray() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_evnt,titre_evnt, heure_debut, heure_fin, date_debut, date_fin, logo, adresse, latitude, longitude, desc_evnt FROM evenement WHERE date_fin >= CURRENT_DATE ORDER BY date_debut" );
		$result = array ();
		
		$result = $select->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}

	public static function getEventArray() {
		$conn = Connection::get ();
		
		$select = $conn->query ("SELECT id_evnt as id,
			titre_evnt as titre, 
			heure_debut as heure_deb, 
			heure_fin as heure_fin, 
			date_debut as date_deb, 
			date_fin as date_fin, 
			logo as logo, 
			adresse as adresse, 
			latitude as latitude, 
			longitude as longitude
			FROM evenement 
			ORDER BY date_debut");

		$result = array ();

		$result = $select->fetch(PDO::FETCH_ASSOC);
		
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
