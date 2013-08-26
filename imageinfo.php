<?php
session_start();
echo '<html><head><title>User information</title></head>';
include 'heading.inc';

?>

<?php
 
include 'dbstuff.inc';

$photoid = $_GET['photo'];

?>

<table border="1">
  <tr>
    <th>User</th>
    <th>Drawing by illandancient added 23-10-1995</th>
    <th>Skill</th>
  </tr>
  <tr>
    <td>Best user image</td>
    <td rowspan=6>Main image</td>
    <td>Best skill image</td>
  </tr>
  <tr>
    <td>Second Best user image</td>
    <td>Second Best skill image</td>
  </tr>
  <tr>
    <td>Slightly better user image</td>
    <td>Slightly better skill image</td>
  </tr>
  <tr>
    <td>Slightly worse user image</td>
    <td>Slightly worse skill image</td>
  </tr>
  <tr>
    <td>Second worst user image</td>
    <td>Second worst skill image</td>
  </tr>
  <tr>
    <td>Worst user image</td>
    <td>Worst skill image</td>
  </tr>
  <tr>
    <td></td>
    <td>Voting</td>
    <td></td>
  </tr>
</table>

<?php

include 'footing.inc';

?>