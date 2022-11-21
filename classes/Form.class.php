<?php 
class Form{

    private $form_method;
    private $form_action;

    private $fields = [];

    /**
     * @param $actionField define the method used by the form.
     * @param $methodField defines the action, the page the data will be sent to when it's submitted.
     */
    function __construct($actionField, $methodField)
    {
        $this->form_action = $actionField;
        $this->form_method = $methodField;
    }

    public function createField($fieldPublicName, $fieldName, $placeholder){
        $this->fields[] = "<label for=$fieldName>$fieldPublicName</label> 
        <input type='text' name=$fieldName placeholder=$placeholder>";

    }

    public function createSubmitButton($buttonName){
        $this->fields[]= "<input type='submit' value=$buttonName>";
    }



    public function generateForm(){
        echo "<form action='$this->form_action'method='$this->form_method' >";

            foreach($this->fields as $field){
                echo $field;
            }

        echo "</form>";
    }
}

?>