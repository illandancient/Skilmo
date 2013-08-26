<?php

$host="cust-mysql-123-05";
$user="uchr_907455_0001@10.15.11.144";
$password="Ty6+w5*X";
$dbname="chrisgilmourcouk_907455_db1";
$socket="/tmp/mysql.sock";
$cxn = mysqli_connect($host, $user, $password, $dbname) or die ("Could not log on to database");
$skill = "\"Palm Weaving\"";

$skillquery = "SELECT Description from skilllist WHERE Name = $skill";
$tagquery = "SELECT TagName FROM skilltag WHERE SkillName = $skill ";

echo '<html><head><title>Information about skill </title></head><body bgcolor="#FFFF88">';
echo '<font color="#880000">';
echo '<p>SKILMO';
echo ' - Indie Eyespy, but with skills and crafts and DIY</p></p>';

echo '<table cellpadding="0" cellspacing="0"><tr><th>Description</td></tr>';

if ($result = mysqli_query($cxn,$skillquery)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<tr><td> %s </td></tr>", $row[0]);
    }

    /* free result set */
    $result->close();
}


printf ("<p>Here is information about %s </p></p>", $skill);
echo '<table cellpadding="0" cellspacing="0"><tr><th>Tags</td></tr>';

if ($result = mysqli_query($cxn,$tagquery)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<tr><td> %s </td></tr>", $row[0]);
    }

    /* free result set */
    $result->close();
}

echo '</font></body></html>';
?>