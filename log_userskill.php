<?php
session_start();
if(@$_SESSION['auth'] != "yes")
{
    header("Location: index.php");
    exit();
}

/*   Program name: log_userskill.php
 *   Description:  logs existing skill to user
 */
 
include 'dbstuff.inc';

$userid = $_SESSION['userid'];
$skillid = $_POST['skillid'];

/* Now INSERT a line into skilllist */
$adduserskillquery = "INSERT INTO userskill (UserID, SkillID) VALUES ( $userid , $skillid )";
mysqli_query($cxn, $adduserskillquery);

header("Location: skillinfo.php?skill=$skillid");
exit();
?>