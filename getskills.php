<?php

$host="cust-mysql-123-05";
$user="uchr_907455_0001@10.15.11.144";
$password="Ty6+w5*X";
$dbname="chrisgilmourcouk_907455_db1";
$socket="/tmp/mysql.sock";

$cxn = mysqli_connect($host, $user, $password, $dbname) or die ("Could not log on to database, check host, account, password and dbname");

echo "<html><head><title>List of Skills</title></head><body>";

$query = "SELECT `name` FROM `skilllist` LIMIT 0, 30 ";

if ($result = mysqli_query($cxn,$query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("%s \n", $row[0], $row[1]);
    }

    /* free result set */
    /* $result->close(); */
}

/* close connection */
$mysqli->close();
?>