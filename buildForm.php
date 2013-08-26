<?php
/* Script name: buildForm
 * Description: Uses the form to create a simple HTML form
 */
require_once("Form.class");
echo "<html><head><title>Phone form</title></head><body>";
$phone_form = new form("process.php", "Submit Phone");
$phone_form->addField("first_name", "First Name");
$phone_form->addField("last_name", "Last Name");
$phone_form->addField("phone", "Phone");
echo "<h3>Please fill out the following form:</h3>";
$phone_form->displayForm();
echo "</body></html>";
?>