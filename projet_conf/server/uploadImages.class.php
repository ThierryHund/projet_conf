<?php

class UploadImages{
	
	protected $image ;
	protected $name ;
	protected $size ;
	protected $typ ;
	protected $rep ;
	protected $temp ;
	protected $error ;
	protected $info ;

	public function __construct($image){
		
		$this -> image = $image ;
		$this -> name = $_FILES[$image]['name'];    
		$this -> size = $_FILES[$image]['size'];		    		
		$this -> error = $_FILES[$image]['error'];
		$this -> temp = $_FILES[$image]['tmp_name']; 
		$this -> info = new SplFileInfo($this -> name);

	}


	// //////////////////////////////
	// Verifie que tout est correct
	//  et le place dans le dossier
	//  /server/images/ , Mich
	// //////////////////////////////

	public function validUpload(){

		if(true == self::UploadError() && !self::ValidExtension()){	
			
			if(true == file_exists((__DIR__).'/images/'.self::getName())){

				echo "<p style=color:red;font-weight:bold;> Image dejà téléchargée </p> <br/>";
				return false;

			}else{

				move_uploaded_file($this -> temp ,(__DIR__).'/images/'.self::getName());		
				return true;
			}
		}
	}


	public function getName(){

		return $this -> name;
	}



	// //////////////////////////////
	// Verifie le telechargement 
	// 		  du fichier
	// //////////////////////////////

	public function UploadError(){

		if ($this -> error > 0) { 

		          switch ($this -> error){     
		                   case 1: // UPLOAD_ERR_INI_SIZE     
		                   echo"<p style=color:red;font-weight:bold;>Le fichier dépasse la taille autorisée !</p> <br/>";     
		                   return false;   
		                   break;    

		                   case 2: // UPLOAD_ERR_FORM_SIZE     
		                   echo " <p style=color:red;font-weight:bold;> Le fichier dépasse la taille autorisée, 2 Mo max. !</p> <br/>"; 
		                   return false;   
		                   break;    

		                   case 3: // UPLOAD_ERR_PARTIAL     
		                   echo "<p style=color:red;font-weight:bold;> L'envoi du fichier a été interrompu pendant le transfert !</p> <br/>";     
		                   return false;   
		                   break;    

		                   case 4: // UPLOAD_ERR_NO_FILE     
		                   echo "<p style=color:red;font-weight:bold;> Le fichier que vous avez envoyé est manquant !</p> <br/>"; 
		                   return false;   
		                   break;

		                   case 6: //UPLOAD_ERR_NO_TMP_DIR
		                   echo "<p style=color:red;font-weight:bold;> Un dossier temporaire est manquant </p> <br/>";
		                   return false;   
		                   break;

		                   case 7: //UPLOAD_ERR_CANT_WRITE
		                   echo "<p style=color:red;font-weight:bold;> Échec de l'écriture du fichier sur le disque </p> <br/>";
		                   return false;   
		                   break;	

		                   case 8: //UPLOAD_ERR_EXTENSION
		                   echo "<p style=color:red;font-weight:bold;> Une extension PHP a arrêté l'envoi de fichier </p> <br/>";
		                   return false;   
		                   break;

		                   default:
		                   echo "<p style=color:red;font-weight:bold;> Selectionner une image à télécharger </p> <br/>"; 
		                   return false;   
		                   break;  
		          }
		}else{

			return true;
		}  			
	}  



	// //////////////////////////////
	// Verifie l'extension de l'image
	// //////////////////////////////

	public function ValidExtension(){

		$extensions_valid = array( 'jpg' , 'jpeg' , 'png' );
		$extension_upload = strtolower(  substr(  strrchr($this -> name, '.'),1)  );

		if ( !in_array($extension_upload,$extensions_valid) ){
			echo "<p style=color:red;font-weight:bold;> Extensions images non valide, vous devez télécharger une image de type .jpg, .jpeg ou .png </p> </br>";		
		}

	}


}

?>
