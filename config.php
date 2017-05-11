<?php
$bdd = new mysqli("localhost", "root", "", "ecommerce");

if ($bdd->connect_error) die('Un Problème est survenu lors de la connexion à la BDD :' .$bdd->connect_error);

$bdd->set_charset('utf8');

session_start();

//define("RACINE_SITE", "/site/");

$contenu = '';
$succes = '';

require_once('functions.php');
?>