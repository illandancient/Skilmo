<?php
session_start();
?>
<html><head><title>SKILMO Home</title>

<?php

include 'heading.inc';

?>

</head>

<?php
 
include 'dbstuff.inc';

/* Top of page */

echo "<h2>Hello and welcome to SKILMO - <a href='checklist.php'>Register here</a></h2>\n\n";

$numusersquery = "SELECT COUNT(DISTINCT `UserID`) FROM userskill";

/*  Counts and displays total number of users / members who have completed the checklist page */

if ($numusersmush = mysqli_query($cxn, $numusersquery)) {
    while ($numusers = ($numusersmush->fetch_row())) {
       echo "<p class='user-counter'>Total members:- $numusers[0] </p>\n\n";
    }
    $numusersmush->close();
}

echo "<div id='container'>\n<div id='popular'>\n\n";

/* Top skills */
/* Defines the SQL query that selects the most popular skills, 
   number of users and the most recently 
   submitted photo for that skill. Only selects that top 
   six skills, was previously top ten and previously top 
   five. Keep changing it depending on how the layout looks
*/
$top10skillquery = "SELECT I.MPhotoID, skilllist.SkillID, skilllist.Name,
    rankedpopskills.UserCount, skilllist.Description, skilllist.DateAdded
    FROM skilllist
    LEFT JOIN (SELECT MAX(images.PhotoID) AS MPhotoID, SkillID FROM images
    GROUP BY images.SkillID) AS I ON skilllist.SkillID = I.SkillID
    LEFT JOIN rankedpopskills ON skilllist.SkillID = rankedpopskills.ID
    ORDER BY rankedpopskills.UserCount DESC
    LIMIT 6";

/* Based on whether the query returns anything, a table is 
   built up to display the top skills using various multi-span
   columns and rows
*/
if ($top10skills = mysqli_query($cxn,$top10skillquery)) {
    echo "The most popular skills listed are:-</p>\n";
    echo "<table><tr><th width=110></th><th colspan=2></th></tr>\n";
    /* fetch object array */
    while ($row = $top10skills->fetch_row()) {
        /* Give nice names for the columns in the SQL result
        */
        $photoid = $row[0];
        $photofilename = "images/$photoid.jpg";
        $skillid = $row[1];
        $skillname = $row[2];
        $skillusercount = $row[3];
        /* Calculates score for skill based on number of users
        If there's only one user, its worth six points, if only
        two users then four points, else 2 points
        */
        switch ($skillusercount) {
            case 0:
            case 1:
                $score = 6;
                break;
            case 2:
                $score = 4;
                break;
            default:
                $score = 2;
                break;
        }
        $skilldesc = $row[4];
        $dateadded = $row[5];

        if ($row[0]) {
            echo "<tr><td rowspan=3 align=center style='vertical-align:middle'>\n";
            echo "<a href='skillinfo.php?skill=$skillid'>\n";
            echo "<img src='resize.php?w=100&img=$photofilename' /></a></td>\n";
        }
        else {
            echo "<tr><td rowspan=3>No photo yet</td>\n";
        } 
        echo "<td><p class='skillname'><a href='skillinfo.php?skill=$skillid'>$skillname</a></p></td>\n";
        echo "<td rowspan=2><p class='points'>$score</p></td></tr>\n";
        echo "<tr><td><p class='desc'>$skilldesc</p></td></tr>\n";
        echo "<tr><td><p class='desc'>$skillusercount users - Added $dateadded</p></td><td><p class='desc'>POINTS</p></td></tr>\n";

    }
    /* free result set */
    $top10skills->close();
    echo "</table>\n";
}

echo "</div>\n\n";

echo "<div id='esoteric'>";

/* Bottom skills */

$bottom10skillquery = "SELECT images.PhotoID, skilllist.SkillID, skilllist.Name,\n"
    . " rankedpopskills.UserCount, skilllist.Description, skilllist.DateAdded\n"
    . " FROM skilllist\n"
    . " LEFT JOIN images ON skilllist.SkillID = images.SkillID\n"
    . " LEFT JOIN rankedpopskills ON skilllist.SkillID = rankedpopskills.ID\n"
    . " WHERE rankedpopskills.UserCount >0\n"
    . " ORDER BY rankedpopskills.UserCount ASC\n"
    . " LIMIT 5";

if ($bottom10skills = mysqli_query($cxn,$bottom10skillquery)) {
    echo "The most esoteric skills listed are:-</p>\n";
    echo "<table><tr><th width=110></th><th colspan=2></th></tr>\n";
    /* fetch object array */
    while ($row = $bottom10skills->fetch_row()) {
        $photoid = $row[0];
        $photofilename = "images/$photoid.jpg";
        $skillid = $row[1];
        $skillname = $row[2];
        $skillusercount = $row[3];
        switch ($skillusercount) {
            case 0:
            case 1:
                $score = 6;
                break;
            case 2:
                $score = 4;
                break;
            default:
                $score = 2;
                break;
        }
        $skilldesc = $row[4];
        $dateadded = $row[5];

        if ($row[0]) {
            echo "<tr><td rowspan=3 align=center style='vertical-align:middle'><a href=$photofilename>\n";
            echo "<img src='resize.php?w=100&img=$photofilename' /></a></td>\n";
        }
        else {
            echo "<tr><td rowspan=3>No photo yet</td>\n";
        } 
        echo "<td><p class='skillname'><a href='skillinfo.php?skill=$skillid'>$skillname</a></p></td>\n";
        echo "<td rowspan=2><p class='points'>$score</p></td></tr>\n";
        echo "<tr><td><p class='desc'>$skilldesc</p></td></tr>\n";
        echo "<tr><td><p class='desc'>$skillusercount users - Added $dateadded</p></td><td><p class='desc'>POINTS</p></td></tr>\n";

    }
    /* free result set */
    $bottom10skills->close();
    echo "</table>\n";
}

echo "</div></div><br>\n\n";

echo "<div id='container'>\n<div id='popular'>\n\n";

/* Recently added skills */

$recentskillsquery = "SELECT SkillID, Name, DateAdded FROM `skilllist` ORDER BY `skilllist`.`DateAdded`  DESC LIMIT 10";

if ($recentskills = mysqli_query($cxn,$recentskillsquery)) {

    echo "The most recent skills added are:-</p>\n";

    /* fetch object array */
    while ($row = $recentskills->fetch_row()) {
        printf ("<a href='skillinfo.php?skill=%s'>%s</a> - added %s <br>\n", $row[0], $row[1], $row[2]);

    }
    /* free result set */
    $recentskills->close();
    echo "<br>\n";
}

echo "</div>\n\n";

echo "<div id='esoteric'>";

/* Top users */

$topusersquery = " SELECT GO.UserID, Go.UserName, SUM(Go.Score) AS TotalScore 
FROM (SELECT userskill.UserID, userlist.UserName, 
userskill.SkillID, skilllist.Name, skillusercount.UserCount, 
CASE skillusercount.UserCount 
WHEN skillusercount.UserCount = '1' THEN 6 
WHEN skillusercount.UserCount = '2' THEN 4 
ELSE 2 
END AS Score 
FROM userskill 
LEFT JOIN skillusercount ON userskill.SkillID = 
skillusercount.SkillID 
LEFT JOIN skilllist ON userskill.SkillID = skilllist.SkillID 
LEFT JOIN userlist ON userskill.UserID = userlist.UserID) AS GO 
WHERE Go.UserName IS NOT NULL
GROUP BY Go.UserID 
ORDER BY TotalScore DESC
LIMIT 10";

if ($topusers = mysqli_query($cxn,$topusersquery)) {
    echo "Most broadly-skilled users:-</p>\n";
    $rank = 1;
    /* fetch object array */
    while ($row = $topusers->fetch_row()) {

        $UserID = "$row[0]";
        $UserName = "$row[1]";
        $Score = "$row[2]";
        echo "<a href='userinfo.php?user=$UserID'>$rank . $UserName - $Score points</a><br>\n";
        $rank += 1;
 
    }
    /* free result set */

    $topusers->close();
    echo "<br>\n";
}

echo "</div></div><br>\n\n";

echo "<div id='container'>\n<div id='popular'>\n";

/* No user skills */

$nousersyet = "SELECT `SkillID`, `Name` FROM `skilllist` WHERE SkillID NOT IN (SELECT SkillID FROM userskill) ORDER BY Name";

if ($nousers = mysqli_query($cxn,$nousersyet)) {
    echo "Skills that no one has logged yet:-</p>\n";
    /* fetch object array */
    while ($row = $nousers->fetch_row()) {
        printf ("<a href='skillinfo.php?skill=%s'>%s</a><br>\n", $row[0], $row[1]);
    }
    /* free result set */
    $nousers->close();
    echo '</p>';
}
echo "</div>\n\n";
echo "<div id='esoteric'>\n";

/* New images */

$photoidquery = "SELECT * FROM images ORDER BY DateAdded DESC LIMIT 5";
if ($result = mysqli_query($cxn, $photoidquery)) {
    echo "Latest photos uploaded:-</p>\n";
    while ($row = $result->fetch_row()) {
        $photoid = $row[0];
        $AddedBy = $row[1];
        $userid = $row[2];
        $SkillName = $row[3];
        $SkillID = $row[4];
        $photofilename = "images/$photoid.jpg";

        echo "<a href='photoinfo.php?image=$photoid'><img src='resize.php?w=250&img=$photofilename' alt='$SkillName by $AddedBy' /></a><br>\n";
        echo "<a href='skillinfo.php?skill=$SkillID'>$SkillName</a> by <a href='userinfo.php?user=$userid'>$AddedBy</a><br><br>\n";
    }
    /* free result set */
    $result->close();
}

echo "</div></div>\n\n";

?>


<?php

include 'footing.inc';

?>