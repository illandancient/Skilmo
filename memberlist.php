<?php
session_start();
?>
<html>
<head>
    <title>SKILMO Member list</title>
<?php
include 'heading.inc';
?>
</head>

<?php
 
include 'dbstuff.inc';

/* nice stitched box for the memberlist */
echo "<div class='stitched'>";

/* Top users */

$alphausersquery = "SELECT UserID, UserName, DATE_FORMAT( DateAdded,  '%d %b %Y' ) "
                 . "FROM userlist ORDER BY UserName ASC ";

if ($userlist = mysqli_query($cxn,$alphausersquery)) {
    echo "Members:-</p>\n";
    /* fetch object array */
    while ($row = $userlist->fetch_row()) {
        $UserID = "$row[0]";
        $UserName = "$row[1]";
        $DateJoined = "$row[2]";
        echo "<div class='stitchpatch' style='width: 90%;'>\n",
             "    <p class='alignleft'><a href='userinfo.php?user=$UserID'>$UserName</a></p>\n", 
             "    <p class='alignright'>Joined $DateJoined</p>\n",
             "<div style='clear: both;'></div>\n";
        $userskillsquery = "SELECT skilllist.SkillID, skilllist.Name "
                         . "FROM (SELECT SkillID FROM userskill WHERE UserID = $UserID) "
                         . "AS U "
                         . "LEFT JOIN skilllist ON skilllist.SkillID = U.SkillID "
                         . "WHERE skilllist.Name IS NOT NULL "
                         . "ORDER BY skilllist.Name";
        if ($skilllist = mysqli_query($cxn,$userskillsquery)) {
            echo "<div class='skillslist'>\n";
            while ($srow = $skilllist->fetch_row()) {
                $SkillID = "$srow[0]";
                $SkillName = "$srow[1]";
                echo "<a href='skillinfo.php?skill=$SkillID'>$SkillName, </a>\n";
            }
            $skilllist->close();
            echo "</div><br>\n";
        }
        echo "</div>\n";   
     }
    /* free result set */
    $userlist->close();
    echo "</div><br>\n";
}

echo "</div>\n</div>\n<br>\n\n";
echo "</div>\n</div>\n\n";

include 'footing.inc';

?>