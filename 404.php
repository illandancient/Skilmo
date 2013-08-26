<?php
session_start();
echo "<html><head>\n",
     "    <title>Information about Photo </title>\n";
include 'heading.inc';
?>
<div class='stitched'>
    <h2>404 Page not found</h2>

Whoops, sorry, this page does not exist.</br>
Feel free to leave a message for other lost souls</br>.
</div>

<?php
/* Comments script */
echo "<div class='stitchpatch' style='width: 90%;'>\n";
include 'comments/comments.php';
echo "</div>",
     "<br>";

include 'footing.inc';

?>