<?php

class Warrior extends Character{

    public $class = "Warrior";

    public function setLife($lifePoints){

        // Si lors de ce tour, la valeur du dé de force est un 6(critique),son organisme est plus résistant. Dégats divisés par deux.
        if($this->force == 6){
            $this->lifePoints = $lifePoints / 2 ;
        }
        else{
            $this->lifePoints = $lifePoints;
        }
    }

    public function setAttackDamageValue($attackRoll){

        // Si son attaque est un 6critique, le guerrier bénéficie d'une préparation d'attaque doublée.
        if($attackRoll == 6){
            $this->attackDamageValue = $attackRoll * ($this->force * 2);
        }
        // Si echec critique, dégat divisés par deux.
        elseif($attackRoll == 1){
            $this->attackDamageValue = $attackRoll *( $this->force / 2);
        }
        else{
            $this->attackDamageValue = $attackRoll * $this->force;
        }
        
    }

}