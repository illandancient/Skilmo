<?php

$host="cust-mysql-123-05";
$user="uchr_907455_0001@10.15.11.144";
$password="Ty6+w5*X";
$dbname="chrisgilmourcouk_907455_db1";
$socket="/tmp/mysql.sock";
$cxn = mysqli_connect($host, $user, $password, $dbname) or die ("Could not log on to database, check host, account, password and dbname");
$query = "SELECT SkillID, `Name` FROM `skilllist` ORDER BY `Name` ";

echo '<html><head><title>List of Skills</title></head><body bgcolor="#FFFF88">';
echo '<font color="#880000">';
echo '<p>SKILMO';
echo ' - Indie Eyespy, but with skills and crafts and DIY</p></p>';

echo '<p>Here\'s a list of all the skills that you get points for:-</p></p>';
echo '<table cellpadding="0" cellspacing="0">';
echo '<tr><th>Name</th></tr>';
		
if ($result = mysqli_query($cxn,$query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<tr><td> %s </td></tr>", $row[1]);
    }

    /* free result set */
$result->close();
}

/* close connection */
/* $mysqli->close(); */

echo '</font></body></html>';
?>