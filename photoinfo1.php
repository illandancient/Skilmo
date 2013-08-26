<?php
session_start();
echo '<html><head><title>Information about Photo </title></head>';
include 'heading.inc';
 
include 'dbstuff.inc';

$imageid = $_GET['image'];

if (!is_numeric($imageid)) {
        $imageid = 24;
}

$photofilename = "images/$imageid.jpg";
$imagevotequery = "SELECT images.PhotoID, images.UserID, userlist.UserName, images.SkillID, "
                . " skilllist.Name, images.DateAdded, OC.OCC FROM images LEFT JOIN userlist "
                . " ON images.UserID = userlist.UserID LEFT JOIN skilllist ON images.SkillID "
                . " = skilllist.SkillID LEFT JOIN (SELECT uservote.ObjectID, "
                . " COUNT(uservote.VoteType) AS OCC FROM uservote WHERE ObjectType = 'image' "
                . " GROUP BY ObjectID) AS OC ON images.PhotoID = OC.ObjectID "
                . " WHERE images.PhotoID = '$imageid'";

if ($result = mysqli_query($cxn, $imagevotequery)) {
    while ($imageinfo = $result->fetch_row()) {
        $imageuserid = $imageinfo[1];
        $imageusername = $imageinfo[2];
        $imageskillid = $imageinfo[3];
        $imageskillname = $imageinfo[4];
        $imagedateadded = $imageinfo[5];
        $imagevotes = $imageinfo[6];

        echo "<div id='container'>\n";
        echo "<h2><a href='/skillinfo.php?skill=$imageskillid'>$imageskillname</a> by "
           . "<a href='/userinfo.php?user=$imageuserid'>$imageusername</a></h2>\n";
        echo "<div align='center'><img src='resize.php?w=600&img=$photofilename' /><br>\n";
        
        if(@$_SESSION['auth'] == "yes") {
            $userid=$_SESSION['userid'];
            echo "<div style='display:inline-block'>\n";
            echo "<form name='input' action='voteaction.php' method='post'>\n"
               . "<input type='hidden' name='userid' value='$userid'>\n"
               . "<input type='hidden' name='objecttype' value='image'>\n"
               . "<input type='hidden' name='objectid' value='$imageid'>\n"
               . "<input type='hidden' name='votetype' value='up'>\n"
               . "<input type='submit' value='Up vote' style='height: 25px; width: 100px'></form>\n";
            echo "</div><div style='display:inline-block'>\n";
            echo "<form name='input' action='voteaction.php' method='post'>\n"
               . "<input type='hidden' name='userid' value='$userid'>\n"
               . "<input type='hidden' name='objecttype' value='image'>\n"
               . "<input type='hidden' name='objectid' value='$imageid'>\n"
               . "<input type='hidden' name='votetype' value='down'>\n"
               . "<input type='submit' value='Down vote' style='height: 25px; width: 100px'></form>\n";
            echo "</div>\n";
        }
        echo "</div>\n";
        echo "<div id='popular'>Added $imagedateadded</div>\n";
        echo "<div id='esoteric'>$imagevotes votes</div>\n";

        echo "</div>\n";
        
    }
    /* free result set */
    $result->close();
    echo "<br>";
}

include 'footing.inc';

?>