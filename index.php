<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

?>

<h1>COMBAT ARENA</h1>

<?php

$database = new Database("localhost", "root", "combat_dices", "");
$database->connect();

// list of personnage

$preReq = $database->prepReq("SELECT name FROM personnage");
$fetchData = $database->fetchdata();

var_dump($fetchData);

echo"<ul>";
  foreach($fetchData as $name)
  {
    echo"<li>$name</li>";
  }
echo "<ul>";



// Generate a form to add fighter to the bdd.

$formulaire = new Form("./pages/register.php", "GET");
$formulaire->createField("name", "name", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();


?>

<?php

// form choose personnage to fight

$preReq = $database->prepReq("SELECT name FROM personnage");





?>