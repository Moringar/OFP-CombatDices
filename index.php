<?php
// TODO : autoload classes.
spl_autoload_register(function ($class) 
{
  include 'classes/' . $class . '.class.php';
});
?>

<!-- Includes the stylesheet -->
<head>
  <link rel="stylesheet" href="./style/index.css">
</head>

<h1>COMBAT ARENA</h1>

<?php

$database = new Database("localhost", "root", "combat_dices", "root");
$database->connect();

// Inserts links of files in the IMG folder to the database.
$files = array_diff(scandir('assets/img/'), array('.', '..'));
foreach ($files as $file) 
{
  $link = "<img src='/assets/img/$file'>";
  $linkCheck = $database->prepReq("SELECT * FROM avatar WHERE link = :link", ["link" => $link]);
  if ($linkCheck->rowCount() === 0) 
  {
    $database->prepReq("INSERT INTO avatar (link) VALUE (:link)", ['link' => $link]);
    echo "<br>";
  } 
}

// Displays a list of all the created characters
$preReq = $database->prepReq("SELECT name, point_vie FROM personnage");
$fetchData = $database->fetchdata(PDO::FETCH_OBJ);

echo "<ul>";
foreach ($fetchData as $person) {
  echo "<li>$person->name [PV: $person->point_vie ] </li>";
}
echo "<ul>";

echo "<hr>";


// Generate a form to add fighter to the bdd, and assign it a fighter portrait.
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



<!-- Displays a message if the user tried to create an already existing fighter. -->
<?php
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


<!-- Get the list of fighters from the database and displays two lists of fighters to choose from. They will fight to death -->
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


<!-- Include the script to manage the index page. -->
<script src="./scripts/index.js"></script>