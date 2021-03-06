<?php
require_once "connection.class.php";

class Type_presentation {
	private $id_type;
	private $nom_type;
	
	
	public function __construct($id_type, $nom_type) {
		$this->id_type = $id_type;
		$this->nom_type = $nom_type;
		
	}
	
	// //////////////////////////////
	// Créer un type de présentation
	// //////////////////////////////
	public static function creer($nom_type) {
		$conn = Connection::get ();
		
		// requete d'insertion
		$request = $conn->prepare ( "INSERT INTO type_presentation (nom_type) VALUES (:nom_type)" );
		$request->execute ( array (
				'nom_type' => $nom_type,
				
		) );
	}
	
	// //////////////////////////////
	// Permet de modifier un type de présentation
	// //////////////////////////////
	public static function modifie($vieux_nom_type, $nom_type) {
		$conn = Connection::get ();
		
		// requete de modification
		$request = $conn->prepare ( "UPDATE type_presentation SET nom_type = :nom_type WHERE nom_type = :vieux_nom_type" );
		$request->execute ( array (
				'nom_type' => $nom_type,
				
		) );
	}
	
	// //////////////////////////////
	// Permet de supprimer un type de présentation
	// //////////////////////////////
	public static function supprime($nom_type) {
		$conn = Connection::get ();
		
		// requete de suppression
		$request = $conn->prepare ( "DELETE FROM type_presentation WHERE nom_type = :nom_type" );
		$request->execute ( array (
				'nom_type' => $nom_type,
				
		) );
	}
	
	// Retourne un tableau des types de présentation
	public static function getTypePresentation()
  {

    $conn = Connection::get();
    $request = $conn->query ("SELECT id_type, nom_type 
									FROM type_presentation" 
									);
	
	
    $result = array ();
		
		while ( $row = $request->fetch () ) {
			$result [] = $row;
		}
		
		
	return $result;

  }
	
	// Retourne un tableau des types de présentation
  	// JC, fonctionne
	public static function getType()
  {

    $conn = Connection::get();
    $select = $conn->query ("SELECT id_type as id, 
    						nom_type as nom_type
							FROM type_presentation");
	
    $result = array ();

	$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
	return $result;

  }
  
  // suppression d'une categ
  public static function supprimerCategorie($id) {
  	$conn = Connection::get ();
  
  	$request = $conn->prepare( "DELETE type_presentation
								FROM type_presentation
								WHERE id_type = :id" );
  
  	$request->execute ( array (
  			'id' => $id
  	) );
  
  	return $result;
  }
  
  //categorie et nb prez par categorie
  public static function getNbType()
  {
  
  	$conn = Connection::get();
  	$select = $conn->query ("SELECT type_presentation.id_type as id, type_presentation.nom_type as type, count(presentation.id_presentation) as nb from type_presentation LEFT JOIN presentation on type_presentation.id_type = presentation.id_type GROUP BY type_presentation.id_type ORDER BY type_presentation.nom_type");
  
  	$result = array ();
  
  	$result = $select->fetchAll(PDO::FETCH_ASSOC);
  
  	return $result;
  }
  
	
	
	// //////////////////////////////
	// Retourne id_type
	// //////////////////////////////
	public function getIdType() {
		return $this->id_type;
	}
	
	// //////////////////////////////
	// Retourne nom_type
	// //////////////////////////////
	public function getNomType() {
		return $this->nom_type;
	}
	
}
	