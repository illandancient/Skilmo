<?php
/* Class name:    Form
 * Description:   A class that creates a simple HTML form
 *                containing only text input fields. The
 *                class has 3 methods
 */
class form
{
	private $fields = array();   # contains names and labels
	private $actionValue;   # name of script to process form
	private $submit = "Submit Form";  # value on submit button
	private $Nfields = 0;  # number of fields added to the form
	
	/* Constructor: User passes in the name of the script where
	 * form data is to be sent ($actionValue) and the value to
	 * display on the submit button.
	 */
	function __construct($actionValue,$submit)
	{
		$this->actionValue = $actionValue;
		$this->submit = $submit;
	}
	
	/* Display form function. Displays the form.
	 */
	function displayForm()
	{
		echo "\n<form action='{$this->actionValue}'
					  method='POST'>\n";
		for ($j=1;$j<=sizeof($this->fields) ;$j++)
		{
			echo "<p style='clear: left; margin: 0; padding: 0; padding-top: 5px'>\n";
			echo "<label style='float: left; width: 20%'> {$this->fields[$j-1] ['label']}: </label>\n";
			echo "<input style='width: 200px' type='text' name='{$this->fields[$j-1] ['name']}'></p>\n";
		}
		echo "<input type='submit' value='{$this->submit}' style='margin-left: 25%; margin-top: 10px'>\n";
		echo "</form>";
	}
	
/* Function that adds a field to the form. The user needs to
 * send the name of the field and a label to be displayed
 */
	function addField($name, $label)
	{
		$this->fields[$this->Nfields] ['name'] = $name;
		$this->fields[$this->Nfields] ['label'] = $label;
		$this->Nfields = $this->Nfields + 1;
	}
}
?>