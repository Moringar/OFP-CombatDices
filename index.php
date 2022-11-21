<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) {
  include $class . '.class.php';
});
?>

<h1>COMBAT ARENA Hello</h1>

<?php

// connection DB

$database = new Database("localhost", "root", "combat_dices", "");

$database->connect();
// $database->prepReq("SELECT * FROM perssonage");
$personnage = $database->fetchData();




// Generate a form to add fighter to the bdd.

$formulaire = new Form("./pages/arena.php", "GET");
$formulaire->createField("nom", "nom", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();







// Character Class Test
$aldur = new Character("Aldur");
$aldur->setForce(3);
$aldur->setAttackDamageValue(2);



$gromir = new Character("Gromir");
$gromir->setForce(3);
$gromir->setAttackDamageValue(2);


$aldur->attackOpponent($gromir);

var_dump($aldur);
var_dump($gromir);


?>

