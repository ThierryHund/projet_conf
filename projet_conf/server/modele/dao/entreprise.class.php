<?php
require_once "connection.class.php";

class Entreprise {
	private $id_entreprise;
	private $nom;
	private $adresse_entp;
	private $url;
	private $logo;
	public function __construct($id_entreprise, $nom, $adresse_entp, $url, $logo) {
		$this->id_entreprise = $id_entreprise;
		$this->nom = $nom;
		$this->adresse_entp = $adresse_entp;
		$this->url = $url;
		$this->logo = $logo;
	}
	
	// //////////////////////////////
	// Permet de créer une entreprise dans la base
	// //////////////////////////////
	public static function creer($nom, $adresse_entp, $url, $logo) {
		$conn = Connection::get ();
		
		/*
		 * if (self::verifLogin ( $login )) { throw new Exception ( "login existant" ); } else { $login = str_replace ( " ", " ", trim ( $login ) ); } if (! preg_match ( "/^[A-Z][a-z]*[ [a-z]*]*$/", $nom )) { throw new Exception ( "nom incorrect" ); } else { $nom = str_replace ( " ", " ", trim ( $nom ) ); } ; if (! preg_match ( "/^[A-Z][a-z]*[ [a-z]*]*$/", $prenom )) { throw new Exception ( "prenom incorrect" ); } else { $prenom = str_replace ( " ", " ", trim ( $prenom ) ); } ; if (! ctype_alnum ( $login ) || (strlen ( $login ) < 4 || strlen ( $login ) > 16)) { throw new Exception ( "login non conforme" ); } else { $login = str_replace ( " ", " ", trim ( $login ) ); } ; if (! preg_match ( "/^.{8,25}$/", $password )) { throw new Exception ( "Password non conforme" ); } ;
		 */
		
		// requete d'insertion
		$request = $conn->prepare ( "INSERT INTO entreprise (nom, adresse_entp, url, logo) VALUES (:nom , :adresse_entp , :url ,:logo)" );
		$request->execute ( array (
				'nom' => $nom,
				'adresse_entp' => $adresse_entp,
				'url' => $url,
				'logo' => $logo 
		) );
	}
	
	// //////////////////////////////
	// Permet de modifier un entreprise dans la base
	// //////////////////////////////
	public static function modifie($vieux_nom, $nom, $adresse_entp, $url, $logo) {
		$conn = Connection::get ();
		
		// requete d'insertion
		$request = $conn->prepare ( "UPDATE entreprise SET nom = :nom, adresse_entp = :adresse_entp, url = :url , logo = :logo WHERE nom = :vieux_nom" );
		$request->execute ( array (
				'nom' => $nom,
				'adresse_entp' => $adresse_entp,
				'url' => $url,
				'logo' => $logo 
		) );
	}
	
	// //////////////////////////////
	// retourne un tableau d'entreprise
	// //////////////////////////////
	public static function getEntreprise() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_entreprise,nom, url, logo FROM entreprise" );
		$result = array ();
		
		while ( $row = $select->fetch () ) {
			$result [] = $row;
		}
		
		return $result;
	}
	public static function get($id_entreprise) {
		
		// verification a faire
		$conn = Connection::get ();
		$result = null;
		
		// requete sql preparé
		$request = $conn->prepare ( "SELECT id_entreprise, nom, adresse_entp, url, logo FROM entreprise WHERE id_entreprise=:id_entreprise" );
		$request->execute ( array (
				'id_entreprise' => $id_entreprise 
		) );
		
		while ( $row = $request->fetch () ) {
			$result [] = $row;
		}
		
		return new Entreprise ( $result [0] ['id_entreprise'], $result [0] ['nom'], $result [0] ['adresse_entp'], $result [0] ['url'], $result [0] ['logo'] );
		
		// return $result[0][0];
	}

	// //////////////////////////////
	// retourne un tableau d'entreprise
	// JC, fonctionne
	// //////////////////////////////
	public static function getEntreprises() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_entp as id, 
								nom_entp as nom_entp 
								FROM entreprise" );

		$result = array ();
		
		$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	// //////////////////////////////
	// insert une nouvelle entreprise
	// JC, modifié par Max fonctionne
	// //////////////////////////////
	public static function insertEntreprise($nom_entreprise, $adresse_entreprise, $imgName, $url_entreprise) {
		$conn = Connection::get ();

        if ((empty($nom_entreprise)) || (empty($adresse_entreprise)) || (empty($url_entreprise))){
            echo 'Erreur dans l\'un des champs';
        }
        else {
            $req = $conn->prepare('INSERT INTO entreprise (nom_entp, adresse_entp, url_entp, logo_entp) VALUES ("'.$nom_entreprise.'","'.$adresse_entreprise.'","'.$url_entreprise.'","'.$imgName.'")');
            $req->execute(array(
            'nom_entp'=>$nom_entreprise,
            'adresse_entp'=>$adresse_entreprise,
            'url_entp'=>$url_entreprise,
            'logo_entp'=>$imgName));
		}
	}
	
	// //////////////////////////////
	// retourne id
	// //////////////////////////////
	public function getId() {
		return $this->id_entreprise;
	}
	
	// //////////////////////////////
	// retourne nom
	// //////////////////////////////
	public function getNom() {
		return $this->nom;
	}
	
	// //////////////////////////////
	// retourne adresse
	// //////////////////////////////
	public function getAdresseEntp() {
		return $this->adresse_entp;
	}
	
	// //////////////////////////////
	// retourne url
	// //////////////////////////////
	public function getLogin() {
		return $this->url;
	}
	
	// //////////////////////////////
	// retourne mot de passe
	// //////////////////////////////
	public function getLogo() {
		return $this->logo;
	}
}
	