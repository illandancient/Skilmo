<?php
session_start();
echo "<html>\n<head>\n    <title>Checkboxes</title>\n";

include 'heading.inc';
?>


<?php
/*   Program name: checklist.php
 *   Description:  Script displays a form
 */
 
include 'dbstuff.inc';
if(@$_SESSION['auth'] != "yes")
   {
       include("form_checkbox.inc");
   }
   else
   {
       include("form_loggedin_checkbox.inc");
   }

?>

<?php
include 'footing.inc';
?>