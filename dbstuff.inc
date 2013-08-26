<?php

/*     Filename    dbstuff.inc 
 *                 contains the database login information
 */

$host = "cust-mysql-123-05";
$user = "uchr_907455_0001@10.15.11.144";
$password = "Ty6+w5*X";
$dbname = "chrisgilmourcouk_907455_db1";
$socket = "/tmp/mysql.sock";
$cxn = mysqli_connect($host, $user, $password, $dbname) or die ("Could not log on to database");

?>