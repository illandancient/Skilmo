<?php
session_start();
echo '<html><head><title>Menu of skills</title></head>';
include 'heading.inc';
 
include 'dbstuff.inc';


$query = "SELECT SkillID, Name FROM skilllist ORDER BY Name ";


echo '<p>Here\'s a list of all the skills that you get points for, click on them for more information</p></p>';
echo '<table cellpadding="0" cellspacing="0">';
echo '<tr><th>Name</th></tr>';
		
if ($result = mysqli_query($cxn,$query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<tr><td><a href=\"skillinfo.php?skill=%s\"> %s </a></td></tr>", $row[0], $row[1]);
    }

    /* free result set */
    $result->close();
}

?>

<?php
include 'footing.inc';
?>