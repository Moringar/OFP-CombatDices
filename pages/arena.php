<?php

// AUTOLOADER ==============================================
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});



//  FUNCTIONS ===============================================

// Simulate a single attack

function nameAttack(){
    $attacks = [
        "effectue une mawashigeri sur", 
        "frappe très fort", 
        "défonce le visage de", 
        "dégomme les côtes de",
        "démonte les genoux de ", 
        "casse les dents de", 
        "délivre un immense crochet du menton a", 
        "attrape la table basse et l'énfonce dans", 
        "lui fait une pichenette vigoureuse sur l'oreille de", 
        "fait une brulûre indienne a", 
        "insulte violemment", 
        "étale du piment dans les yeux de"
    ];

    $i = rand(0, sizeof($attacks)-1);


    return $attacks[$i];
}

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
        echo "<round>";

        // Ordre d'attaque conséquent.
        if ($fighterA->getForce() > $fighterB->getForce()) {
            singleAttack($fighterA, $fighterB, $dice);

            echo "<p class='fA'>" . $fighterA->getName() . " a l'initiative et ".nameAttack()." " . $fighterB->getName() . " et lui inflige " . $fighterA->getAttackDamageValue() . " points de dégats </p>";

            if ($fighterB->getLife() > 0) {
                singleAttack($fighterB, $fighterA, $dice);

                echo "<p class='fB'>" . $fighterB->getName() . " riposte et ".nameAttack()." " . $fighterA->getName() . " lui infligeant " . $fighterB->getAttackDamageValue() . " points de dégats </p>";
            } else {
                echo "<p class='fB'>" . $fighterB->getName() . " succombe des coups de " . $fighterA->getName() . "</p>";
            }
        } else {
            singleAttack($fighterB, $fighterA, $dice);

            echo "<p class='fB'>" . $fighterB->getName() . " a l'initiative et ".nameAttack()." " . $fighterA->getName() . " et lui inflige " . $fighterB->getAttackDamageValue() . " points de dégats </p>";

            if ($fighterA->getLife() > 0) {
                singleAttack($fighterA, $fighterB, $dice);

                echo "<p class='fA'>" . $fighterA->getName() . " riposte et ".nameAttack()." " . $fighterB->getName() . " lui infligeant " . $fighterA->getAttackDamageValue() . " points de dégats </p>";
            } else {
                echo "<p class='fA'>" . $fighterA->getName() . " succombe des coups de " . $fighterB->getName() . "</p>";
            }
        }
        echo "</round>";

        echo "<result>";
        //Compte rendu de l'action et fin de boucle en cas de KO.
        if ($fighterA->getLife() <= 0 or $fighterB->getLife() <= 0) {
            $isKO = true;

            if ($fighterA->getLife() <= 0) {
                echo "<p>" . $fighterA->getName() . " n'est plus en mesure de se battre, " . $fighterB->getName() . " est le vainqueur.</p>";
            }
            if ($fighterB->getLife() <= 0) {
                echo "<p>" . $fighterB->getName() . " n'est plus en mesure de se battre, " . $fighterA->getName() . " est le vainqueur.</p>";
            }
        } else {
            echo "<p>" . $fighterA->getName() . " a  " . $fighterA->getLife()  . " points de vie et " . $fighterB->getName() . " a " . $fighterB->getLife() . " points de vie.</p>";
        }
        echo "</result>";
    }
}

// Récupération des informations du formulaire d'organisation de combat.

// Récupération des données relatives aux combattants dans la BDD selon les infos du formulaire de combat.

// Instantiation et hydratation des classes des combatants avec les informations de la BDD.


// if there is not a personnage DIE

if( $_GET["opponent1"] == '' || $_GET["opponent2"]  == '' ){
    echo"Choose a personnage to play <br>";
}
else if ( $_GET["opponent1"] == $_GET["opponent2"]){
    echo "Suicide is a very bad idea, call for help. <br>";
}
else {

    // conection database

    $database = new Database("localhost", "root", "combat_dices", "root");
    $database->connect();

    // list of personnage
    $opponent_1_name = $_GET["opponent1"];
    $opponent_2_name = $_GET["opponent2"];


    $preReq = $database->prepReq("SELECT point_vie FROM personnage WHERE name ='$opponent_1_name'");
    $op1_lifePoints = $database->fetchdata(PDO::FETCH_OBJ);

    $preReq = $database->prepReq("SELECT point_vie FROM personnage WHERE name ='$opponent_2_name'");
    $op2_lifePoints = $database->fetchdata(PDO::FETCH_OBJ);

    var_dump($op2_lifePoints);

    $opponent_A = new Character($opponent_1_name);
    $opponent_B = new Character($opponent_2_name);

    $d6 = new Dice(6);

    $opponent_A->setLife($op1_lifePoints[0]->point_vie);
    $opponent_B->setLife($op2_lifePoints[0]->point_vie);

    // COMBAT !
    ?>


    <link rel="stylesheet" href="../style/index.css">

    <section class="arena">

        <?php
        fight($opponent_A, $opponent_B, $d6);
        ?>
    </section>

    <?php

    $opponent_A_currentLife = $opponent_A->getLife();
    $opponent_B_currentLife = $opponent_B->getLife();


    // $preReq = $database->prepReq("UPDATE personnage SET point_vie = '$opponent_A_currentLife' WHERE name = '$opponent_1_name'");

    // $preReq = $database->prepReq("UPDATE personnage SET point_vie = '$opponent_B_currentLife' WHERE name = '$opponent_2_name'");


    // $prepReq = $database->prepReq("DELETE FROM personnage WHERE point_vie <= 0");

    // $preReq = $database->prepReq("UPDATE personnage SET point_vie = (point_vie + 25) WHERE point_vie < 100");
}
    ?>

<script src="../scripts/arena.js"></script>
<a href="/">Retour à l'accueil</a>