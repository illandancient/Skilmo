<?php
session_start();
echo "<html>\n<head>\n    <title>Menu of Tags</title>\n";
include 'heading.inc';

?>


<?php
 
include 'dbstuff.inc';


$query = "SELECT taglist.ID, skilltag.TagName FROM taglist, `skilltag` WHERE skilltag.TagName = taglist.TagName GROUP BY skilltag.TagName ORDER BY COUNT(skilltag.TagName) DESC";


$sql = "SELECT skilltag.TagID, taglist.TagName, taglist.TagDescription, COUNT(DISTINCT UserID) AS CU "
     . " FROM skilltag LEFT JOIN userskill ON skilltag.SkillID = userskill.SkillID "
     . " LEFT JOIN taglist ON skilltag.TagID = taglist.ID WHERE 1 GROUP BY skilltag.TagID "
     . "ORDER BY CU DESC, taglist.TagName ASC LIMIT 0, 30 ";



if ($result = mysqli_query($cxn,$sql)) {
    echo "<div class='stitched'>\n",
         "    Here's a list of all the categories and tags in the database:-</p></p>\n";
    echo '<table cellpadding="0" cellspacing="0">';
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        $tagid = $row[0];
        $tagname = $row[1];
        $tagdescription = $row[2];
        $usercount = $row[3];
        echo "<tr><td><p class='skillname'><a href='/taginfo.php?tag=$tagid'>$tagname</a></p></td></tr>\n";
        echo "<tr><td><p class='desc'>$tagdescription</p></td></tr>\n";
        echo "<tr><td align='right'><p class='desc'>$usercount users</p></td></tr>\n";
    }

    /* free result set */
    $result->close();
    echo "    </table>\n</div>\n";
}


include 'footing.inc';

?>