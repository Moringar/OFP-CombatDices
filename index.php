<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) 
{
  include 'classes/' . $class . '.class.php';
});
?>

<head>
  <link rel="stylesheet" href="./style/index.css">
</head>

<h1>COMBAT ARENA</h1>

<?php

$database = new Database("localhost", "root", "combat_dices", "root");
$database->connect();

// conn img with DB
$files = array_diff(scandir('assets/img/'), array('.', '..'));

foreach ($files as $file) {

  $link = "<img src='/assets/img/$file'>";
  
  $linkCheck = $database->prepReq("SELECT * FROM avatar WHERE link = :link", ["link" => $link]);
  


  if ($linkCheck->rowCount() === 0) 
  {
    $database->prepReq("INSERT INTO avatar (link) VALUE (:link)", ['link' => $link]);
    echo "<br>";
  } 
  
  
}


// list of personnage

$preReq = $database->prepReq("SELECT name, point_vie FROM personnage");
$fetchData = $database->fetchdata(PDO::FETCH_OBJ);

// var_dump($fetchData);

// var_dump($fetchData);

echo "<ul>";
foreach ($fetchData as $person) {
  echo "<li>$person->name [PV: $person->point_vie ] </li>";
}
echo "<ul>";


echo "<hr>";
// Generate a form to add fighter to the bdd.
$formulaire = new Form("./pages/register.php", "GET");
$formulaire->createField("text", "name", "name", "Héro");


$formulaire->openSection();

$database->prepReq("SELECT link, id FROM avatar ");
$listAvatar = $database->fetchdata(PDO::FETCH_OBJ);

foreach($listAvatar as $avatar){
  $formulaire->createRadio("avatar-selection", $avatar->link, $avatar->id);
}
$formulaire->closeSection();



$formulaire->createSubmitButton("POUET");
$formulaire->generateForm();

?>

<?php

// form choose personnage to fight



$preReq = $database->prepReq("SELECT name FROM personnage");

if (isset($_GET['msg'])) {
  if ($_GET['msg'] == 'error') {
    $message = "Personnage déja existant";
    echo $message;
  } else {
    echo "Vous êtes inscrit...bonne chance ";
  }
}




?>

<form action="./pages/arena.php">
  <?php

  $opponent_1_select = new Select("opponent1");
  $opponent_1_select->labelOption("Personnage");
  foreach ($fetchData as $person) {
    $opponent_1_select->createOptions($person->name);
  }
  $opponent_1_select->generateSelect();

  $opponent_2_select = new Select("opponent2");
  $opponent_2_select->labelOption("Personnage");
  foreach ($fetchData as $person) {
    $opponent_2_select->createOptions($person->name);
  }
  $opponent_2_select->generateSelect();

  ?>
  <input type="submit">
</form>

<script src="./scripts/index.js"></script>