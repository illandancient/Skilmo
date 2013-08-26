<?php
 /* File: SecretPage.php
  * Desc: Displays a welcome page when the user successfully logs in or registers.
  *
  */
   session_start();
   if(@$_SESSION['auth'] != "yes")
   {
     header("Location: Login_reg.php");
     exit();
   }
   echo "<head><title>Secret Page</title></head><body>";
   echo "<p>The User ID, {$_SESSION['logname']}, has successfully logged in</p>";
   echo "Is the session authorised - {$_SESSION['auth']} <br>";
   echo "What is the logname - {$_SESSION['logname']} <br>";
   echo "The userid is - {$_SESSION['userid']} <br>";
?>
</body></html>