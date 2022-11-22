<?php

spl_autoload_register(function ($class) {
  include '../classes/' . $class . '.class.php';
});

$database = new Database("localhost", "root", "combat_dices", "root");
$database->connect();


$name = $_GET['name'];

$preReq = $database->prepReq("SELECT * FROM personnage WHERE name = :name", ["name"=>$name]);

$personnage = $database->fetchData(PDO::FETCH_OBJ);
// var_dump($personnage);


if($preReq->rowCount() > 0)
{
  echo"Personnage déja existant";

} else

{
  $preReq = $database->prepReq("INSERT INTO personnage (name, point_vie) VALUE (:name, 100)", ["name" => $name]);
   echo "Vous êtes inscrit...bonne chance ";
   header('/index.php');
}
echo"<br>";
?>
<a href="/">Retour à l'accueil</a>
