<?php

// AUTOLOADER ==============================================
spl_autoload_register(function ($class) {
    include '../classes/'. $class . '.class.php';
  });

//  FUNCTIONS ===============================================

// Simulate a single attack
function singleAttack($attacker, $target){
    $attacker->attackOpponent($target);
}

//Simulate the initiative test and the order of attack and check if there is a win.
function fight($fighterA, $fighterB, $dice){
    $isKO = false;
    while(!$isKO){

        // Test d'initiative.
        $fighterA->setForce($dice->rollDice());
        $fighterB->setForce($dice->rollDice());

        // Ordre d'attaque conséquent.
        if ($fighterA->getForce() > $fighterB->getForce()){

            $fighterA->setAttackDamageValue($dice->rollDice());
            singleAttack($fighterA, $fighterB);
            echo $fighterA->getName()." a l'initiative, il attaque ". $fighterB->getName() ." et lui inflige ". $fighterA->getAttackDamageValue() ." points de dégats";
            echo "<br>";


            $fighterB->setAttackDamageValue($dice->rollDice());
            singleAttack($fighterB, $fighterA);
            echo $fighterB->getName()." riposte et attaque ". $fighterA->getName() ." lui infligeant ". $fighterB->getAttackDamageValue() ." points de dégats";
            echo "<br>";
            

        }

        else{
            $fighterB->setAttackDamageValue($dice->rollDice());
            singleAttack($fighterB, $fighterA);
            echo $fighterB->getName()." a l'initiative, il attaque ". $fighterA->getName() ." et lui inflige ". $fighterB->getAttackDamageValue() ." points de dégats";
            echo "<br>";

            $fighterA->setAttackDamageValue($dice->rollDice());
            singleAttack($fighterA, $fighterB);
            echo $fighterA->getName()." riposte et attaque ". $fighterB->getName() ." lui infligeant ". $fighterA->getAttackDamageValue() ." points de dégats";
            echo "<br>";
        }

        //Compte rendu de l'action et fin de boucle en cas de KO.
        if($fighterA->getLife() <= 0 or $fighterB->getLife() <= 0){
            $isKO = true;

            if($fighterA->getLife()<= 0){
                echo "<hr>";
                echo $fighterA->getName()." is KO ";
            }
            if($fighterB->getLife()<= 0){
                echo "<hr>";
                echo $fighterB->getName()." is KO ";
            }
        }
        else{
            echo $fighterA->getName(). " a  ". $fighterA->getLife()  . " points de vie et " . $fighterB->getName(). " a ".$fighterB->getLife()." points de vie.";
            echo "<hr>";
        }
    }
}

// Récupération des informations du formulaire d'organisation de combat.

// Récupération des données relatives aux combattants dans la BDD selon les infos du formulaire de combat.

// Instantiation et hydratation des classes des combatants avec les informations de la BDD.

$opponent_A = new Character("Static_ONE");
$opponent_B = new Character("Static_TWO");
$d6 = new Dice(6);

// COMBAT !
fight($opponent_A, $opponent_B, $d6);

?>



