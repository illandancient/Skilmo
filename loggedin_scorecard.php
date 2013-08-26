<?php
session_start();

include 'dbstuff.inc';

$userid = $_SESSION['userid'];

$query = "SELECT DISTINCT SkillID, Name FROM skilllist ORDER BY Name";

if ($result = mysqli_query($cxn, $query)) {
    while($row = $result->fetch_row()) {
        extract($row);
        if ($_POST['userskill'][$row[0]] == "yes") {
            /* Now INSERT a line into userskill */
            $adduserskillquery = "INSERT INTO userskill (UserID, SkillID) VALUES ( $userid , $row[0] )";
            mysqli_query($cxn, $adduserskillquery);
        }
    }
    $result->close();
}

header("Location: userinfo.php?user=$userid");

?>