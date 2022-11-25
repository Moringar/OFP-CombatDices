<?php

// AUTOLOADER ==============================================
spl_autoload_register(function ($class) {
    include '../classes/' . $class . '.class.php';
});



//  FUNCTIONS ===================================================================================
// Simulate a single attack name to add flavor to the combat.
function nameAttack(){
    $attacks = [
        "effectue un mawashigeri sur", 
        "frappe très fort", 
        "défonce le visage de", 
        "dégomme les côtes de",
        "démonte les genoux de ", 
        "casse les dents de", 
        "délivre un immense crochet du menton a", 
        "attrape la table basse et l'énfonce dans", 
        "fait une pichenette vigoureuse sur l'oreille de", 
        "fait une brulûre indienne a", 
        "insulte violemment", 
        "étale du piment dans les yeux de",
        "joue l'intégrale de Claude Barzotti sur une enceinte géante devant",
        "lance du café brûlant sur", 
        "raconte une histoire sordide a",
    ];
    $i = rand(0, sizeof($attacks)-1);
    return $attacks[$i];
}

// Simulate a single attack from an opponent to the other, and use a dice to do it.
function singleAttack($attacker, $target, $dice)
{
    $attacker->setAttackDamageValue($dice->rollDice());
    $attacker->attackOpponent($target);
}


//simulate the whole fight between two opponents.
// TODO : comment stages of the combat and clean that stuff. I'ts messy.
function fight($fighterA, $fighterB, $dice)
{   

    echo "<p class='result'> $fighterA [$fighterA->class] VERSUS $fighterB [$fighterB->class] </p>";

    $isKO = false;
    while (!$isKO) {
        // Init and force test. Will define who start first and define force of the action.
        $fighterA->setForce($dice->rollDice());
        $fighterB->setForce($dice->rollDice());
        echo "<round>";

        // WIll choose who starts, simulate an attach and display a descriptive message.
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
        //Gives the result of a round OR give the result of the whole fight at the end if there is a KO.
        if ($fighterA->getLife() <= 0 or $fighterB->getLife() <= 0) {
            $isKO = true;
            if ($fighterA->getLife() <= 0) {
                echo "<p class='final'>" . $fighterA->getName() . " n'est plus en mesure de se battre, " . $fighterB->getName() . " est le vainqueur.</p>";
            }
            if ($fighterB->getLife() <= 0) {
                echo "<p class ='final'>" . $fighterB->getName() . " n'est plus en mesure de se battre, " . $fighterA->getName() . " est le vainqueur.</p>";
            }
        } else {
            echo "<p class='result'>" . $fighterA->getName() . " a  " . $fighterA->getLife()  . " points de vie et " . $fighterB->getName() . " a " . $fighterB->getLife() . " points de vie.</p>";
        }
        echo "</result>";
    }
}


    // Instantiates new characters with data from the database. (Lifepoints, fighter classes ect.)
    function newCharacters($opponent_data_from_dbb, $new_character_instance_name){

        if($opponent_data_from_dbb[0]->class == "warrior"){
            $new_character_instance_name = new Warrior($opponent_data_from_dbb);
            $new_character_instance_name->setLife($opponent_data_from_dbb[0]->life);
            $new_character_instance_name->setAvatar($opponent_data_from_dbb[0]->setAvatar);
        }
        if($opponent_data_from_dbb[0]->class == "archer"){
            $new_character_instance_name = new Archer($opponent_data_from_dbb);
            $new_character_instance_name->setLife($opponent_data_from_dbb[0]->life);
            $new_character_instance_name->setAvatar($opponent_data_from_dbb[0]->setAvatar);
        }
        if($opponent_data_from_dbb[0]->class == "wizard"){
            $new_character_instance_name = new Wizard($opponent_data_from_dbb);
            $new_character_instance_name->setLife($opponent_data_from_dbb[0]->life);
            $new_character_instance_name->setAvatar($opponent_data_from_dbb[0]->setAvatar);
        }
    }


// Début de partie =======================================================================================================================
//======================================================================================================================================


// ERROR : displays the message If the player entered the arena without choosing opponent.
if( $_GET["opponent1"] == '' || $_GET["opponent2"]  == '' ){
    echo"Choose a personnage to play <br>";
}

// ERROR :displays a message if the player made a character fight iteself.
else if ( $_GET["opponent1"] == $_GET["opponent2"]){
    echo "Suicide is a very bad idea, call for help. <br>";
}

// GO : starts the procedure of preparation and execution of the fight.
else {


    // Nouvelle instance de DATABASE
    $database = new Database("localhost", "root", "combat_dices", "root");
    $database->connect();

    // Récupère les noms des combattants a inclure dans le combat depuis le formulaire.
    $opponent_1_name = $_GET["opponent1"];
    $opponent_2_name = $_GET["opponent2"];


    // PREMIER PERSONNAGE: Query des data du personnage
    $preReq = $database->prepReq("SELECT point_vie FROM personnage WHERE name ='$opponent_1_name'");
    $opponent_1_data = $database->fetchdata(PDO::FETCH_OBJ);

    // SECOND PERSONNAGE: Query des data du personnage
    $preReq = $database->prepReq("SELECT point_vie FROM personnage WHERE name ='$opponent_2_name'");
    $opponent_1_data = $database->fetchdata(PDO::FETCH_OBJ);

    ?>

<!-- Inclusion de la feuille de style. -->
    <link rel="stylesheet" href="../style/index.css">


    <!-- ARENA, where fighters come to die -->
    <section class="arena">
        <?php
        // Instanciation d'un dé de jeu
        $d6 = new Dice(6);

        //  nouvelles instances pour les deux personnages et hydratation depuis la BDD.
        newCharacters($opponent_1_data,$opponent_A);
        newCharacters($opponent_2_data,$opponent_B);

        // Combat automatique des deux instances de personnage.
        fight($opponent_A, $opponent_B, $d6);
        ?>
    </section>




    <?php
    //Gets opponents life to update the BDD at the end of the fight
    $opponent_A_currentLife = $opponent_A->getLife();
    $opponent_B_currentLife = $opponent_B->getLife();

    // ============ UPDATE DE DES COMBATTANTS ( DEBUT ) ============ 

    //  Commented to work ok style 
    // TODO: reactivate it before leaving.

    // $preReq = $database->prepReq("UPDATE personnage SET point_vie = '$opponent_A_currentLife' WHERE name = '$opponent_1_name'");
    // $preReq = $database->prepReq("UPDATE personnage SET point_vie = '$opponent_B_currentLife' WHERE name = '$opponent_2_name'");
    // $prepReq = $database->prepReq("DELETE FROM personnage WHERE point_vie <= 0");
    // $preReq = $database->prepReq("UPDATE personnage SET point_vie = (point_vie + 25) WHERE point_vie < 100");

}    // ============ UPDATE DE DES COMBATTANTS ( FIN ) ============

    ?>

<script src="../vendor/gsap.min.js"></script>
<script src="../scripts/arena.js"></script>
<a href="/">Retour à l'accueil</a>