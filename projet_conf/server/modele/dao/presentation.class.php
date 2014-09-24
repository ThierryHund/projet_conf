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
	// retourne présentation en cours
	// //////////////////////////////
	public static function getCurrentPres() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_presentation, titre_presentation, description, id_orateur, nom_orateur, prenom_orateur, id_entp, nom_entp, logo_entp 
								FROM presentation, presente, orateur, entreprise 
								WHERE date_presentation = CURRENT_DATE
								AND CURRENT_TIME >= heure_debut_presentation
								AND CURRENT_TIME < heure_fin_presentation
								AND id_presentation.presentation = id_presentation.presente
								AND id_orateur.presente = id_orateur.orateur
								AND id_entp.orateur = id_entp.entreprise"			
								);
		$result = array ();
		
		$row = $select->fetch(PDO::FETCH_ASSOC);
		
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
