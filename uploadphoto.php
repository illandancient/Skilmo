<?php
session_start();
if(@$_SESSION['auth'] != "yes")
{
    header("Location: index.php");
    exit();
}

echo "<html><head><title>Upload a photo</title></head>";

include 'heading.inc';
?>


<?php
/*   Program name: uploadphoto.php
 *   Description:  Starts uploading a photo to server
 */

include 'dbstuff.inc';
$userid = $_SESSION['userid'];
$query = "SELECT P.SkillID, skilllist.Name FROM "
       . "(SELECT SkillID FROM userskill WHERE UserID = $userid ) AS P "
       . "LEFT JOIN skilllist ON skilllist.SkillID = P.SkillID "
       . "ORDER BY skilllist.Name ASC";
$result = mysqli_query($cxn, $query) or die ("Couldn't execute query");

echo "<div class='stitched'>\n    <h3>Add new photo</h3>\n",
     "    Please upload jpeg or jpg images that are less than 2 megabytes<br>\n";

echo "    <form action='photoadded.php' enctype='multipart/form-data' method='POST'>\n";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='2000000' />\n";
echo "Choose a file to upload: <input name='uploadedfile' type='file' /><br>\n\n";

echo "Select which of your skills this is an image of: <select name='skillid'>\n\n";

if ($result = mysqli_query($cxn,$query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        $skillid = $row[0];
        $skillname = $row[1];
        echo "<option value='$skillid'>$skillname</option>\n";
    }

    /* free result set */
    $result->close();
}
echo "</select><br>\n";
echo "<input type='hidden' name='userid' value='$userid' />\n";
echo "<input type='submit' value='Upload File' /></form>\n";
echo "</div>\n";
?>

<?php
include 'footing.inc';
?>