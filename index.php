<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

?>

<h1>COMBAT ARENA Hello</h1>

<?php

// connection DB

$database = new Database("localhost", "root", "combat_dices", "");

$database->connect();
// $database->prepReq("SELECT * FROM perssonage");
$personnage = $database->fetchData();




// Generate a form to add fighter to the bdd and the list.
$formulaire = new Form("./pages/register.php", "GET");
$formulaire->createField("nom", "nom", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();


?>

