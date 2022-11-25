<?php

class Archer extends Character{

    public $class = "Archer";
    
    public function setLife($lifePoints){
        // Si le lancé de force de l'aecher est un 6 critique, il esquive TOTALEMENT l'attaque.
        if($this->force == 6){
            $this->lifePoints = $this->lifePoints ;
        }
        else{
            $this->lifePoints = $lifePoints;
        }
    }

    public function setAttackDamageValue($attackRoll){


        if($attackRoll == 6){
            $this->attackDamageValue = $attackRoll * ($this->force * 2);
        }
        // Si echec critique, l'archer rate totalement.s
        elseif($attackRoll == 1){
            $this->attackDamageValue = $attackRoll * 0;
        }
        else{
            $this->attackDamageValue = $attackRoll * $this->force;
        }
        
    }

}