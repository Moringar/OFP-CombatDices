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

    function generateSelect()
    {
        echo "<select name=$this->name>";
        foreach ($this->options as $option) {
            echo $option;
        }
        echo "</select>";
    }

}
