<?php

class Select
{

    private $name;
    private $options = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function createOptions($value)
    {
        $this->options[] = "<option value=$value>$value</option>";
    }

    public function labelOption($labelName)
    {
        $this->options[] = "<option value=''> $labelName </option>";
    }
    public function generateSelect()
    {
        echo "<select name=$this->name option value>";
        foreach ($this->options as $option) {
            echo "$option";
        }

        echo "</select>";
    }

}
