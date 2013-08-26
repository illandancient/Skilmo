<?php
echo "<html><head><title>New User</title></head>";
include 'heading.inc';
?>

<?php
include 'dbstuff.inc';

$userid = $_SESSION['userid'];

if (empty($_SESSION['userid'])) {
    echo "Something cocked up there is no user id<br>\n";
}
else {
    echo "Good afternoon, your user id is still $userid <br>\n";
}

if (!empty($_POST['username'])) {
    $username = $_POST['username'];
    echo "And your username is $username <br>\n";
}

?>

<?php
include 'footing.inc';
?>