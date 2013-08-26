<?php
/*  Program name: form_log.php
 *  Description: Displays a login form.
 */
  if (isset($message))
  {
     echo $message;
  }
  echo "<form action='login_url.php'
              method='POST' style='margin .5in'>\n
    <p><label for='user_name' style='font-weight: bold;
              padding-bottom: 1em'>You might want to chose a username </label>
       <input type='text' name='user_name' id='user_name'
              value='$user_name' />\n</p>
    <p><label for='user_name' style='font-weight: bold;
              padding-bottom: 1em'>You might want to chose a username </label>
       <input type='text' name='user_name' id='user_name'
              value='$user_name' />\n</p>
    <p><input type='submit' value='Log me'>\n</p>
       <input type='hidden' name='sent' value='yes' />
       <input type='hidden' name='newuserid' value='$newuserid' />
    </form>\n";
?>

