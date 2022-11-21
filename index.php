<?php
// TODO : autoload classes.
 include "./classes/Form.class.php"
?>

<h1>COMBAT ARENA Hello</h1>

<?php
// Generate a form to add fighter to the bdd.

$formulaire = new Form("./pages/arena.php", "GET");
$formulaire->createField("nom", "nom", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();

?>
