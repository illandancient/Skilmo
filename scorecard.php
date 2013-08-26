<?php
session_start();
echo "<html><head><title>Scorecard</title></head>";
include 'heading.inc';
?>

<?php
include 'dbstuff.inc';

$lastuseridquery = "SELECT MAX(UserID) FROM userskill";
if ($lastusermush = mysqli_query($cxn, $lastuseridquery)) {
    While ($lastuserid = ($lastusermush->fetch_row())) {
       $newuserid = $lastuserid[0] + 1;
       global $newuserid;
    }
    $lastusermush->close();
}

$query = "SELECT DISTINCT SkillID, Name FROM skilllist ORDER BY Name";

if ($result = mysqli_query($cxn, $query)) {
    while($row = $result->fetch_row()) {
        extract($row);
        if ($_POST['userskill'][$row[0]] == "yes") {
            /* Now INSERT a line into userskill */
            $adduserskillquery = "INSERT INTO userskill (UserID, SkillID) VALUES ( $newuserid , $row[0] )";
            mysqli_query($cxn, $adduserskillquery);
        }
    }
    $result->close();
}

$awesomenessquery = "SELECT userskill.UserID, userskill.SkillID, skilllist.Name, skillusercount.UserCount, "
                  . " CASE skillusercount.UserCount "
                  . " WHEN skillusercount.UserCount = '1' THEN 6 "
                  . " WHEN skillusercount.UserCount = '2' THEN 4 "
                  . " ELSE 2 "
                  . "END AS Score "
                  . "FROM userskill "
                  . "LEFT JOIN skillusercount ON userskill.SkillID = skillusercount.SkillID "
                  . "LEFT JOIN skilllist ON userskill.SkillID = skilllist.SkillID "
                  . "WHERE userskill.UserID = '$newuserid' "
                  . "ORDER BY Name ASC;";

if ($result = mysqli_query($cxn,$awesomenessquery)) {
    echo "<table cellpadding='0' cellspacing='0'><tr><th>Skill</th>"
       . "<th align='center'>Other users</th><th align='center'>Score</th></tr>\n";
    /* fetch object array */
    $userscore = 0;
    while ($row = $result->fetch_row()) {
        $skillid = $row[1];
        $skillname = $row[2];
        $otherusers = $row[3];
        $skillscore = $row[4];

        echo "<td><a href='skillinfo.php?skill=$skillid'> $skillname </a></td>";
        echo "<td>$otherusers </td><td>$skillscore points</td></tr>\n";
        $userscore += $skillscore;
        global $userscore;
    }

    /* free result set */
    $result->close();
    echo "</table><br>\n";
}

$getscore = "SELECT COUNT(SkillID) AS SkillCount FROM userskill WHERE UserID = $newuserid";

if ($score = mysqli_query($cxn, $getscore)) {
    while($row = $score->fetch_row()) {
        echo "You checked $row[0] skills<br>\n";
    }
    $score->close();
}

echo "Your SKILMO SCORE is $userscore<br><br>\n\n";
echo "Your tester user ID is $newuserid - this might be important<br>\n\n";

echo "You might, at this point, like to register to save your score<br>\n";
echo "<form name='checklist_register' action='Checklist_Login_reg.php' method='post'>";
echo "<input type='hidden' name='userid' value=$newuserid>";
echo "<input type='submit' value='Register your score'></form>\n\n";

?>

<?php
include 'footing.inc';
?>