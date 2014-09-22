<?php
require_once "connection.class.php";

$conn = Connection::get ();

if(isset($_POST['connexion']))
{
	if(isset($_POST['login']) && isset($_POST['password'])){
		$login=$_POST['login'];
		$password=$_POST['password'];

		$verif_login = $conn->query('SELECT *
            FROM admin
            WHERE admin.identifiant_admin LIKE "'.$login.'"
            AND admin.mdp_admin LIKE "'.$password);

            $liste = $verif_login->fetchAll();
            if (count($liste) == 0) { 
            	echo 'Erreur dans l\'identifiant ou dans le mot de passe.';
            }
            else header('location:accueil.html');
	}
}

print "kklklkl";