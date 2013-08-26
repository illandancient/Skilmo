<?php
 /* File: login_form.inc
  * Desc: Contains the code for a Web page that displays
  *       one HTML form, the registration form.
  */
include("functions.inc");
?>
<head>
    <title>Customer Login Page</title>
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
/*      #login {
        position: absolute;
        left: 0;
        width: 40%;
        padding: 1em 0;
        }  */
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
<?php
    include 'heading.inc';

$fields_1 =   array("fusername" => "User Name",
                    "fpassword" => "Password"
                   );
$fields_2 =   array("user_name"      => "User Name",
                    "rpassword"      => "Password",
                    "email"          => "Email"
                   );
?>

<div class="stitched">
<!--  <div id="login">  -->
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
<!--  </div>  -->
</div>
</body></html>