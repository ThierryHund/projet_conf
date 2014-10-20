<?php	


class SendMail 
{
	
	protected $subject;
	protected $texte;
	protected $mailFrom;

	function __construct()
	{
		$this -> subject = $_POST['subject'];
		$this -> texte = $_POST['message'];
		$this -> mailFrom = $_POST['email'];
		
	}
	

	public static function sendEmail($subject, $texte, $mailFrom){



		$mail = 'adresse mail à saisir'; // Déclaration de l'adresse de destination.

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
		{
			$newline = "\r\n";
		}
		else
		{
			$newline = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_html = "<html><head></head><body>Bonjour, <br/> 
													<p> Voici le commentaire laissé par l'utilisateur  : <br/><br/> $texte </p> <br/> 
 
											</body>
						</html>";
		//==========
		 
		 
		//=====Création de la boundary.
		$boundary = "-----=".md5(rand());
		$boundary_alt = "-----=".md5(rand());
		//==========
		 
		//=====Définition du sujet.
		$subject_mail = "Un mail de l'application Conference avec pour sujet : " .$subject;
		//=========
		 	
		//=====Création du header de l'e-mail.
		$header = "From: $mailFrom".$newline;
		$header.= "MIME-Version: 1.0".$newline;
		$header.= "Content-Type: multipart/mixed;".$newline." boundary=\"$boundary\"".$newline;
		//==========
		 
		//=====Création du message.
		$message = $newline."--".$boundary.$newline;
		$message.= "Content-Type: multipart/alternative;".$newline." boundary=\"$boundary_alt\"".$newline;
		$message.= $newline."--".$boundary_alt.$newline;
		 
		$message.= $newline."--".$boundary_alt.$newline;
		 
		//=====Ajout du message au format HTML.
		$message.= "Content-Type: text/html; charset=\"UTF-8\"".$newline;
		$message.= "Content-Transfer-Encoding: 8bit".$newline;
		$message.= $newline.$message_html.$newline;
		//==========
		 
		//=====On ferme la boundary alternative.
		$message.= $newline."--".$boundary_alt."--".$newline;
		//==========
		 
		 
		 
		$message.= $newline."--".$boundary.$newline;
		 

		//=====Envoi de l'e-mail.
		$email = mail($mail,$subject_mail,$message,$header);

		return $email;
		 
		//==========

	}
}

?>