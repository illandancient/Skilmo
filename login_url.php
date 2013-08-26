<?php
/*  Program name: login_url.php
 *  Description:  Logs in user.
 */

  if (isset($_POST['sent']) && $_POST['sent'] == "yes")
  {
     /* check each field for blank fields  */
    foreach($_POST as $field => $value)
    {
      if ($value == "")
      {
        $blank_array[$field] = $value;
      }
      else
      {
        $good_data[$field]=strip_tags(trim($value));
      }
    }   // end of foreach loop for $_POST
    if(@sizeof($blank_array) > 0)  // blank fields found
    {
      $message = "<p style='color: red; magin-bottom: 0;
                           font-weight: bold'>
            You must enter a username</p>";
      /* redisplay form */
      extract($blank_array);
      extract($good_data);
      include("form_log.inc");
      exit();
    }  // end if blanks found
    include ("dbstuff.inc");
    $newuserid = $_POST[newuserid];
    $user_name = $_POST[user_name];
    $spass_word = $_POST[spassword];
    $query = "SELECT UserID FROM userlist "
                  . "WHERE UserName='$user_name' "
//                . "AND Password=SHA2('$_POST[spassword]', 512)";
//                . "AND Password='$spass_word'";
                  . " ";
    $result = mysqli_query($cxn, $query)
              or die ("Couldn't execute query.");
    $n_row = mysqli_num_rows($result);
    if($n_row < 1) // if login unsuccessful
    {
      $insertnewusername = "INSERT INTO userlist (UserID, UserName, "
                         . " 'Password', 'DateAdded', 'Salt1', "
                         . " 'Salt2') VALUES ('$newuserid', '$user_name', "
                         . " '', CURRENT_TIMESTAMP, '', '');";

      mysqli_query($cxn, $insertnewusername) or die ("Couldn't execute query.");
      header("Location: userinfo.php?user=$newuserid");
    }
    else // if login successful
    {
      $row=mysqli_fetch_assoc($result);
      header("Location: userinfo.php?user=$row[UserID]");
    }
  }  // end if submitted
  else  // first time script is run
  {
    $user_name = "";
    $spassword = "";
    include ("form_log.inc");
  }

?>

