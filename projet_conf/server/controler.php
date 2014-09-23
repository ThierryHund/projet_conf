<?php
require_once "modele\dao\connection.class.php";

$conn = Connection::get ();

if(isset($_POST['connexion']))
{
	if(isset($_POST['login']) && isset($_POST['password'])){
		$login=$_POST['login'];
		$password=$_POST['password'];

		$verif_login = $conn->query('SELECT *
            FROM admin
            WHERE admin.identifiant_admin LIKE "'.$login.'"
            AND admin.mdp_admin LIKE "'.$password.'"');

            $liste = $verif_login->fetchAll();
            if (count($liste) == 0) { 
            	header('location:..\app_cordova\www\connexion.html');
            }
            else {
                  var_dump(session_start());
                  if (!isset($_SESSION['login'])) {
                        header('location:..\app_cordova\www\connexion.html');
                        exit();
                  }
                  else header ('location:..\app_cordova\www\accueil.html');
            }
	}
}