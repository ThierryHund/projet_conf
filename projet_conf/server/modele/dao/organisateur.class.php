<?php

require_once "connection.class.php";

class Organisateur {
	private $id_organisateur;
	private $societe_organisateur;
	private $nom_organisateur;
	private $prenom_organisateur;
	private $courriel_organisateur;
	private $tel_organisateur;
	
	public function __construct($id_organisateur, $societe_organisateur, $nom_organisateur, $prenom_organisateur, 
		$courriel_organisateur, $tel_organisateur) {
		$this->id_organisateur = $id_organisateur;
		$this->societe_organisateur = $societe_organisateur;
		$this->nom_organisateur = $nom_organisateur;
		$this->prenom_organisateur = $prenom_organisateur;
		$this->courriel_organisateur = $courriel_organisateur;
		$this->tel_organisateur = $tel_organisateur;
	}
	
	
	// //////////////////////////////
	// retourne les organisateurs
	// //////////////////////////////
	public static function getOrganisateur() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_organisateur as id,
								societe_organisateur as soc_orga,
								nom_organisateur as nom_orga,
								prenom_organisateur as prenom_orga,
								courriel_organisateur as courriel_orga,
								tel_organisateur as tel_orga
								FROM organisateur" );
		$result = array ();
		
		$result = $select->fetch(PDO::FETCH_ASSOC);
		
		foreach ($donnees as $ligne) {
	        return echo '<option value="'.$ligne['id'].'">'.$ligne['soc_orga'].'</option>';
	    }
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	////Getters
	
	// //////////////////////////////
	// retourne id_organisateur
	// //////////////////////////////
	public function getIdOrga() {
		return $this->id_organisateur;
	}

	// //////////////////////////////
	// retourne societe_organisateur
	// //////////////////////////////
	public function getSocOrga() {
		return $this->societe_organisateur;
	}
	
	// //////////////////////////////
	// retourne nom_organisateur
	// //////////////////////////////
	public function getNomOrga() {
		return $this->nom_organisateur;
	}

	// //////////////////////////////
	// retourne prenom_organisateur
	// //////////////////////////////
	public function getPrenomOrga() {
		return $this->prenom_organisateur;
	}
	
	// //////////////////////////////
	// retourne courriel_organisateur
	// //////////////////////////////
	public function getCourrOrga() {
		return $this->courriel_organisateur;
	}
	
	// //////////////////////////////
	// retourne tel_organisateur
	// //////////////////////////////
	public function getTelOrga() {
		return $this->tel_organisateur;
	}
}
