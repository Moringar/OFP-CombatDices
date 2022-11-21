<?php
class Character{

    private $name;
    public $lifePoints;
    private $force;
    private $attackDamageValue;



    function __construct($characterName)
    {
        $this->name = $characterName;
        $this->lifePoints = 100;
    }

    function setLife($lifePoints){
        $this->lifePoints = $lifePoints;
    }

    function setForce($forceRoll){
        $this->force = $forceRoll;
    }

    function setAttackDamageValue($attackRoll){
        $this->attackDamageValue = $attackRoll * $this->force;
    }

    function getAttackDamageValue(){
        return $this->attackDamageValue;
    }

    function getName(){
        return $this->name;
    }

    function getForce(){
        return $this->force;
    }

    function getLife(){
        return $this->lifePoints;
    }


    function attackOpponent($opponent){
        $opponent->lifePoints -= $this->attackDamageValue;
    }

}
?>