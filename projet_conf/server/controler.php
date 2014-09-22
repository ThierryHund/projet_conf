<?php
require_once "modele\dao\connection.class.php";

$conn = Connection::get ();

if(isset($_POST['connexion']))
{
	if(isset($_POST['login']) && isset($_POST['password'])){
		$login=$_POST['login'];
		$password=$_POST['password'];
            $hash = crypt($password);

            echo 'SELECT *
            FROM admin
            WHERE admin.identifiant_admin LIKE "'.$login.'"
            AND admin.mdp_admin LIKE "'.$hash.'"';

		$verif_login = $conn->query('SELECT *
            FROM admin
            WHERE admin.identifiant_admin LIKE "'.$login.'"
            AND admin.mdp_admin LIKE "'.$hash.'"');

            $liste = $verif_login->fetchAll();
            if (count($liste) == 0) { 
            	echo 'ta race';
            }
            else echo 'couille';
	}
}