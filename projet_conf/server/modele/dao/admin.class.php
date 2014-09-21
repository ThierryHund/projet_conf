
<?php
require_once "connection.class.php";
class admin {
	private $id_admin;
	private $nom_admin;
	private $prenom_admin;
	private $identifiant_admin;
	private $mdp_admin;
	private $premiere_connex;
	public function __construct($id_admin, $nom_admin, $prenom_admin, $identifiant_admin, $mdp_admin, $premiere_connex) {
		$this->id_admin = $id_admin;
		$this->nom_admin = $nom_admin;
		$this->prenom_admin = $prenom_admin;
		$this->identifiant_admin = $identifiant_admin;
		$this->mdp_admin = $mdp_admin;
		$this->premiere_connex = $premiere_connex;
	}
	
	// //////////////////////////////
	// verifie si login existe deja
	// //////////////////////////////
	public static function verifLogin($identifiant_admin) {
		$conn = Connection::get ();
		$existe = false;
		
		$select = $conn->query ( "SELECT id_admin FROM admin" );
		$result = array ();
		
		while ( $row = $select->fetch () ) {
			$result [] = $row;
		}
		foreach ( $result as $param ) {
			if ($param [0] == $identifiant_admin)
				$existe = true;
		}
		
		return $existe;
	}
	
	// //////////////////////////////
	// Permet de créer un usager dans la base
	// //////////////////////////////
	public static function creer($nom, $prenom, $login, $password) {
		$conn = Connection::get ();
		
		if (self::verifLogin ( $login )) {
			throw new Exception ( "login existant" );
		} else {
			$login = str_replace ( "  ", " ", trim ( $login ) );
		}
		
		$nom = strtolower ( str_replace ( "  ", " ", trim ( $nom ) ) );
		
		$prenom = strtolower ( str_replace ( "  ", " ", trim ( $prenom ) ) );
		
		if (! preg_match ( "/^.{8,25}$/", $password )) {
			throw new Exception ( "Password non conforme" );
		}
		;
		
		// if($groupe!=("caisse" || "comptable" || "secours" || "administrateur")) { throw new Exception("groupe incorrect"); }
		
		// requete d'insertion
		$request = $conn->prepare ( "INSERT INTO admin (nom_admin, prenom_admin, identifiant_admin, mdp_admin, prem_connex) VALUES (:nom , :prenom , :login , :password ,:prem_connex" );
		$request->execute ( array (
				'nom' => $nom,
				'prenom' => $prenom,
				'login' => $login,
				'password' => crypt ( $password ),
				'prem_connex' => 1,
		) );
	}
	
	// //////////////////////////////
	// Permet de modifier un usager dans la base
	// //////////////////////////////
	public static function modifie($nom, $prenom, $login, $vieux_login, $password) {
		$conn = Connection::get ();
		
		if ($login != $vieux_login) {
			if (self::verifLogin ( $login )) {
				
				throw new Exception ( "login existant" );
			}
		}
		

			$nom = str_replace ( " ", " ", trim ( $nom ) );
				;

			$nom = str_replace ( " ", " ", trim ( $nom ) );


			$login = str_replace ( " ", " ", trim ( $login ) );

		if ($password == "") {
			$request = $conn->prepare ( "UPDATE admin SET nom_admin = :nom, prenom_admin = :prenom, identifiant_admin = :login WHERE login = :vieux_login" );
			$request->execute ( array (
					'nom' => $nom,
					'prenom' => $prenom,
					'login' => $login,
					'vieux_login' => $vieux_login,
			) );
		} else {
			;
			
	
			// requete d'insertion
			$request = $conn->prepare ( "UPDATE utilisateur SET nom_admin = :nom, prenom_admin = :prenom, identifiant_admin = :login , mdp_admin = :mdp WHERE identifiant_admin = :vieux_login" );
			$request->execute ( array (
					'nom' => $nom,
					'prenom' => $prenom,
					'login' => $login,
					'vieux_login' => $vieux_login,
					'mdp' => crypt ( $password ),
			) );
		}
	}
	
	// //////////////////////////////
	// retourne un tableau d'usager
	// //////////////////////////////
	public static function getAdmin() {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT id_admin,identifiant_admin, mdp_admin, nom_admin, prenom_admin FROM admin" );
		$result = array ();
		
		while ( $row = $select->fetch () ) {
			$result [] = $row;
		}
		
		return $result;
	}
	
	
	
	// //////////////////////////////
	// retourne un admin
	// //////////////////////////////
	public static function get($login) {
		
		// verification a faire
		$conn = Connection::get ();
		$result = null;
		
		// requete sql preparé
		$request = $conn->prepare ( "SELECT id_admin, identifiant_admin, mdp_admin, nom_admin, prenom_admin, premiere_connex FROM admin WHERE login=:login" );
		$request->execute ( array (
				'login' => $login 
		) );
		
		while ( $row = $request->fetch () ) {
			$result [] = $row;
		}
		return new Admin ( $result [0] ['id_admin'], $result [0] ['nom_admin'], $result [0] ['prenom_admin'], $result [0] ['identifiant_admin'], $result [0] ['mdpadmin'] ,$result [0] ['premiere_connex']);
		
		// return $result[0][0];
	}
	// //////////////////////////////
	// retourne id
	// //////////////////////////////
	public function getIdAdmin() {
		return $this->id_admin;
	}
	
	// //////////////////////////////
	// retourne nom
	// //////////////////////////////
	public function getNomAdmin() {
		return $this->nom_admin;
	}
	
	// //////////////////////////////
	// retourne prenom
	// //////////////////////////////
	public function getPrenomAdmin() {
		return $this->prenom_admin;
	}
	
	// //////////////////////////////
	// retourne login
	// //////////////////////////////
	public function getIdentifiantAdmin() {
		return $this->identifiant_admin;
	}
	
	// //////////////////////////////
	// retourne mot de passe
	// //////////////////////////////
	public function getMdpAdmin() {
		return $this->mdp_admin;
	}
	

}
