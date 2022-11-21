<?php
// TODO : autoload classes.
 include "./classes/Form.class.php";
 include "./classes/Character.class.php";
?>

<h1>COMBAT ARENA Hello</h1>

<?php
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


