<?php
session_start();
echo "<html>\n<head>\n\n    <title>Information about skill </title>\n";
include 'heading.inc';

 
include 'dbstuff.inc';

$skillid = $_GET['skill'];

if (!is_numeric($skillid)) {
        $skillid = 2;
}


$skillquery = " SELECT Name, Description from skilllist WHERE SkillID = $skillid ";
$tagquery = " SELECT ID, TagName FROM taglist WHERE ID IN (SELECT TagID FROM skilltag WHERE SkillID = $skillid ) ";

echo "    <div id='container'>\n";

if ($result = mysqli_query($cxn,$skillquery)) {
    
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo "        <h2>$row[0] </h2>\n",
             "        <div id='popular'>\n            $row[1]\n        </div>\n";
    }
    /* free result set */
    $result->close();
    echo "        <br>\n";
}


if ($result = mysqli_query($cxn,$tagquery)) {
    echo "        <div id='esoteric'>\n";
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo "            <a href='taginfo.php?tag=$row[0]'>$row[1]</a> <br>\n";
    }

    /* free result set */
    $result->close();
    echo "        </div>\n";
}
echo "    </div>\n    <br>\n\n";


if(@$_SESSION['auth'] == "yes") {
    echo "    <div id='container'>\n";
    $userid = @$_SESSION['userid'];
    $havethisskillsql = "SELECT UserID, SkillID FROM userskill WHERE UserID = $userid AND SkillID = $skillid ;";
    $result = mysqli_query($cxn, $havethisskillsql);
    if (mysqli_num_rows($result) > 0 ) {
        echo "        You can do this skill\n";
    }
    else {
        echo "        <form name='log_userskill' action='log_userskill.php' method='POST'>\n",
             "            <input type=hidden name=userid value=$userid>\n",
             "            <input type=hidden name=skillid value=$skillid>\n",
             "            <input type='submit' value='I can do this skill'>\n",
             "        </form>\n\n";
    }
    echo "    </div>\n    <br>\n";
}

/* Get and display photos */

$photoidquery = "SELECT * FROM images WHERE SkillID = $skillid";
if ($result = mysqli_query($cxn, $photoidquery)) {
    echo "    <div class='stitched'>\n";
    while ($row = $result->fetch_row()) {
        $photoid = $row[0];
        $AddedBy = $row[1];
        $AddedByID = $row[2];
        $SkillName = $row[3];
        $photofilename = "images/$photoid.jpg";

        echo "        <a href='photoinfo.php?image=$photoid'>\n",
             "        <img src='resize.php?w=250&img=$photofilename' alt='$SkillName by $AddedBy' />\n",
             "        </a><br>\n";

        echo "        $SkillName by <a href='userinfo.php?user=$AddedByID'>$AddedBy</a><br>\n";
    }
    /* free result set */
    $result->close();
    echo "    </div>\n    <br>\n";
}

include 'footing.inc';

?>