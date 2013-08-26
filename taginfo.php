<?php
session_start();
echo "<html>\n<head>\n    <title>Information about tag</title>\n";
include 'heading.inc';

?>


<?php
 
include 'dbstuff.inc';


$tagid = $_GET['tag'];

if (!is_numeric($tagid)) {
        $tagid = 2;
}

$tagquery = " SELECT TagName, TagDescription from taglist WHERE ID = $tagid ";

/* Defines SQL query that gets list of all skills
   with the current tag, and the more recent photo
   for each skill and the number of users for each skill
*/
$tagskillquery = "SELECT I.MPhotoID, skilltag.SkillID, skilllist.Name, 
skilllist.Description, rankedpopskills.Usercount
FROM skilltag
LEFT JOIN (SELECT MAX(images.PhotoID) AS MPhotoID, SkillID FROM images GROUP BY images.SkillID) AS I 
ON skilltag.SkillID = I.SkillID
LEFT JOIN skilllist ON skilltag.SkillID = skilllist.SkillID
LEFT JOIN rankedpopskills ON skilltag.SkillID = rankedpopskills.ID
WHERE skilltag.TagID = $tagid
ORDER BY rankedpopskills.Usercount DESC
LIMIT 0, 30 ";


if ($result = mysqli_query($cxn,$tagquery)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        $tagname = $row[0];
        $tagdescription = $row[1];
        echo "<div class='stitchpatch'>\n    <h2>$tagname</h2>$tagdescription\n</div>\n<br>\n";
    }
    /* free result set */
    $result->close();

}

if ($result = mysqli_query($cxn,$tagskillquery)) {
    echo "<div class='stitched'>\n    <table><tr><th width=110></th><th colspan=2></th></tr>\n";
    /* fetch object array */
    while ($srow = $result->fetch_row()) {
        $photoid = $srow[0];
        $skillid = $srow[1];
        $skillname = $srow[2];
        $skilldescription = $srow[3];
        $usercount = $srow[4];
        $photofilename = "images/$photoid.jpg";

        if ($photoid > 0) {
            echo "<tr><td rowspan=2 align=center style='vertical-align:middle'>\n";
            echo "<a href='skillinfo.php?skill=$skillid'>\n";
            echo "<img src='resize.php?w=100&img=$photofilename' /></a></td>\n";
        }
        else {
            echo "<tr><td rowspan=2>No photo yet</td>\n";
        } 
        echo "<td><p class='skillname'><a href='skillinfo.php?skill=$skillid'>$skillname</a></p></td>\n";
        if ($usercount >0) {
            echo "<td><p class='points'>$usercount</p></td></tr>\n";
        }
        else {
            echo "<td><p class='points'>0</p></td></tr>\n";
        } 
        echo "<tr><td><p class='desc'>$skilldescription</p></td><td><p class='desc'>USERS</p></td></tr>\n";
    }

    /* free result set */
    $result->close();
    echo "    </table>\n</div>\n";
}

?>

<?php
include 'footing.inc';
?>