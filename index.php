<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

?>

<h1>COMBAT ARENA</h1>

<?php

// connection DB

// $database = new Database("localhost", "root", "combat_dices", "");

// var_dump($database);

// $database->connect();
// // $database->prepReq("SELECT * FROM perssonage");
// $personnage = $database->fetchData();




// Generate a form to add fighter to the bdd.
$formulaire = new Form("./pages/register.php", "GET");
$formulaire->createField("text", "name", "name", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();
?>

<?php

// form choose personnage to fight

// $preReq = $database->prepReq("SELECT name FROM personnage");





?>







<?php
$opponent_1_select = new Select("opponent1");
$opponent_1_select->createOptions("Gerard");
$opponent_1_select->createOptions("Lucie");
$opponent_1_select->createOptions("Popo");
$opponent_1_select->generateSelect();


$opponent_2_select = new Select("opponent2");
$opponent_2_select->createOptions("Annie");
$opponent_2_select->createOptions("Florent");
$opponent_2_select->createOptions("Jacques");
$opponent_2_select->createOptions("Momo");$opponent_2_select->generateSelect();
?>