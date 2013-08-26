<?php
session_start();
if(@$_SESSION['auth'] != "yes")
{
    header("Location: index.php");
    exit();
}

/*   Program name: skilladded.php
 *   Description:  Adds new skill to database
 */
 
include 'dbstuff.inc';


$query = "SELECT DISTINCT ID, TagName FROM taglist ORDER BY TagName";
$result = mysqli_query($cxn, $query) or die ("Couldn't execute query");

$AddedBy = $_SESSION['userid'];
$Skill = $_POST['SkillName'];
$Desc = $_POST['Description'];
$Skill = stripslashes($Skill);
$Desc = stripslashes($Desc);
$Skill = mysqli_real_escape_string($cxn, $Skill);
$Desc = mysqli_real_escape_string($cxn, $Desc);

/* Now INSERT a line into skilllist */
$inserttoskilllist = "INSERT INTO skilllist (`Name` ,`Description` ,`AddedBy` ,`DateAdded`) VALUES ('$Skill', '$Desc', '$AddedBy', CURRENT_TIMESTAMP );";

$worked = mysqli_query($cxn, $inserttoskilllist);

/* Find new skill ID */
$newskillidquery = "SELECT SkillID FROM skilllist WHERE Name = '$Skill'";

if ($newskillidresult = mysqli_query($cxn, $newskillidquery)) {
    $newskillid = $newskillidresult->fetch_row();
    $newskillid = $newskillid[0];
    global $newskillid;

    $query = "SELECT DISTINCT ID, TagName FROM taglist ORDER BY TagName";
    $result = mysqli_query($cxn, $query) or die ("Couldn't execute query");

    while($row = $result->fetch_row()) {
       	$tagid = $row[0];
        if ($_POST[$tagid] == "yes") {
            $newtagdesc = $row[1];
            $inserttoskilltag = "INSERT INTO skilltag (`SkillName`, `TagName`, `TagID`, `SkillID`) "
                              . "VALUES ('$Skill', '$newtagdesc', '$tagid', '$newskillid');";
            $worked = mysqli_query($cxn, $inserttoskilltag);
        }              
    }
}

header("Location: skillinfo.php?skill=$newskillid");
exit();
?>