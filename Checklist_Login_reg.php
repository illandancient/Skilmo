<?php
 /* File: Login_reg.php
  * Desc: Main application script for the User Login
  *       application. It provides two options: (1) login
  *       using an existing User Name and (2) register
  *       a new user name. Usernames and passwords are 
  *       stored in a MySQL database
  */
 session_start();
 $newuserid = $_POST['userid'];
 
 switch (@$_POST['Button'])
 {
   case "Login":
     include("dbstuff.inc");
     $sql = "SELECT UserName FROM userlist WHERE UserName = '$_POST[fusername]'";
     $result = mysqli_query($cxn, $sql) or die ("Query died: fuser_name");
     $num = mysqli_num_rows($result);
     if($num > 0 )
     {
       $sql = "SELECT UserName FROM userlist WHERE UserName = '$_POST[fusername]' AND Password=MD5('$_POST[fpassword]')";
       $result2 = mysqli_query($cxn, $sql) or die ("Query died: fpassword");
       $num2 = mysqli_num_rows($result2);
       if($num2 > 0)    // password matches
       {
         $_SESSION['auth']="yes";
         $_SESSION['logname'] = $_POST['fusername'];
         $_SESSION['userid'] = $newuserid;
         header("Location: SecretPage.php");
       }
       else   //  password does not match
       {
         $message_1="The username, '$_POST[fusername]' exists, but you have not entered the correct password! </br> $sql <br>Plesae try again.";
         $fusername = strip_tags(trim($_POST[fusername]));
         include("Checklist_form_login_reg.inc");
       }
     }    // end if $num > 0
     elseif($num == 0)   //   username not found
     {
       $message_1 = "The username you entered does not exist! Please try again.";
       include("Checklist_form_login_reg.inc");
     }
   break;

   case "Register";
     /* check for blanks */
     foreach($_POST as $field => $value)
     {
       if ($field != "fax")
       {
         if ($value == "")
         {
           $blanks[] = $field;
         }
         else
         {
           $good_data[$field] = strip_tags(trim($value));
         }
       }
     }  // end foreach POST
     if(isset($blanks))
     {
       $message_2 = "The following fields are blank. Please enter the required information:   ";
       foreach($blanks as $value)
       {
         $message_2 .="$value, ";
       }
       extract($good_data);
       include("Checklist_form_login_reg.inc");
       exit();
     }  // end if blanks found
   /*  validate data   */
     foreach($_POST as $field => $value)
     {
       if(!empty($value))
       {
         if(preg_match("/name/i",$field) and
           !preg_match("/user/i",$field) and
           !preg_match("/log/i",$field))
         {
           if (!preg_match("/^[A-Za-z' -]{1,50}$/",$value))
           {
             $errors[] = "$value is not a valid name. ";
           }
         }
         if(preg_match("/addr/i",$field) or
            preg_match("/city/i",$field))
         {
           if(!preg_match("/^[A-Za-z0-9.,' -] {1,50}$/", $value))
           {
             $error[] = "$value is not a valid addess or city. ";
           }
         }
         if(preg_match("/state/i",$field))
         {
           if(!preg_match("/^[A-Z][A-Z]$/",$value))
           {
             $errors[] = "$value is not a valid state code. ";
           }
         }
         if(preg_match("/email/i",$field))
         {
           if(!preg_match("/^.+@.+\\..+$/",$value))
           {
             $errors[] = "$value is not a valid email address. ";
           }
         }
         if(preg_match("/zip/i",$field))
         {
           if(!preg_match("/^[0-9]{5,5}(\-[0-9]{4,4})?$/",$value))
           {
             $errors[] = "$value is not a valid zipcode. ";
           }
         }
         if(preg_match("/phone/i",$field) or preg_match("/fax/i",$field))
         {
           if(!preg_match("/^[0-9)(xX -]{7,20}$/",$value))
           {
             $errors[] = "$value is not a valid phone number. ";
           }
         }
       }  // end if not empty
     }  //  end foreach POST
     foreach($_POST as $field => $value)
     {
       $$field = strip_tags(trim($value));
     }
     if(@is_array($errors))
     {
       $message_2 = "";
       foreach($errors as $value)
       {
         $message_2 .= $value." Please try again<br />";
       }
       include("Checklist_form_login_reg.inc");
       exit();
     }   //  end if errors are found

    /*  check to see if username already exists */
     include("dbstuff.inc");
     $sql = " SELECT UserName FROM userlist WHERE UserName = '$user_name'";
     $result = mysqli_query($cxn, $sql) or die("Query died: user_name.");
     $num = mysqli_num_rows($result);
     if($num > 0)
     {
       $message_2 = "$user_name already used. Select another username.";
       include("Checklist_form_login_reg.inc");
       exit();
     }  // end if user name already exists
     else
     {
       $sql = "INSERT INTO userlist (UserID,UserName,Password,DateAdded,Email) VALUES
             ('$newuserid', '$user_name', MD5('$rpassword'), CURRENT_TIMESTAMP, '$email')";
       mysqli_query($cxn, $sql);
       $_SESSION['auth']="yes";
       $_SESSION['logname'] = $user_name;
       $_SESSION['userid'] = $newuserid;
       header("Location: userinfo.php?user=$newuserid");
     }  // end else no errors found
   break;

   default:
     include("Checklist_form_login_reg.inc");
 }   // end switch
 ?>