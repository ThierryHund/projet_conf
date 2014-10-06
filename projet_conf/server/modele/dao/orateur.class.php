<?php

require_once "connection.class.php";

class Orateur {
	private $id_orateur;
	private $nom_orateur;
	private $prenom_orateur;
	private $courriel_orateur;
	private $tel_orateur;
	private $id_entp;
	
	public function __construct($id_orateur, $nom_orateur, $prenom_orateur, $courriel_orateur, 
		$tel_orateur, $id_entp) {
		$this->id_orateur = $id_orateur;
		$this->nom_orateur = $nom_orateur;
		$this->prenom_orateur = $prenom_orateur;
		$this->courriel_orateur = $courriel_orateur;
		$this->tel_orateur = $tel_orateur;
		$this->id_entp = $id_entp;
	}
	
	
	// //////////////////////////////
	// retourne les organisateurs
	// JC, fonctionne
	// //////////////////////////////
	public static function getOrateur() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_orateur as id,
								nom_orateur as nom_orateur
								FROM orateur" );
		
		$result = array ();

		$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	////Getters
	
	
}
