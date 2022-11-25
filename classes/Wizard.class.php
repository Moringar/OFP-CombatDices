<?php

class Wizard extends Character{

    public $class = "Wizard";

    function setLife($lifePoints){
            $this->lifePoints = $lifePoints;

    }

    function setAttackDamageValue($attackRoll){

            if($attackRoll%2 == 1){
                // attaque impair
                $this->attackDamageValue = $attackRoll * ($this->force *2);

            }
            else{
                // attaque pair
                $this->attackDamageValue = $attackRoll * $this->force;
            }


        
    }
}