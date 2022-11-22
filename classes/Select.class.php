<?php

class Select
{

    private $name;
    private $options = [];

    function __construct($name)
    {
        $this->name = $name;
    }

    function createOptions($value)
    {
        $this->options[] = "<option value=$value>$value</option>";
    }

    function labelOption($labelName)
    {
        $this->options[] = "<option value=''> $labelName </option>";
    }
    function generateSelect()
    {
        echo "<select name=$this->name option value>";
        foreach ($this->options as $option) {
            echo "$option";
        }

        echo "</select>";
    }

}
