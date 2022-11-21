<?php 
class Dice{
    
    public $faces;

    function __construct($faces){
        $this->faces = $faces;
    }

    function rollDice(){
        return rand(1,$this->faces);
    }

}
?>