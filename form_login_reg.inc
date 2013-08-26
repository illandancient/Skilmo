<?php
 /* File: Login_reg_form.inc
  * Desc: Contains the code for a Web page that displays
  *       two HTML forms, side by side. One is a login
  *       form and the second is a registration form.
  */
include("functions.inc");
?>
<head><title>Customer Login Page</title>
      <style type='text/css'>
      <!--
      label {
        font-weight: bold;
        float: left;
        width: 27%;
        margin-right: .5em;
        text-align: right;
        }
      legend {
        font-weight: bold;
        font-size: 1.2em;
        margin-bottom: .5em;
        }
      #wrapper {
        margin: 0;
        padding: 0;
        }
      #login {
        position: absolute;
        left: 0;
        width: 40%;
        padding: 1em 0;
        }
      #reg {
        position: absolute;
        left: 40%;
        width: 60%;
        padding: 1em 0;
        }
      #field {padding-bottom: .5em;}
      .errors {
        font-weight: bold;
        font-style: italic;
        font-size: 90%;
        color: red;
        margin-top: 0;
        }
       -->
    </style>
</head>
<body style="margin: 0">
<?php
$fields_1 =   array("fusername" => "User Name",
                    "fpassword" => "Password"
                   );
$fields_2 =   array("user_name"      => "User Name",
                    "rpassword"      => "Password",
                    "email"          => "Email"
                   );
?>
<div id="wrapper">
  <div id="login">
   <form action=<?php echo $_SERVER['PHP_SELF']?>
         method="POST">
      <fieldset style='border: 2px solid #000000'>
        <legend>Login Form</legend>
<?php
        if (isset($message_1))
        {
          echo "<p class='errors'>$message_1</p>\n";
        }
        foreach($fields_1 as $field => $value)
        {
          if(preg_match("/pass/i",$field))
             $type = "password";
          else
             $type = "text";
          echo "<div id='field'>
            <label for='$field'>$value</label>
            <input id='$field' name='$field' type='$type'
            value='".@$$field."' size='20' maxlength='50' />
            </div>\n";
        }
?>
        <input type="submit" name="Button"
               style='margin-left: 45%; margin-bottom: .5em'
               value="Login" />
      </fieldset>
    </form>
    <p style='text-align: center; margin: 1em'>
        If you already have an account, log in.</p>
    <p style='text-align: center; margin: 1em'>
        If you do not have an account, register now.</p>
  </div>
  <div id="reg">
    <form action=<?php echo $_SERVER['PHP_SELF']?>
          method="POST">
      <fieldset style='border: 2px solid #000000'>
       <legend>Registration Form</legend>
<?php
       if(isset($message_2))
       {
         echo "<p class='errors'>$message_2</p>\n";
       }
       foreach($fields_2 as $field => $value)
       {
         if($field == "state")
         {
           echo "<div id='field'>
             <label for='$field'>$value</label>
             <select name='state' id='state'>";
             $stateName=getStateName();
             $stateCode=getStateCode();
             for ($n=1;$n<=50;$n++)
             {
               $state=$stateName[$n];
               $scode=$stateCode[$n];
               echo "<option value='$scode'";
               if ($scode=="AL")
                  echo " selected";
               echo ">$state</option>\n";
             }
             echo "</select></div>";
         }
         else
         {
           if(preg_match("/pass/i",$field))
              $type = "password";
           else
              $type = "text";
           echo "<div id='field'>
             <label for='$field'>$value</label>
             <input id='$field' name='$field' type='$type'
             value='".@$$field."' size='40' maxlength='65' />
             </div>\n";
         }  //end else
       }  // end foreach field
?>
       <input type="submit" name="Button"
          style='margin-left: 45%; margin-bottom: .5em'
          value="Register">
      </fieldset>
    </form>
  </div>
</div>
</body></html>

