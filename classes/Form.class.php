<?php 
class Form{

    private $form_method;
    private $form_action;
    private $class;

    private $option = [];
    private $fields = [];

    /**
     * @param $actionField define the method used by the form.
     * @param $methodField defines the action, the page the data will be sent to when it's submitted.
     */
    function __construct($actionField, $methodField, $class = "")
    {
        $this->form_action = $actionField;
        $this->form_method = $methodField;
        $this->class = $class;
    }

    public function createField($type, $fieldPublicName, $fieldName, $placeholder){
        $this->fields[] = "<label class='hero' for=$fieldName>$fieldPublicName</label> 
        <input class='hero' type=$type name=$fieldName placeholder=$placeholder required>";

    }

    public function createRadio($name, $imageLink, $value){
        $this->fields[] = 
        "<label id=$name><input type='radio'hidden name=$name required value=$value > $imageLink </label>";

    }
            
    public function createSubmitButton($buttonName){
        $this->fields[] = "<input type='submit' value=$buttonName>";
    }

    public function openSection(){
        $this->fields[] = "<section>";
    }

    public function closeSection(){
        $this->fields[] = "</section>";
    }


    

    public function createOptions($value, $id)
    {
        $this->options[] = "<option value=$id>$value</option>";
    }


    public function generateSelect($name)
    {
        $this->fields[] = "<select name=$name option value>";

        foreach ($this->options as $option) {
            $this->fields[] = "$option";
        }

        $this->fields[] = "</select>";
    }


    public function generateForm(){
        echo "<form action='$this->form_action'method='$this->form_method' class=$this->class>";

            foreach($this->fields as $field){
                echo $field;
            }

        echo "</form>";
    }
}

?>