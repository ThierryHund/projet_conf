<?php
require_once "connection.class.php";
class presentation {
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
	// retourne présentation
	// Max et modif par thierry, fonctionne
	// //////////////////////////////
	public static function getPresentation($id) {
		$conn = Connection::get ();
		$result = array ();
		
		// on recupere les données sql avec un timestamp
		$request = $conn->prepare ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation,TIMESTAMP(date_presentation,heure_debut_presentation) as timestamp_debut, TIMESTAMP(date_presentation,heure_fin_presentation) as timestamp_fin, description, nom_type, orateur.id_orateur, nom_orateur, prenom_orateur, tel_orateur, courriel_orateur, nom_entp, adresse_entp, url_entp, logo_entp
								FROM presentation, evenement, type_presentation, presente, orateur, entreprise
								WHERE presentation.id_presentation = :id
								AND presentation.id_presentation = presente.id_presentation
								AND evenement.id_evnt = presentation.id_evnt
								AND presentation.id_type = type_presentation.id_type
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								ORDER BY timestamp_debut, id_presentation

								
								
								" );
		$request->execute ( array (
				'id' => $id 
		) );
		
		$liste_prez = array ();
		$liste_final = array ();
		
		while ( $row = $request->fetch ( PDO::FETCH_ASSOC ) ) {
			$liste_prez [] = $row;
		}
		
		// on trie les données pour obtenir un tableau ou les auteurs sont regroupés dans une seule case
		$j = - 1;
		for($i = 0; $i < count ( $liste_prez ); $i ++) {
			if (($i != 0) && ($liste_prez [$i] ['titre_presentation'] == $liste_prez [$i - 1] ['titre_presentation'])) {
				$temp = array (
						"id" => $liste_prez [$i] ['id_orateur'],
						"prenom" => $liste_prez [$i] ['prenom_orateur'],
						"nom" => $liste_prez [$i] ['nom_orateur'],
						"courriel" => $liste_prez [$i] ['courriel_orateur'],
						"tel" => $liste_prez [$i] ['tel_orateur'],
						"nom_entp" => $liste_prez [$i] ['nom_entp'],
						"adresse_entp" => $liste_prez [$i] ['adresse_entp'],
						"url_entp" => $liste_prez [$i] ['url_entp'],
						"logo_entp" => $liste_prez [$i] ['logo_entp'] 
				);
				
				$liste_final [$j] ['auteurs'] [] = $temp;
			} else {
				$j ++;
				$liste_final [$j] ['id_presentation'] = $liste_prez [$i] ['id_presentation'];
				$liste_final [$j] ['titre_presentation'] = $liste_prez [$i] ['titre_presentation'];
				$liste_final [$j] ['heure_debut_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_debut_presentation'] ) );
				$liste_final [$j] ['heure_fin_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_fin_presentation'] ) );
				$liste_final [$j] ['date_presentation'] = date ( 'd/m/Y', strtotime ( $liste_prez [$i] ['date_presentation'] ) );
				$liste_final [$j] ['timestamp_debut'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_debut'] ) );
				$liste_final [$j] ['timestamp_fin'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_fin'] ) );
				$liste_final [$j] ['description'] = $liste_prez [$i] ['description'];
				$liste_final [$j] ['type_presentation'] = $liste_prez [$i] ['nom_type'];
				
				$temp = array (
						"id" => $liste_prez [$i] ['id_orateur'],
						"prenom" => $liste_prez [$i] ['prenom_orateur'],
						"nom" => $liste_prez [$i] ['nom_orateur'],
						"courriel" => $liste_prez [$i] ['courriel_orateur'],
						"tel" => $liste_prez [$i] ['tel_orateur'],
						"nom_entp" => $liste_prez [$i] ['nom_entp'],
						"adresse_entp" => $liste_prez [$i] ['adresse_entp'],
						"url_entp" => $liste_prez [$i] ['url_entp'],
						"logo_entp" => $liste_prez [$i] ['logo_entp'] 
				);
				
				$liste_final [$j] ['auteurs'] [] = $temp;
			}
			;
		}
		return $liste_final;
	}
	
	// ///////////////////////////////
	// retourne liste des prez d'un evnt avec timestamp et info auteur entp regroupé dans un tableau
	// utilisé par thierry pour planning event
	// //////////////////////////////
	public static function getPrezByEvent($id_evnt) {
		$conn = Connection::get ();
		$result = array ();
		
		// on recupere les données sql avec un timestamp
		$request = $conn->prepare ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation,TIMESTAMP(date_presentation,heure_debut_presentation) as timestamp_debut, TIMESTAMP(date_presentation,heure_fin_presentation) as timestamp_fin, description, nom_type, orateur.id_orateur, nom_orateur, prenom_orateur, tel_orateur, courriel_orateur, nom_entp, adresse_entp, url_entp, logo_entp
								FROM presentation, evenement, type_presentation, presente, orateur, entreprise
								WHERE evenement.id_evnt = :id_evnt
								AND presentation.id_presentation = presente.id_presentation
								AND evenement.id_evnt = presentation.id_evnt
								AND presentation.id_type = type_presentation.id_type
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								ORDER BY timestamp_debut, id_presentation

								
								
								" );
		$request->execute ( array (
				'id_evnt' => $id_evnt 
		) );
		
		$liste_prez = array ();
		$liste_final = array ();
		
		while ( $row = $request->fetch ( PDO::FETCH_ASSOC ) ) {
			$liste_prez [] = $row;
		}
		
		// on trie les données pour obtenir un tableau ou les auteurs sont regroupés dans une seule case
		$j = - 1;
		for($i = 0; $i < count ( $liste_prez ); $i ++) {
			if (($i != 0) && ($liste_prez [$i] ['titre_presentation'] == $liste_prez [$i - 1] ['titre_presentation'])) {
				$temp = array (
						"id" => $liste_prez [$i] ['id_orateur'],
						"prenom" => $liste_prez [$i] ['prenom_orateur'],
						"nom" => $liste_prez [$i] ['nom_orateur'],
						"courriel" => $liste_prez [$i] ['courriel_orateur'],
						"tel" => $liste_prez [$i] ['tel_orateur'],
						"nom_entp" => $liste_prez [$i] ['nom_entp'],
						"adresse_entp" => $liste_prez [$i] ['adresse_entp'],
						"url_entp" => $liste_prez [$i] ['url_entp'],
						"logo_entp" => $liste_prez [$i] ['logo_entp'] 
				);
				
				$liste_final [$j] ['auteurs'] [] = $temp;
			} else {
				$j ++;
				$liste_final [$j] ['id_presentation'] = $liste_prez [$i] ['id_presentation'];
				$liste_final [$j] ['titre_presentation'] = $liste_prez [$i] ['titre_presentation'];
				$liste_final [$j] ['heure_debut_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_debut_presentation'] ) );
				$liste_final [$j] ['heure_fin_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_fin_presentation'] ) );
				$liste_final [$j] ['date_presentation'] = date ( 'd-m-Y', strtotime ( $liste_prez [$i] ['date_presentation'] ) );
				$liste_final [$j] ['timestamp_debut'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_debut'] ) );
				$liste_final [$j] ['timestamp_fin'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_fin'] ) );
				$liste_final [$j] ['description'] = $liste_prez [$i] ['description'];
				$liste_final [$j] ['type_presentation'] = $liste_prez [$i] ['nom_type'];
				
				$temp = array (
						"id" => $liste_prez [$i] ['id_orateur'],
						"prenom" => $liste_prez [$i] ['prenom_orateur'],
						"nom" => $liste_prez [$i] ['nom_orateur'],
						"courriel" => $liste_prez [$i] ['courriel_orateur'],
						"tel" => $liste_prez [$i] ['tel_orateur'],
						"nom_entp" => $liste_prez [$i] ['nom_entp'],
						"adresse_entp" => $liste_prez [$i] ['adresse_entp'],
						"url_entp" => $liste_prez [$i] ['url_entp'],
						"logo_entp" => $liste_prez [$i] ['logo_entp'] 
				);
				
				$liste_final [$j] ['auteurs'] [] = $temp;
			}
			;
		}
		;
		
		// $result ['liste_prez'] = $liste_final;
		
		// on tri les presentation par jour
		$liste_trie = array ();
		for($i = 0; $i < count ( $liste_final ); $i ++) {
			$liste_trie [$liste_final [$i] ['date_presentation']] [] = $liste_final [$i];
		}
		
		$result ['liste_prez'] = $liste_trie;
		
		// on récupère les présentation en cours
		$current_prez = array ();
		$current_date = date ( 'Y-m-d H:i:s', time () );
		foreach ( $liste_final as $prez ) {
			if ($prez ['timestamp_debut'] <= $current_date && $prez ['timestamp_fin'] > $current_date) {
				$current_prez [] = $prez;
			}
		}
		
		$result ['prez_en_cours'] = $current_prez;
		
		// on récupère la ou les prochaines presentations
		$next_prez = array ();
		$trouve = false;
		$temp;
		for($i = 0; $i < count ( $liste_final ); $i ++) {
			if ($liste_final [$i] ['timestamp_debut'] > $current_date && $trouve == false) {
				$next_prez [] = $liste_final [$i];
				$trouve = true;
				$temp = $liste_final [$i] ['timestamp_debut'];
			} elseif ($liste_final [$i] ['timestamp_debut'] == $temp) {
				$next_prez [] = $liste_final [$i];
			}
		}
		
		$result ['prez_suivante'] = $next_prez;
		return $result;
	}
	
	// ///////////////////////////////
	// retourne tableau triés des id de présentations de tel événement
	// //////////////////////////////
	public static function getPrezsOrdered($id_evnt) {
		$conn = Connection::get ();
		$result = array ();
		
		// on recupere les données sql avec un timestamp
		$request = $conn->prepare ( "SELECT presentation.id_presentation, titre_presentation, heure_debut_presentation, heure_fin_presentation, date_presentation,TIMESTAMP(date_presentation,heure_debut_presentation) as timestamp_debut, TIMESTAMP(date_presentation,heure_fin_presentation) as timestamp_fin
								FROM presentation, evenement
								WHERE evenement.id_evnt = :id_evnt								
								AND evenement.id_evnt = presentation.id_evnt						
								ORDER BY timestamp_debut, id_presentation
								" );
		$request->execute ( array (
				'id_evnt' => $id_evnt 
		) );
		
		$liste_prez = array ();
		$liste_final = array ();
		
		while ( $row = $request->fetch ( PDO::FETCH_ASSOC ) ) {
			$liste_prez [] = $row;
		}
		
		// on trie les données pour obtenir un tableau ou les auteurs sont regroupés dans une seule case
		$j = - 1;
		for($i = 0; $i < count ( $liste_prez ); $i ++) {
			
				$j ++;
				$liste_final [$j] ['id_presentation'] = $liste_prez [$i] ['id_presentation'];
				$liste_final [$j] ['titre_presentation'] = $liste_prez [$i] ['titre_presentation'];
				$liste_final [$j] ['heure_debut_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_debut_presentation'] ) );
				$liste_final [$j] ['heure_fin_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_fin_presentation'] ) );
				$liste_final [$j] ['date_presentation'] = date ( 'd-m-Y', strtotime ( $liste_prez [$i] ['date_presentation'] ) );
				$liste_final [$j] ['timestamp_debut'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_debut'] ) );
				$liste_final [$j] ['timestamp_fin'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_fin'] ) );
								
		};		
		return $liste_final;
	}
	
	
	
	// //////////////////////////////
	// retourne présentations
	// JC Fonctionne
	// //////////////////////////////
	public static function getPresArray($id_event) {
		$conn = Connection::get ();
		
		$request = $conn->prepare ( "SELECT presentation.id_presentation as id,
			presentation.titre_presentation as titre, 
			presentation.description as description, 
			orateur.id_orateur, 
			orateur.nom_orateur as nom_orateur, 
			orateur.prenom_orateur as prenom_orateur, 
			entreprise.id_entp, 
			entreprise.nom_entp as nom_entreprise, 
			entreprise.logo_entp as logo_entreprise,
			TIMESTAMP(date_presentation,heure_debut_presentation) as timestamp_debut
			FROM evenement, presentation, presente, orateur, entreprise 
			WHERE presentation.id_presentation = presente.id_presentation
			AND presente.id_orateur = orateur.id_orateur
			AND orateur.id_entp = entreprise.id_entp
			AND evenement.id_evnt = presentation.id_evnt
			AND evenement.id_evnt = :id_evnt
			ORDER BY timestamp_debut, presentation.id_presentation" );
			
					$request->execute ( array (
				'id_evnt' => $id_event 
		) );
			
			//////////////////////
		
		$liste_prez = array ();
		$liste_final = array ();
		
		while ( $row = $request->fetch ( PDO::FETCH_ASSOC ) ) {
			$liste_prez [] = $row;
		}
		
		// on trie les données pour obtenir un tableau ou les auteurs sont regroupés dans une seule case
		// -->>>>> les champs en commentaires ont été laissé au cas où l'on souhaite plus d'info sur page consulter presentation admin
		$j = - 1;
		for($i = 0; $i < count ( $liste_prez ); $i ++) {
			if (($i != 0) && ($liste_prez [$i] ['titre'] == $liste_prez [$i - 1] ['titre'])) {
				$temp = array (
						"id_orateur" => $liste_prez [$i] ['id_orateur'],
						"prenom_orateur" => $liste_prez [$i] ['prenom_orateur'],
						"nom_orateur" => $liste_prez [$i] ['nom_orateur'],
						//"courriel_orateur" => $liste_prez [$i] ['courriel_orateur'],
						//"tel_orateur" => $liste_prez [$i] ['tel_orateur'],
						"nom_entreprise" => $liste_prez [$i] ['nom_entreprise'],
						//"adresse_entreprise" => $liste_prez [$i] ['adresse_entreprise'],
						//"url_entreprise" => $liste_prez [$i] ['url_entreprise'],
						"logo_entreprise" => $liste_prez [$i] ['logo_entreprise'] 
				);
				
				$liste_final [$j] ['auteurs'] [] = $temp;
			} else {
				$j ++;
				$liste_final [$j] ['id'] = $liste_prez [$i] ['id'];
				$liste_final [$j] ['titre'] = $liste_prez [$i] ['titre'];
			//	$liste_final [$j] ['heure_debut_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_debut_presentation'] ) );
			//	$liste_final [$j] ['heure_fin_presentation'] = date ( 'H\hi', strtotime ( $liste_prez [$i] ['heure_fin_presentation'] ) );
			//	$liste_final [$j] ['date_presentation'] = date ( 'd-m-Y', strtotime ( $liste_prez [$i] ['date_presentation'] ) );
				$liste_final [$j] ['timestamp_debut'] = date ( 'Y-m-d H:i:s', strtotime ( $liste_prez [$i] ['timestamp_debut'] ) );
				$liste_final [$j] ['description'] = $liste_prez [$i] ['description'];
			//	$liste_final [$j] ['type_presentation'] = $liste_prez [$i] ['nom_type'];
				
				$temp = array (
						"id_orateur" => $liste_prez [$i] ['id_orateur'],
						"prenom_orateur" => $liste_prez [$i] ['prenom_orateur'],
						"nom_orateur" => $liste_prez [$i] ['nom_orateur'],
						//"courriel_orateur" => $liste_prez [$i] ['courriel_orateur'],
						//"tel_orateur" => $liste_prez [$i] ['tel_orateur'],
						"nom_entreprise" => $liste_prez [$i] ['nom_entreprise'],
						//"adresse_entreprise" => $liste_prez [$i] ['adresse_entreprise'],
						//"url_entreprise" => $liste_prez [$i] ['url_entreprise'],
						"logo_entreprise" => $liste_prez [$i] ['logo_entreprise'] 
				);
				
				$liste_final [$j] ['auteurs'] [] = $temp;
			}
			;
		}
			
		return $liste_final;
	}
	
	// //////////////////////////////
	// retourne les présentations
	// JC Fonctionne
	// //////////////////////////////
	public static function getPresArrayByPresId($id) {
		$conn = Connection::get ();
		
		$select = $conn->query ( "SELECT presentation.id_presentation as id, 
								titre_presentation as titre_presentation, 
								DATE_FORMAT(heure_debut_presentation, '%Hh%i') as heure_debut, 
								DATE_FORMAT(heure_fin_presentation, '%Hh%i') as heure_fin, 
								DATE_FORMAT(date_presentation, GET_FORMAT(DATE, 'EUR')) as date_presentation, 
								description as description,
								orateur.id_orateur as id_orateur, 
								orateur.nom_orateur as nom_orateur, 
								orateur.prenom_orateur as prenom_orateur, 
								type_presentation.nom_type as type
								FROM presentation, evenement, type_presentation, presente, orateur, entreprise
								WHERE presentation.id_presentation = '".$id."'
								AND presentation.id_presentation = presente.id_presentation
								AND evenement.id_evnt = presentation.id_evnt
								AND presentation.id_type = type_presentation.id_type
								AND presente.id_orateur = orateur.id_orateur
								AND orateur.id_entp = entreprise.id_entp
								GROUP BY presentation.id_presentation" );
		
		$result = array ();
		
		$result = $select->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	// //////////////////////////////
	// Met à jours une présentation
	// JC Fonctionne
	// //////////////////////////////
	public static function updatePres($id_pres,$titre,$description,$date,$heure_debut,$heure_fin,$id_orateur,$type_event) {
		$conn = Connection::get ();

		//On test si le titre est modifié etc...
	    if (!empty($titre)) {
	        $maj = $conn->prepare('UPDATE presentation set titre_presentation = "'.$titre.'" WHERE id_presentation='.$id_pres);
	        $maj->execute(array(
	        'titre_presentation'=>$titre ));
	    }
	    if (!empty($description)) {
	        $maj = $conn->prepare('UPDATE presentation set description = "'.$description.'" WHERE id_presentation='.$id_pres);
	        $maj->execute(array(
	        'description'=>$description ));
	    }
	    if (!empty($date)) {
	        $maj = $conn->prepare('UPDATE presentation set date_presentation = "'.$date.'" WHERE id_presentation='.$id_pres);
	        $maj->execute(array(
	        'date_presentation'=>$date ));
	    }
	    if (!empty($heure_debut)) {
	        $maj = $conn->prepare('UPDATE presentation set heure_debut_presentation = "'.$heure_debut.'" WHERE id_presentation='.$id_pres);
	        $maj->execute(array(
	        'heure_debut_presentation'=>$heure_debut ));
	    }
	    if (!empty($heure_fin)) {
	        $maj = $conn->prepare('UPDATE presentation set heure_fin_presentation = "'.$heure_fin.'" WHERE id_presentation='.$id_pres);
	        $maj->execute(array(
	        'heure_fin_presentation'=>$heure_fin ));
	    }
	    if (!empty($type_event)) {
	        $maj = $conn->prepare('UPDATE presentation set id_type = "'.$type_event.'" WHERE id_presentation='.$id_pres);
	        $maj->execute(array(
	        'id_type'=>$type_event ));
	    }
	    if (!empty($id_orateur)) {
	    	$sql = 'DELETE FROM presente WHERE id_presentation = '.$id_pres;
		    $stmt = $conn->prepare($sql);
		    $stmt->bindParam('id_presentation', $id_pres);
		    $stmt->execute();

	    	foreach($id_orateur as $orateur){
	    		$req = $conn->prepare ( 'INSERT INTO presente(id_presentation,id_orateur) VALUES ("' . $id_pres . '","' . $orateur . '")' );
				$req->execute ( array (
						'id_presentation' => $id_pres,
						'id_orateur' => $orateur
				) );
	    	}
	    }
	}
	
	// //////////////////////////////
	// insert une nouvelle présentation
	// JC, modifié par Max fonctionne
	// //////////////////////////////
	public static function insertPres($titre_presentation, $desc_presentation, $heure_debut, $heure_fin, $date, $select_evenement, $select_type_presentation) {
		$conn = Connection::get ();
		
			$req = $conn->prepare ( 'INSERT INTO presentation(titre_presentation, description, heure_debut_presentation, heure_fin_presentation, date_presentation, id_evnt, id_type) VALUES ("' . $titre_presentation . '","' . $desc_presentation . '", "' . $heure_debut . '", "' . $heure_fin . '", "' . $date . '","' . $select_evenement . '","' . $select_type_presentation . '")' );
			$req->execute ( array (
					'titre_presentation' => $titre_presentation,
					'description' => $desc_presentation,
					'heure_debut_presentation' => $heure_debut,
					'heure_fin_presentation' => $heure_fin,
					'date_presentation' => $date,
					'id_evnt' => $select_evenement,
					'id_type' => $select_type_presentation 
			) );			
		
	}
	
	// ///////////////////////////////
	// insert la table presente à partir de last insert id de presentation et orateur
	// Max, fonctionne
	// //////////////////////////////////////////
	public static function insertPresenteNvOrateur() {
		$conn = Connection::get ();

        $presentation = $conn->query("SELECT max(last_insert_id(id_presentation)) as last_pres_inserted FROM presentation");
		$id_presentation = $presentation->fetch();
		
		$orateur = $conn->query("SELECT max(last_insert_id(id_orateur)) as last_orateur_inserted FROM orateur");
		$id_orateur = $orateur->fetch();
		
		$req = $conn->prepare ( "INSERT INTO presente (id_presentation, id_orateur) VALUES (:id_presentation, :id_orateur)" );	
		$req->execute ( array ('id_presentation' => $id_presentation['last_pres_inserted'], 
								'id_orateur' => $id_orateur['last_orateur_inserted']
								) );
       

       
	}
	
	// ///////////////////////////////
	// insert la table presente à partir de last insert id de presentation et id orateur passé en paramètre
	// Max, fonctionne
	// //////////////////////////////////////////
	public static function insertPresenteOratExist($select_orateur) {
		$conn = Connection::get ();

        $presentation = $conn->query("SELECT max(last_insert_id(id_presentation)) as last_pres_inserted FROM presentation");
		$id_presentation = $presentation->fetch();
		
		
		$req = $conn->prepare ( "INSERT INTO presente (id_presentation, id_orateur) VALUES (:id_presentation, :select_orateur)" );	
		$req->execute ( array ('id_presentation' => $id_presentation['last_pres_inserted'], 
								'select_orateur' => $select_orateur
								) );
       
	}


	// ///////////////////////////////
	// supprime une présentation
	// Michel, fonctionne
	// //////////////////////////////////////////

	public static function supprPres($id_presentation) {
		$conn = Connection::get ();

		  $sql = "	DELETE 	
				   	FROM presentation
				 	WHERE id_presentation = ".$id_presentation ;

		$result = $conn->exec($sql);
		return $result;
	}

	
	// //////////////////////////////////////////////////////////////////////////////////////////////////
	// //Getters
	
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
