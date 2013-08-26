<?php
session_start();
include("dbstuff.inc");

if(@$_SESSION['auth'] == 'yes') {
    if($_POST['userid']==@$_SESSION['userid']) {
        $userid = $_SESSION['userid'];
        if($_POST['objecttype'] == 'image') {
            $objecttype = $_POST['objecttype'];
            $objectid = $_POST['objectid'];
            if($_POST['votetype'] == 'up' || $_POST['votetype'] == 'down') {
                $delpre = "DELETE FROM uservote WHERE UserID = '$userid' AND ObjectType = "
                        . " '$objecttype' AND ObjectID = '$objectid'";
                $result = mysqli_query($cxn,$delpre);
                $votetype = $_POST['votetype'];
                $votequery = "INSERT INTO uservote (VoteID, UserID, ObjectType, ObjectID, "
                           . " VoteType, DateVoted) VALUES (NULL, '$userid', '$objecttype', "
                           . " '$objectid', '$votetype', CURRENT_TIMESTAMP)";
                $result = mysqli_query($cxn,$votequery);
            }
        }
    }
}
$objectid = $_POST['objectid'];
$objecttype = $_POST['objecttype'];
$returnurl= "/photoinfo.php?$objecttype=$objectid";
header("Location: $returnurl"); /* Redirect browser */

exit;

?>