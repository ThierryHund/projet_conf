<?php

/**
 * @name Base_Entreprise
 * @version 21/09/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Entreprise
{
    /** @var PDO  */
    protected $_pdo;
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var int  */
    protected $_idEntreprise;
    
    /** @var int  */
    protected $_id_entreprise;
    
    /** @var string  */
    protected $_nom;
    
    /** @var string  */
    protected $_adresse_entp;
    
    /** @var string  */
    protected $_url;
    
    /** @var string  */
    protected $_logo;
    
    /**
     * Construire un(e) entreprise
     * @param $pdo PDO 
     * @param $idEntreprise int 
     * @param $id_entreprise int 
     * @param $nom string 
     * @param $adresse_entp string 
     * @param $url string 
     * @param $logo string 
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idEntreprise,$id_entreprise,$nom,$adresse_entp,$url,$logo,$lazyload=true)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idEntreprise = $idEntreprise;
        $this->_id_entreprise = $id_entreprise;
        $this->_nom = $nom;
        $this->_adresse_entp = $adresse_entp;
        $this->_url = $url;
        $this->_logo = $logo;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idEntreprise] = $this;
        }
    }
    
    /**
     * Créer un(e) entreprise
     * @param $pdo PDO 
     * @param $id_entreprise int 
     * @param $nom string 
     * @param $adresse_entp string 
     * @param $url string 
     * @param $logo string 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Entreprise 
     */
    public static function create(PDO $pdo,$id_entreprise,$nom,$adresse_entp,$url,$logo,$lazyload=true)
    {
        // Ajouter le/la entreprise dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Entreprise::TABLENAME.' ('.Entreprise::FIELDNAME_ID_ENTREPRISE.','.Entreprise::FIELDNAME_NOM.','.Entreprise::FIELDNAME_ADRESSE_ENTP.','.Entreprise::FIELDNAME_URL.','.Entreprise::FIELDNAME_LOGO.') VALUES (?,?,?,?,?)');
        if (!$pdoStatement->execute(array($id_entreprise,$nom,$adresse_entp,$url,$logo))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) entreprise dans la base de données');
        }
        
        // Construire le/la entreprise
        return new Entreprise($pdo,intval($pdo->lastInsertId()),$id_entreprise,$nom,$adresse_entp,$url,$logo,$lazyload);
    }
    
    /**
     * Compter les entreprises
     * @param $pdo PDO 
     * @return int Nombre de entreprises
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Entreprise::FIELDNAME_IDENTREPRISE.') FROM '.Entreprise::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des entreprises dans la base de données');
        }
        return $pdoStatement->fetchColumn();
    }
    
    /**
     * Requête de sélection
     * @param $pdo PDO 
     * @param $where string|array 
     * @param $orderby string|array 
     * @param $limit string|array 
     * @param $from string|array 
     * @return PDOStatement 
     */
    protected static function _select(PDO $pdo,$where=null,$orderby=null,$limit=null,$from=null)
    {
        return $pdo->prepare('SELECT DISTINCT '.Entreprise::TABLENAME.'.'.Entreprise::FIELDNAME_IDENTREPRISE.', '.Entreprise::TABLENAME.'.'.Entreprise::FIELDNAME_ID_ENTREPRISE.', '.Entreprise::TABLENAME.'.'.Entreprise::FIELDNAME_NOM.', '.Entreprise::TABLENAME.'.'.Entreprise::FIELDNAME_ADRESSE_ENTP.', '.Entreprise::TABLENAME.'.'.Entreprise::FIELDNAME_URL.', '.Entreprise::TABLENAME.'.'.Entreprise::FIELDNAME_LOGO.' '.
                             'FROM '.Entreprise::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ($where != null ? ' WHERE '.(is_array($where) ? implode(' AND ',$where) : $where) : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : '').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) entreprise
     * @param $pdo PDO 
     * @param $idEntreprise int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Entreprise 
     */
    public static function load(PDO $pdo,$idEntreprise,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idEntreprise])) {
            return self::$_lazyload[$idEntreprise];
        }
        
        // Charger le/la entreprise
        $pdoStatement = self::_select($pdo,Entreprise::FIELDNAME_IDENTREPRISE.' = ?');
        if (!$pdoStatement->execute(array($idEntreprise))) {
            throw new Exception('Erreur lors du chargement d\'un(e) entreprise depuis la base de données');
        }
        
        // Récupérer le/la entreprise depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Entreprise::FIELDNAME_IDENTREPRISE.' = ?');
        if (!$pdoStatement->execute(array($this->_idEntreprise))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) entreprise depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idEntreprise,$id_entreprise,$nom,$adresse_entp,$url,$logo) = $values;
        
        // Sauvegarder les valeurs
        $this->_id_entreprise = $id_entreprise;
        $this->_nom = $nom;
        $this->_adresse_entp = $adresse_entp;
        $this->_url = $url;
        $this->_logo = $logo;
    }
    
    /**
     * Charger tous/toutes les entreprises
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Entreprise[] Tableau de entreprises
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les entreprises
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les entreprises
        $entreprises = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $entreprises;
    }
    
    /**
     * Sélectionner tous/toutes les entreprises
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les entreprises depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la entreprise suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Entreprise 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idEntreprise,$id_entreprise,$nom,$adresse_entp,$url,$logo) = $values;
        
        // Construire le/la entreprise
        return $lazyload && isset(self::$_lazyload[intval($idEntreprise)]) ? self::$_lazyload[intval($idEntreprise)] :
               new Entreprise($pdo,intval($idEntreprise),intval($id_entreprise),$nom,$adresse_entp,$url,$logo,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les entreprises d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Entreprise[] Tableau de entreprises
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $entreprises = array();
        while ($entreprise = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $entreprises[] = $entreprise;
        }
        return $entreprises;
    }
    
    /**
     * Test d'égalité
     * @param $entreprise Entreprise 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($entreprise)
    {
        // Test si null
        if ($entreprise == null) { return false; }
        
        // Tester la classe
        if (!($entreprise instanceof Entreprise)) { return false; }
        
        // Tester les ids
        return $this->_idEntreprise == $entreprise->_idEntreprise;
    }
    
    /**
     * Vérifier que le/la entreprise existe en base de données
     * @return bool Le/La entreprise existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Entreprise::FIELDNAME_IDENTREPRISE.') FROM '.Entreprise::TABLENAME.' WHERE '.Entreprise::FIELDNAME_IDENTREPRISE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdEntreprise()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) entreprise existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la entreprise
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer le/la entreprise
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Entreprise::TABLENAME.' WHERE '.Entreprise::FIELDNAME_IDENTREPRISE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdEntreprise()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) entreprise dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idEntreprise])) {
            unset(self::$_lazyload[$this->_idEntreprise]);
        }
        
        // Opération réussie ?
        return $pdoStatement->rowCount() == 1;
    }
    
    /**
     * Mettre à jour un champ dans la base de données
     * @param $fields array 
     * @param $values array 
     * @return bool Opération réussie ?
     */
    protected function _set($fields,$values)
    {
        // Préparer la mise à jour
        $updates = array();
        foreach ($fields as $field) {
            $updates[] = $field.' = ?';
        }
        
        // Mettre à jour le champ
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Entreprise::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Entreprise::FIELDNAME_IDENTREPRISE.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdEntreprise())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) entreprise dans la base de données');
        }
        
        // Opération réussie ?
        return $pdoStatement->rowCount() == 1;
    }
    
    /**
     * Mettre à jour tous les champs dans la base de données
     * @return bool Opération réussie ?
     */
    public function update()
    {
        return $this->_set(array(Entreprise::FIELDNAME_ID_ENTREPRISE,Entreprise::FIELDNAME_NOM,Entreprise::FIELDNAME_ADRESSE_ENTP,Entreprise::FIELDNAME_URL,Entreprise::FIELDNAME_LOGO),array($this->_id_entreprise,$this->_nom,$this->_adresse_entp,$this->_url,$this->_logo));
    }
    
    /**
     * Récupérer le/la idEntreprise
     * @return int 
     */
    public function getIdEntreprise()
    {
        return $this->_idEntreprise;
    }
    
    /**
     * Récupérer le/la id_entreprise
     * @return int 
     */
    public function getId_entreprise()
    {
        return $this->_id_entreprise;
    }
    
    /**
     * Définir le/la id_entreprise
     * @param $id_entreprise int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setId_entreprise($id_entreprise,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_id_entreprise = $id_entreprise;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Entreprise::_set(array(Entreprise::FIELDNAME_ID_ENTREPRISE),array($id_entreprise)) : true;
    }
    
    /**
     * Récupérer le/la nom
     * @return string 
     */
    public function getNom()
    {
        return $this->_nom;
    }
    
    /**
     * Définir le/la nom
     * @param $nom string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setNom($nom,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_nom = $nom;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Entreprise::_set(array(Entreprise::FIELDNAME_NOM),array($nom)) : true;
    }
    
    /**
     * Récupérer le/la adresse_entp
     * @return string 
     */
    public function getAdresse_entp()
    {
        return $this->_adresse_entp;
    }
    
    /**
     * Définir le/la adresse_entp
     * @param $adresse_entp string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setAdresse_entp($adresse_entp,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_adresse_entp = $adresse_entp;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Entreprise::_set(array(Entreprise::FIELDNAME_ADRESSE_ENTP),array($adresse_entp)) : true;
    }
    
    /**
     * Récupérer le/la url
     * @return string 
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Définir le/la url
     * @param $url string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setUrl($url,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_url = $url;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Entreprise::_set(array(Entreprise::FIELDNAME_URL),array($url)) : true;
    }
    
    /**
     * Récupérer le/la logo
     * @return string 
     */
    public function getLogo()
    {
        return $this->_logo;
    }
    
    /**
     * Définir le/la logo
     * @param $logo string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setLogo($logo,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_logo = $logo;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Entreprise::_set(array(Entreprise::FIELDNAME_LOGO),array($logo)) : true;
    }
    
    /**
     * ToString
     * @return string Représentation de entreprise sous la forme d'un string
     */
    public function __toString()
    {
        return '[Entreprise idEntreprise="'.$this->_idEntreprise.'" id_entreprise="'.$this->_id_entreprise.'" nom="'.$this->_nom.'" adresse_entp="'.$this->_adresse_entp.'" url="'.$this->_url.'" logo="'.$this->_logo.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la entreprise
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la entreprise
        $array = array('identreprise' => $this->_idEntreprise,'id_entreprise' => $this->_id_entreprise,'nom' => $this->_nom,'adresse_entp' => $this->_adresse_entp,'url' => $this->_url,'logo' => $this->_logo);
        
        // Retourner la sérialisation (ou pas) du/de la entreprise
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la entreprise
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Entreprise 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la entreprise
        return $lazyload && isset(self::$_lazyload[$array['identreprise']]) ? self::$_lazyload[$array['identreprise']] :
               new Entreprise($pdo,$array['identreprise'],$array['id_entreprise'],$array['nom'],$array['adresse_entp'],$array['url'],$array['logo'],$lazyload);
    }
    
}

