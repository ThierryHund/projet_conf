<?php

require_once "connection.class.php";

class presentation	 {
	private $id_presentation;
	private $titre_presentation;
	private $description;
	private $heure_debut_presentation;
	private $heure_fin_presentation;
	private $date_presentation;
	private $id_orateur;
	private $nom_orateur;
	private $prenom_orateur;
	private $courriel_orateur;
	private $tel_orateur;
	private $id_entp;
	private $nom_entp;
	private $adresse_entp;
	private $url_entp;
	private $logo_entp;
	
	public function __construct($id_presentation, $titre_presentation, $description, $heure_debut_presentation, $heure_fin_presentation, $date_presentation, $id_orateur, $nom_orateur, $prenom_orateur, $courriel_orateur, $tel_orateur, $id_entp, $nom_entp, $adresse_entp, $url_entp, $logo_entp) {
		$this->id_presentation = $id_presentation;
		$this->titre_presentation = $titre_presentation;
		$this->description = $description;
		$this->heure_debut_presentation = $heure_debut_presentation;
		$this->heure_fin_presentation = $heure_fin_presentation;
		$this->date_presentation = $date_presentation;
		$this->id_orateur = $id_orateur;
		$this->nom_orateur = $nom_orateur;
		$this->prenom_orateur = $prenom_orateur;
		$this->courriel_orateur = $courriel_orateur;
		$this->tel_orateur = $tel_orateur;
		$this->id_entp = $id_entp;
		$this->nom_entp = $nom_entp;
		$this->adresse_entp = $adresse_entp;
		$this->url_entp = $url_entp;
		$this->logo_entp = $logo_entp;
	}
	
	
	// //////////////////////////////
	// retourne présentation pour tel evenement
	// //////////////////////////////
	public static function getPresentation() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation, description, 
										orateur.id_orateur, nom_orateur, prenom_orateur, entreprise.id_entp, nom_entp, logo_entp, url_entp
								FROM presentation, presente, orateur, entreprise, evenement, est_compose
								WHERE presentation.id_presentation = presente.id_presentation
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								AND evenement.id_evnt = est_compose.id_evnt
								AND est_compose.id_presentation = presentation.id_presentation
								AND evenement.heure_fin >= heure_fin_presentation
								"			
								);
		$result = array ();
		
		$result = $select->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	
	// //////////////////////////////
	// retourne liste des prez d'un evnt avec timestamp
	//utilisé par thierry pour planning event
	//en cours
	////////////////////////////////
	public static function getPrezByEvent($id_evnt) {
		$conn = Connection::get ();
	
		$request = $conn->prepare ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation, description,
										orateur.id_orateur, nom_orateur, prenom_orateur, entreprise.id_entp, nom_entp, logo_entp, url_entp
								FROM presentation, presente, orateur, entreprise, evenement, est_compose
								WHERE evenement.id_evnt = :id_evnt
								AND presentation.id_presentation = presente.id_presentation
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								AND evenement.id_evnt = est_compose.id_evnt
								AND est_compose.id_presentation = presentation.id_presentation
								AND evenement.heure_fin >= heure_fin_presentation
								");
		$request->execute ( array (
				'id_evnt' => $id_evnt
		) );
		
		$array =array();
		
		while ( $row = $request->fetch (PDO::FETCH_ASSOC) ) {
			$array[] = $row;
		}
		
		$result = array ();

		for($i =  0; $i < count($array); $i++){
			$result[]['id_presentation'] ='';
			$result[]['titre_presentation'] ='';
			$result[]['heure_debut_presentation'] = '';
			$result[]['heure_fin_presentation'] = '';
			$result[]['date_presentation'] = '';
			$result[]['description'] = '';
			$result[]['id_orateur'] = '';
			$result[]['nom_orateur'] = '';
			$result[]['prenom_orateur'] = '';
			$result[]['id_entp'] = '';
			$result[]['nom_entp'] = '';
			$result[]['logo_entp'] = '';
			$result[]['url_entp'] == '';
			
			
			if( ($array[i]['id_presentation'] != $array[i+1]['id_presentation']))
			{
				
				array_splice($array, $i,1);
			}
		};
	
		return $result;

	}
	
	
	
	
	
	// //////////////////////////////
	// retourne présentation en cours
	// //////////////////////////////
	public static function getCurrentPres() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation, description, orateur.id_orateur, nom_orateur, prenom_orateur, entreprise.id_entp, entreprise.nom_entp, entreprise.logo_entp 
								FROM presentation, presente, orateur, entreprise 
								WHERE date_presentation = CURRENT_DATE
								AND CURRENT_TIME >= heure_debut_presentation
								AND CURRENT_TIME < heure_fin_presentation
								AND presentation.id_presentation = presente.id_presentation
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp"			
								);
		$result = array ();
		
		$row = $select->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	// //////////////////////////////
	// retourne présentation en cours
	// //////////////////////////////

	// //////////////////////////////
	// retourne présentations
	//JC Fonctionne
	// //////////////////////////////
	public static function getPresArray() {
		$conn = Connection::get ();
		
		$select = $conn->query ("SELECT presentation.id_presentation as id,
			presentation.titre_presentation as titre, 
			presentation.description as description, 
			orateur.id_orateur, 
			orateur.nom_orateur as nom_orateur, 
			orateur.prenom_orateur as prenom_orateur, 
			entreprise.id_entp, 
			entreprise.nom_entp as nom_entreprise, 
			entreprise.logo_entp as logo_entreprise
			FROM presentation, presente, orateur, entreprise 
			WHERE presentation.id_presentation = presente.id_presentation
			AND presente.id_orateur = orateur.id_orateur
			AND orateur.id_entp = entreprise.id_entp");

		$result = array ();

		$result = $select->fetch(PDO::FETCH_ASSOC);
		

		
		return $result;
	}
	
	// //////////////////////////////
	// retourne prochaine présentation
	// //////////////////////////////
	public static function getNextPres() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation, description, orateur.id_orateur, nom_orateur, prenom_orateur, entreprise.id_entp, nom_entp, logo_entp 
								FROM presentation, presente, orateur, entreprise 
								WHERE date_presentation >= CURRENT_DATE
								AND heure_debut_presentation > CURRENT_TIME							
								AND presentation.id_presentation = presente.id_presentation
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								ORDER BY heure_debut_presentation"			
								);
		$result = array ();
		
		$row = $select->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	
	// //////////////////////////////
	// retourne toutes les présentations de la journée
	// //////////////////////////////
	public static function getAujPres() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation, description, 
										orateur.id_orateur, nom_orateur, prenom_orateur, entreprise.id_entp, nom_entp, logo_entp, url_entp
								FROM presentation, presente, orateur, entreprise 
								WHERE presentation.id_presentation = presente.id_presentation
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								ORDER BY heure_debut_presentation"			
								);
		$result = array ();
		
		$result = $select->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	////Getters
	
	// //////////////////////////////
	// retourne id_presentation
	// //////////////////////////////
	public function getIdEvnt() {
		return $this->id_presentation;
	}
	
	// //////////////////////////////
	// retourne titre_presentation
	// //////////////////////////////
	public function getTitrePres() {
		return $this->titre_presentation;
	}

	// //////////////////////////////
	// retourne description
	// //////////////////////////////
	public function getDescriptionPres() {
		return $this->description;
	}

	// //////////////////////////////
	// retourne heure_debut_presentation
	// //////////////////////////////
	public function getHeureDebPres() {
		return $this->heure_debut_presentation;
	}
	
	// //////////////////////////////
	// retourne heure_fin_presentation
	// //////////////////////////////
	public function getHeureFinPres() {
		return $this->heure_fin_presentation;
	}
	
	// //////////////////////////////
	// retourne date_presentation
	// //////////////////////////////
	public function getDatePres() {
		return $this->date_presentation;
	}
	
	// //////////////////////////////
	// retourne id_orateur
	// //////////////////////////////
	public function getIdOrateur() {
		return $this->id_orateur;
	}
	
	// //////////////////////////////
	// retourne nom_orateur
	// //////////////////////////////
	public function getNomOrateur() {
		return $this->nom_orateur;
	}
	
	// //////////////////////////////
	// retourne prenom_orateur
	// //////////////////////////////
	public function getPrenomOrateur() {
		return $this->prenom_orateur;
	}
	
	// //////////////////////////////
	// retourne courriel_orateur
	// //////////////////////////////
	public function getCourrielOrateur() {
		return $this->courriel_orateur;
	}
		
	// //////////////////////////////
	// retourne tel_orateur
	// //////////////////////////////
	public function getTelOrateur() {
		return $this->tel_orateur;
	}
	
	// //////////////////////////////
	// retourne id_entp
	// //////////////////////////////
	public function getIdEntp() {
		return $this->id_entp;
	}
	
	// //////////////////////////////
	// retourne nom_entp
	// //////////////////////////////
	public function getNomEntp() {
		return $this->nom_entp;
	}
	
	// //////////////////////////////
	// retourne adresse_entp
	// //////////////////////////////
	public function getAdresseEntp() {
		return $this->adresse_entp;
	}
	
	// //////////////////////////////
	// retourne url_entp
	// //////////////////////////////
	public function getUrlEntp() {
		return $this->url_entp;
	}
	
	// //////////////////////////////
	// retourne logo_entp
	// //////////////////////////////
	public function getLogoEntp() {
		return $this->logo_entp;
	}
}
