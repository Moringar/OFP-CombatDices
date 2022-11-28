<?php
abstract class Character{

    protected $name;
    protected $lifePoints;
    protected $force;
    protected $attackDamageValue;
    protected $avatar;

    function __construct($characterName)
    {
        $this->name = $characterName;
        
    }

    public abstract function setLife($lifePoints);

    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }

    public function setForce($forceRoll){
        $this->force = $forceRoll;
    }

    public abstract function setAttackDamageValue($attackRoll);

    public function getAttackDamageValue(){
        return $this->attackDamageValue;
    }

    public function getName(){
        return $this->name;
    }

    public function getForce(){
        return $this->force;
    }

    public function getLife(){
        return $this->lifePoints;
    }


    public function attackOpponent($opponent){
        $opponent->lifePoints -= $this->attackDamageValue;
    }

    public function isAlive (): bool {
        return false; // TODO
    }

}
?>