<?php

spl_autoload_register(function ($class) {
  include '../classes/' . $class . '.class.php';
});

$database = new Database("localhost", "root", "combat_dices", "root");
$database->connect();


$name = $_GET['name'];
$avatar_selection = $_GET['avatar-selection'];



$preReq = $database->prepReq("SELECT * FROM personnage WHERE name = :name", ["name"=>$name]);



$personnage = $database->fetchData(PDO::FETCH_OBJ);
// var_dump($personnage);


if($preReq->rowCount() > 0)
{


} else

{
  $preReq = $database->prepReq("INSERT INTO personnage (name, point_vie, img_id) VALUE (:name, 100,:avatar_selection )", ["name" => $name, "avatar_selection" =>$avatar_selection]);
 
}
echo"<br>";
?>

<a href="/">Retour à l'accueil</a>
