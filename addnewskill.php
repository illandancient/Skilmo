<?php
session_start();
if(@$_SESSION['auth'] != "yes")
{
    header("Location: index.php");
    exit();
}
echo "<html><head><title>Add new skill</title></head>";

include 'heading.inc';
?>

<?php
/*   Program name: addnewskill.php
 *   Description:  Adds new skill to database
 */
 
include 'dbstuff.inc';

$query = "SELECT DISTINCT ID, TagName FROM taglist ORDER BY TagName";
$result = mysqli_query($cxn, $query) or die ("Couldn't execute query");

echo "<h3>Add new skill</h3>\n";

echo "<form action='skilladded.php' method='POST'>";
echo "<div id='container'><div id='popular'>";
echo "<fieldset><legend style='font_weight: bold'>Name and description</legend>";
echo "Skill name: <input type='text' name='SkillName'><br>";
echo "Description: <textarea name='Description' rows='5' cols='40'></textarea><br>\n";
echo "</fieldset></div>\n";

/* create form containing checkboxes for tags */
echo "<div id='esoteric'><fieldset><legend style='font_weight: bold'>Tags</legend>";
echo "<ul style='list-style: none'>\n";
while($row = $result->fetch_row()) {
   extract($row);
   echo "<li><input type='checkbox' name='$row[0]' 
              id='$row[0]' value='yes' />
              <label for='$row[1]'
              style='font-weight: bold'>$row[1]</label></li>\n";
}
echo "</ul></fieldset></div>\n";

/* submit button  */

echo "<p><input type='submit' value='Add skill' /></form></div>\n";

?>

<?php
include 'footing.inc';
?>