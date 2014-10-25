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
	// retourne les orateurs
	// JC, fonctionne
	// //////////////////////////////
	public static function getOrateur() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_orateur as id,
								nom_orateur as nom_orateur
								FROM orateur
								ORDER BY id_orateur" );
		
		$result = array ();

		$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	// //////////////////////////////
	// retourne les orateurs de la même entreprise
	// JC, fonctionne
	// //////////////////////////////
	public static function getOrateursArray($id_orateur) {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_orateur as id,
								nom_orateur as nom_orateur,
								prenom_orateur as prenom_orateur
								FROM orateur
								WHERE id_entp=(SELECT id_entp
									FROM orateur
									WHERE id_orateur ='".$id_orateur."')
								ORDER BY id_orateur" );
		
		$result = array ();

		$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	// //////////////////////////////
	// retourne les orateurs d'une présentation
	// JC, fonctionne
	// //////////////////////////////
	public static function getOrateursArrayByPres($id_prez) {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT orateur.id_orateur as id,
								orateur.nom_orateur as nom_orateur,
								orateur.prenom_orateur as prenom_orateur
								FROM presente, orateur
								WHERE presente.id_orateur=orateur.id_orateur
								AND presente.id_presentation='".$id_prez."'
								ORDER BY orateur.id_orateur");
		
		$result = array ();

		$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	

	// //////////////////////////////
	// insert un nouvelle orateur
	// JC, modifié par Max fonctionne
	// //////////////////////////////
	public static function insertOrateurEntpExist($nom_orateur, $prenom_orateur, $courriel_orateur, $tel_orateur, $select_entreprise) {
		$conn = Connection::get ();

        if ((empty($nom_orateur)) || (empty($prenom_orateur)) || (empty($courriel_orateur)) || (empty($tel_orateur)) || (empty($select_entreprise))){
            echo 'INSERT INTO orateur (nom_orateur, prenom_orateur, courriel_orateur, tel_orateur, id_entp) VALUES ("'.$nom_orateur.'","'.$prenom_orateur.'","'.$courriel_orateur.'","'.$tel_orateur.'","'.$select_entreprise.'")';
        }
        else {
            $req = $conn->prepare('INSERT INTO orateur (nom_orateur, prenom_orateur, courriel_orateur, tel_orateur, id_entp) VALUES ("'.$nom_orateur.'","'.$prenom_orateur.'","'.$courriel_orateur.'","'.$tel_orateur.'","'.$select_entreprise.'")');
            $req->execute(array(
            'nom_orateur'=>$nom_orateur,
            'prenom_orateur'=>$prenom_orateur,
            'courriel_orateur'=>$courriel_orateur,
            'tel_orateur'=>$tel_orateur,
            'id_entp'=>$select_entreprise));

        }

	}
	
	// ///////////////////////////////
	// insert la table nouvel orateur à partir de last insert id entreprise 
	// Max, fonctionne
	// //////////////////////////////////////////
	public static function insertOrateurNvEntp($nom_orateur, $prenom_orateur, $courriel_orateur, $tel_orateur) {
		$conn = Connection::get ();

        $entreprise = $conn->query("SELECT max(last_insert_id(id_entp)) as last_entp_inserted FROM entreprise");
		$id_entreprise = $entreprise->fetch();
		
		
		$req = $conn->prepare("INSERT INTO orateur (nom_orateur, prenom_orateur, courriel_orateur, tel_orateur, id_entp) VALUES (:nom_orateur, :prenom_orateur, :courriel_orateur, :tel_orateur, :id_entp)");
            $req->execute(array(
            'nom_orateur'=>$nom_orateur,
            'prenom_orateur'=>$prenom_orateur,
            'courriel_orateur'=>$courriel_orateur,
            'tel_orateur'=>$tel_orateur,
            'id_entp'=>$id_entreprise['last_entp_inserted']
			));
			      
	}
	
}
