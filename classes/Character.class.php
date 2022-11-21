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

    function setForce($forceRoll){
        $this->force = $forceRoll;
    }

    function setAttackDamageValue($attackRoll){
        $this->attackDamageValue = $attackRoll * $this->force;
    }

    function attackOpponent($opponent){
        $opponent->lifePoints -= $this->attackDamageValue;
    }

}
?>