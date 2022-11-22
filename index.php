<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

?>

<h1>COMBAT ARENA</h1>

<?php

$database = new Database("localhost", "root", "combat_dices", "root");
$database->connect();

// list of personnage

$preReq = $database->prepReq("SELECT name, point_vie FROM personnage");
$fetchData = $database->fetchdata(PDO::FETCH_OBJ);

// var_dump($fetchData);

// var_dump($fetchData);

echo"<ul>";
  foreach($fetchData as $person)
  {
    echo"<li>$person->name [PV: $person->point_vie ] </li>";
  }
echo "<ul>";


echo "<hr>";
// Generate a form to add fighter to the bdd.
$formulaire = new Form("./pages/register.php", "GET");
$formulaire->createField("text", "name", "name", "Héro");
$formulaire->createSubmitButton("pouet");
$formulaire->generateForm();
?>

<?php

// form choose personnage to fight

$preReq = $database->prepReq("SELECT name FROM personnage");

?>

<form action="./pages/arena.php">
<?php

$opponent_1_select = new Select("opponent1");
foreach($fetchData as $person)
{
  $opponent_1_select->createOptions($person->name);
}
$opponent_1_select->generateSelect();

$opponent_2_select = new Select("opponent2");
foreach($fetchData as $person)
{
  $opponent_2_select->createOptions($person->name);
}
$opponent_2_select->generateSelect();

?>
<input type="submit">
</form>