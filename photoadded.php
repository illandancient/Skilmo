<?php
session_start();
   if(@$_SESSION['auth'] != "yes")
   {
     header("Location: index.php");
     exit();
   }

echo "<html><head><title>Photo uploaded</title></head>";

include 'heading.inc';
?>

<div class='stitched'>

<?php
/*   Program name: photoadded.php
 *   Description:  Uploads a photo to server
 */
 
include 'dbstuff.inc';

    $target_path = "images/";
    $target_path = $target_path . basename( $_FILES['uploadedfile']['name']);

/* Checks that the uploady file is only a jpeg or jpg (is 
   there a difference) and that it is less that the maximum
   file 2mb size and also bigger than 10 bytes
*/
    /* echo "The file ".  basename( $_FILES['uploadedfile']['name']) . "<br>\n" ; */
    if((basename($_FILES['uploadedfile']['type'] == "image/jpeg")
     || basename($_FILES['uploadedfile']['type'] == "image/jpg"))
     && basename($_FILES['uploadedfile']['size'] < 2000000)
     && basename($_FILES['uploadedfile']['size'] > 10)) 
     {
        /* echo "passed file type and size<br>\n";  */
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            /* echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded <br>"; */

             /*  Add line in images table */

            $userid = $_SESSION['userid'];
            $AddedBy = $_SESSION['logname'];
            $OriginalFileName = $_FILES['uploadedfile']['name'];
            $SkillID = $_POST['skillid'];

            $skillnamequery = "SELECT Name FROM skilllist WHERE SkillID = '$SkillID'";

            if ($skillnameresult = mysqli_query($cxn, $skillnamequery)) {
                /* fetch object array */
                while ($row = $skillnameresult->fetch_row()) {
                    $SkillName = $row[0];
                    global $SkillName;
                }
                /* free result set */
                $skillnameresult->close();
            }

            $insertimage = "INSERT INTO images (AddedBy, UserID, SkillName, SkillID, DateAdded, "
                         . " OriginalFileName) VALUES ('$AddedBy', '$userid', '$SkillName', "
                         . " '$SkillID', CURRENT_TIMESTAMP, '$OriginalFileName');";

            mysqli_query($cxn, $insertimage);

            /*  Find new photo ID */
            $photoidquery = "SELECT PhotoID FROM images WHERE AddedBy = '$AddedBy'AND SkillID = '$SkillID' \n"
                          . "AND OriginalFileName = '$OriginalFileName'; ";

            if ($photoid = mysqli_query($cxn, $photoidquery)) {
                /* fetch object array */
                while ($row = $photoid->fetch_row()) {
                    $newphotoid = $row[0];
                    global $newphotoid;
                }
                /* free result set */
                $photoid->close();
            }

            /*  Rename photo on server */
            if (rename("images/$OriginalFileName", "images/$newphotoid.jpg")) {
                /* echo "... and renamed $newphotoid.jpg <br>"; */
                echo "A new image has been added... </br>\n";
            }

            /* Display photo */
            echo "<a href='\photoinfo.php?image=$newphotoid'><img src='images/$newphotoid.jpg' ",
                 " alt='$SkillID by $AddedBy'></a><br>\n $SkillName by $AddedBy<br>\n";

        }
    }
    else{
        echo "Failed file type " . basename($_FILES['uploadedfile']['type']) . "<br>\n";
        echo "Failed file size " . basename($_FILES['uploadedfile']['size']) . "<br>\n";
        echo "There was an error uploading the file, please try again!<br>\n",
             "Please check that its a jpg and smaller than 2Mb<br>\n",
             "<a href='http://chrisgilmour.co.uk/uploadphoto.php'>Back to image upload page</a><br>\n";
    }
   
?>
</div>
<?php
include 'footing.inc';
?>