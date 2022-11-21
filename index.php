<?php
// TODO : autoload classes.
 include "./classes/Form.class.php"
?>

<h1>COMBAT ARENA</h1>

<?php
// Generate a form to add fighter to the bdd.

$formulaire = new Form("GET", "./pages/arena.php");
$formulaire->createField("nom", "nom", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();

?>
