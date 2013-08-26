<?php
session_start();
echo "<html><head><title>User information</title>\n";
include 'heading.inc';

?>

<?php
 
include 'dbstuff.inc';

$puserid = $_GET['user'];
echo "    </br>\n",
     "    <div class='stitchpatch' style='width: 90%'>\n",
     "        <div id='popular'>\n";
if (!is_numeric($puserid)) {

    echo "invalid userid<br>",
         "so here's illandancient's page";
    $puserid = 1;
}
$usernamequery = " SELECT UserName from userlist WHERE UserID = '$puserid' ";

/* Defines SQL query for main table on page, selecting all
   the skills that the user can do, their most recent photo 
   for those skills, and calculating the score for each skill
*/
$awesomenessquery = "SELECT I.MPhotoID, U.SkillID, skilllist.Name, T.SkillCount, CASE SkillCount 
     WHEN SkillCount = '1' THEN 6 
     WHEN SkillCount = '2' THEN 4 
     ELSE 2 END AS Score, U.DateAdded 
     FROM (SELECT UserID, SkillID, DateAdded FROM userskill WHERE UserID = '$puserid') 
     AS U
LEFT JOIN (SELECT SkillID, COUNT(SkillID) AS SkillCount FROM userskill 
     GROUP BY SkillID) AS T ON T.SkillID = U.SkillID

LEFT JOIN (SELECT MAX(images.PhotoID) AS MPhotoID, images.SkillID, images.UserID FROM images
    WHERE images.UserID = '$puserid'
    GROUP BY images.SkillID) AS I
     ON U.SkillID = I.SkillID

LEFT JOIN skilllist ON skilllist.SkillID = U.SkillID 
     ORDER BY U.DateAdded DESC";


$userscorequery = "SELECT SUM(GO.Score) AS TotalScore "
    . " FROM (SELECT userskill.UserID, userskill.SkillID, skillusercount.UserCount, "
    . " CASE skillusercount.UserCount "
    . " WHEN skillusercount.UserCount = '1' THEN 6 "
    . " WHEN skillusercount.UserCount = '2' THEN 4 "
    . " ELSE 2 "
    . " END AS Score "
    . " FROM userskill "
    . " LEFT JOIN skillusercount ON userskill.SkillID = skillusercount.SkillID) AS GO "
    . " WHERE GO.UserID = '$puserid'";

if ($result = mysqli_query($cxn,$usernamequery)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("            <h2> %s </h2>", $row[0]);
    }
    /* free result set */
    $result->close();
}
else {
    echo "This user left no name</br>\n";
}

$userscore = mysqli_query($cxn, $userscorequery) ;
$userscore = $userscore->fetch_row() ;
$userscore = $userscore[0];
echo "$userscore SKILMO POINTS\n",
     "        </div>\n";

if(@$_SESSION['auth'] == "yes" && @$_SESSION['userid'] == $puserid)
{
    echo "        <div id='esoteric'>\n",
         "            <a href='/uploadphoto.php'>Upload photos</a><br>\n",
         "            <a href='/addnewskill.php'>Add new skill to database</a>\n",
         "        </div>\n";
}

echo "</div>\n",
     "<br>\n",
     "<div class='stitched'>\n\n";
if ($result = mysqli_query($cxn,$awesomenessquery)) {
    echo "    <table cellpadding='5' cellspacing='5'>\n";
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        if ($row[0]) {
            $photoid = $row[0];
            $skillid = $row[1];
            $skillname = $row[2];
            $otherusers = $row[3];
            $skillscore = $row[4];
            $photofilename = "images/$photoid.jpg";

            echo "        <tr><th></th><th colspan=2></th></tr>\n",
                 "        <tr><td rowspan=2 align=center style='vertical-align:middle'>\n",
                 "        <a href='photoinfo.php?image=$photoid'>\n",
                 "        <img src='resize.php?w=250&img=$photofilename'",
                 "alt='$SkillName by $AddedBy' /></a></td>\n",
                 "        <td><p class='skillname'><a href='skillinfo.php?skill=$skillid'>",
                 "$skillname</a></p></td>\n",
                 "        <td><p class='points'>$skillscore</p></td>\n",
                 "        <td><p class='points'>$otherusers</p></td></tr>\n",
                 "        <tr><td></td><td><p class='desc'>POINTS</p></td>\n",
                 "        <td><p class='desc'>USERS</p></td></tr>\n\n";
        }
        else {
            $skillid = $row[1];
            $skillname = $row[2];
            $otherusers = $row[3];
            $skillscore = $row[4];

            echo "        <tr><th></th><th colspan=2></th></tr>\n",
                 "        <tr><td rowspan=2 align=center style='vertical-align:middle'>No photo</td>\n",
                 "        <td><p class='skillname'><a href='skillinfo.php?skill=$skillid'>",
                 "$skillname</a></p></td>\n",
                 "        <td><p class='points'>$skillscore</p></td>\n",
                 "        <td><p class='points'>$otherusers</p></td></tr>\n",
                 "        <tr><td></td><td><p class='desc'>POINTS</p></td>\n",
                 "        <td><p class='desc'>USERS</p></td></tr>\n\n";
        }
    }

    /* free result set */
    $result->close();
    echo "    </table>\n",
         "    <br>\n";
}
echo "</div>\n";
include 'footing.inc';

?>