<?php

$host="cust-mysql-123-05";
$user="uchr_907455_0001@10.15.11.144";
$password="Ty6+w5*X";
$dbname="chrisgilmourcouk_907455_db1";
$socket="/tmp/mysql.sock";
$cxn = mysqli_connect($host, $user, $password, $dbname) or die ("Could not log on to database");
$tag = "'Textile arts'";

$query = "SELECT Name, Description FROM skilllist WHERE Name IN (SELECT SkillName FROM skilltag WHERE TagName = $tag)";

echo '<html><head><title>Skills with that tag</title></head><body bgcolor="#FFFF88">';
echo '<font color="#880000">';
echo '<p>SKILMO';
echo ' - Indie Eyespy, but with skills and crafts and DIY</p></p>';

printf (" These are all the skills that have the %s tag</p>", $tag);

echo '<table cellpadding="0" cellspacing="0"><tr><th>Skill</th><th>Description</td></tr>';

if ($result = mysqli_query($cxn,$query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<tr><td> %s </td><td> %s </td></tr>", $row[0], $row[1]);
    }

    /* free result set */
    $result->close();
}

echo '</font></body></html>';
?>