<?php

// AUTOLOADER ==============================================
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});



//  FUNCTIONS ===============================================

// Simulate a single attack
function singleAttack($attacker, $target, $dice)
{
    $attacker->setAttackDamageValue($dice->rollDice());
    $attacker->attackOpponent($target);
}



//Simulate the initiative test and the order of attack and check if there is a win.
function fight($fighterA, $fighterB, $dice)
{
    $isKO = false;
    while (!$isKO) {

        // Test d'initiative.
        $fighterA->setForce($dice->rollDice());
        $fighterB->setForce($dice->rollDice());


        // Ordre d'attaque conséquent.
        if ($fighterA->getForce() > $fighterB->getForce()) {
            singleAttack($fighterA, $fighterB, $dice);

            echo "<p>" . $fighterA->getName() . " a l'initiative, il attaque " . $fighterB->getName() . " et lui inflige " . $fighterA->getAttackDamageValue() . " points de dégats </p>";

            if ($fighterB->getLife() > 0) {
                singleAttack($fighterB, $fighterA, $dice);

                echo "<p>" . $fighterB->getName() . " riposte et attaque " . $fighterA->getName() . " lui infligeant " . $fighterB->getAttackDamageValue() . " points de dégats </p>";
            } else {
                echo "<p>" . $fighterB->getName() . " succombe des coups de " . $fighterA->getName() . "</p>";
            }
        } else {
            singleAttack($fighterB, $fighterA, $dice);

            echo "<p>" . $fighterB->getName() . " a l'initiative, il attaque " . $fighterA->getName() . " et lui inflige " . $fighterB->getAttackDamageValue() . " points de dégats </p>";

            if ($fighterA->getLife() > 0) {
                singleAttack($fighterA, $fighterB, $dice);

                echo "<p>" . $fighterA->getName() . " riposte et attaque " . $fighterB->getName() . " lui infligeant " . $fighterA->getAttackDamageValue() . " points de dégats </p>";
            } else {
                echo "<p>" . $fighterA->getName() . " succombe des coups de " . $fighterB->getName() . "</p>";
            }
        }

        //Compte rendu de l'action et fin de boucle en cas de KO.
        if ($fighterA->getLife() <= 0 or $fighterB->getLife() <= 0) {
            $isKO = true;

            if ($fighterA->getLife() <= 0) {
                echo "<hr>";
                echo "<p>" . $fighterA->getName() . " n'est plus en mesure de se battre, " . $fighterB->getName() . " est le vainqueur.</p>";
            }
            if ($fighterB->getLife() <= 0) {
                echo "<hr>";
                echo "<p>" . $fighterB->getName() . " n'est plus en mesure de se battre, " . $fighterA->getName() . " est le vainqueur.</p>";
            }
        } else {
            echo "<p>" . $fighterA->getName() . " a  " . $fighterA->getLife()  . " points de vie et " . $fighterB->getName() . " a " . $fighterB->getLife() . " points de vie.</p>";
            echo "<hr>";
        }
    }
}

// Récupération des informations du formulaire d'organisation de combat.

// Récupération des données relatives aux combattants dans la BDD selon les infos du formulaire de combat.

// Instantiation et hydratation des classes des combatants avec les informations de la BDD.

// conection database

$database = new Database("localhost", "root", "combat_dices", "");
$database->connect();

// list of personnage
$opponent_1_name = $_GET["opponent1"];
$opponent_2_name = $_GET["opponent2"];


$preReq = $database->prepReq("SELECT point_vie FROM personnage WHERE name ='$opponent_1_name'");
$op1_lifePoints = $database->fetchdata(PDO::FETCH_COLUMN);

$preReq = $database->prepReq("SELECT point_vie FROM personnage WHERE name ='$opponent_2_name'");
$op2_lifePoints = $database->fetchdata(PDO::FETCH_COLUMN);


$opponent_A = new Character($opponent_1_name);
$opponent_B = new Character($opponent_2_name);

$d6 = new Dice(6);

$opponent_A->setLife($op1_lifePoints[0]);
$opponent_B->setLife($op2_lifePoints[0]);

// COMBAT !
?>


<section class="arena">
    <h2>MORTAAAL KOOMMMBAAAAT</h2>

    <?php
    fight($opponent_A, $opponent_B, $d6);
    ?>
</section>

<?php

$opponent_A_currentLife = $opponent_A->getLife();
$opponent_B_currentLife = $opponent_B->getLife();


$preReq = $database->prepReq("UPDATE personnage SET point_vie = '$opponent_A_currentLife' WHERE name = '$opponent_1_name'");

$preReq = $database->prepReq("UPDATE personnage SET point_vie = '$opponent_B_currentLife' WHERE name = '$opponent_2_name'");

$prepReq = $database->prepReq("DELETE FROM personnage WHERE point_vie <= 0");

?>