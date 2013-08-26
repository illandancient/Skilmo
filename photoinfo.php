<?php
session_start();
 
include 'dbstuff.inc';

$imageid = $_GET['image'];

if (!is_numeric($imageid)) {
        $imageid = 24;
}

$photofilename = "images/$imageid.jpg";
$imagevotequery = "SELECT images.PhotoID, images.UserID, userlist.UserName, images.SkillID, "
                . " skilllist.Name, images.DateAdded, OC.OCC FROM images LEFT JOIN userlist "
                . " ON images.UserID = userlist.UserID LEFT JOIN skilllist ON images.SkillID "
                . " = skilllist.SkillID LEFT JOIN (SELECT uservote.ObjectID, "
                . " COUNT(uservote.VoteType) AS OCC FROM uservote WHERE ObjectType = 'image' "
                . " GROUP BY ObjectID) AS OC ON images.PhotoID = OC.ObjectID "
                . " WHERE images.PhotoID = '$imageid'";

$top5skillimages = "SELECT images.PhotoID, images.UserID, images.SkillID, votes.Votes FROM images "
                 . " LEFT JOIN (SELECT ObjectID, COUNT(VoteType) AS Votes FROM uservote WHERE "
                 . " ObjectType = 'image' GROUP BY ObjectID) AS votes ON images.PhotoID = "
                 . " votes.ObjectID WHERE SkillID = '$imageskillid' ORDER BY votes.Votes DESC LIMIT 5";

if ($result = mysqli_query($cxn, $imagevotequery)) {
    while ($imageinfo = $result->fetch_row()) {
        $imageuserid = $imageinfo[1];
        global $imageuserid;
        $imageusername = $imageinfo[2];
        $imageskillid = $imageinfo[3];
        global $imageskillid;
        $imageskillname = $imageinfo[4];
        $imagedateadded = $imageinfo[5];
        $imagevotes = $imageinfo[6];

        echo "<html><head>\n",
             "    <title>$imageskillname by $imageusername</title>\n",
             "    <link rel='canonical' href='http://www.skilmo.co.uk/photoinfo.php?image=$imageid' />\n";

/* meta tags for Facebooks */
        echo "    <meta property='og:image' content='http://www.skilmo.co.uk/$photofilename' />\n",
             "    <meta property='og:title' content='$imageskillname by $imageusername' />\n",
             "    <meta property='og:url' content='http://www.skilmo.co.uk/photoinfo.php?image=$imageid' />\n",
             "    <meta property='og:site_name' content='Skilmo: Arts, Crafts and Skills' />\n",
             "    <meta property='og:type' content='website' />\n",
             "    <meta property='og:description' content='$imageusername has uploaded an image of $imageskillname to Skilmo, the arts crafts and skills social hub.' />\n";

/* meta tags for twitter card
 * Need to populate them properly
 * and also the robots.txt file (?)
             <meta name="twitter:card" content="summary">
             <meta name="twitter:url" content="http://davidwalsh.name/twitter-cards">
             <meta name="twitter:title" content="How to Create a Twitter Card">
             <meta name="twitter:description" content="Twitter's new Twitter Cards API allows developers to add META tags to their website, and Twitter will build card content from links to a given site.">
             <meta name="twitter:image" content="http://davidwalsh.name/demo/openGraphLogo.png">
             <meta name="twitter:image:width" content="600">
             <meta name="twitter:image:height" content="600">
*/

        include 'heading.inc';
?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<?php
        $top5userimages = "SELECT images.PhotoID, images.UserID, images.SkillID, votes.Votes FROM images "
                . " LEFT JOIN (SELECT ObjectID, COUNT(VoteType) AS Votes FROM uservote WHERE "
                . " ObjectType = 'image' GROUP BY ObjectID) AS votes ON images.PhotoID = "
                . " votes.ObjectID WHERE UserID = '$imageuserid' ORDER BY votes.Votes DESC LIMIT 5";

        echo "</br>\n<div class='stitched' align='center'>\n",
             "    <h2><a href='/skillinfo.php?skill=$imageskillid'>$imageskillname</a> by ",
             "<a href='/userinfo.php?user=$imageuserid'>$imageusername</a></h2>\n",
             "    Added $imagedateadded<br>\n",
             "    $imagevotes votes<br>\n";
        if ($t5ur = mysqli_query($cxn, $top5userimages)) {
            echo "    <div style='display:inline-block; vertical-align: top'>Top User Pics<br>\n";
            while ($t5u = $t5ur->fetch_row()) {
                 $t5uid = $t5u[0] ;
                 $t5uidurl = "images/$t5uid.jpg" ;
                 echo "        <a href='photoinfo.php?image=$t5uid'>"
                    . "<img src='resize.php?w=100&img=$t5uidurl' /></a><br>\n";
            }
            echo "    </div>\n";
        }
        echo "    <div style='display:inline-block'><img src='resize.php?w=600&img=$photofilename' /><br>\n";
        
        if(@$_SESSION['auth'] == "yes") {
            $userid=$_SESSION['userid'];
            echo "        <div style='display:inline-block'>\n";
            echo "            <form name='input' action='voteaction.php' method='post'>\n"
               . "            <input type='hidden' name='userid' value='$userid'>\n"
               . "            <input type='hidden' name='objecttype' value='image'>\n"
               . "            <input type='hidden' name='objectid' value='$imageid'>\n"
               . "            <input type='hidden' name='votetype' value='up'>\n"
               . "            <input type='submit' value='Up vote' style='height: 25px; width: 100px'></form>\n";
            echo "        </div>\n        <div style='display:inline-block'>\n";
            echo "            <form name='input' action='voteaction.php' method='post'>\n"
               . "            <input type='hidden' name='userid' value='$userid'>\n"
               . "            <input type='hidden' name='objecttype' value='image'>\n"
               . "            <input type='hidden' name='objectid' value='$imageid'>\n"
               . "            <input type='hidden' name='votetype' value='down'>\n"
               . "            <input type='submit' value='Down vote' style='height: 25px; width: 100px'></form>\n";
            echo "        </div>\n";
        }
        echo "</div>\n";

        $top5skillimages = "SELECT images.PhotoID, images.UserID, images.SkillID, votes.Votes FROM images "
                 . " LEFT JOIN (SELECT ObjectID, COUNT(VoteType) AS Votes FROM uservote WHERE "
                 . " ObjectType = 'image' GROUP BY ObjectID) AS votes ON images.PhotoID = "
                 . " votes.ObjectID WHERE SkillID = '$imageskillid' ORDER BY votes.Votes DESC LIMIT 5";
        if ($t5sr = mysqli_query($cxn, $top5skillimages)) {
            echo "<div style='display:inline-block; vertical-align: top'>Top Skill Pics<br>\n";
            while ($t5s = $t5sr->fetch_row()) {
                 $t5sid = $t5s[0] ;
                 $t5sidurl = "images/$t5sid.jpg" ;
                 echo "    <a href='photoinfo.php?image=$t5sid'>"
                    . "<img src='resize.php?w=100&img=$t5sidurl' /></a><br>\n";
            }
            echo "</div>\n";
        }
    }
    /* free result set */
    $result->close();
    echo "<br>\n";
    echo "<div class='fb-like' data-href='http://www.skilmo.co.uk/photoinfo.php?image=$imageid' ",
         " data-send='false' data-width='450' data-show-faces='false'></div>\n";
}
/* Comments script */
/* echo "<div class='stitchpatch' style='width: 90%;'>\n";
include 'comments/comments.php';
echo "</div>",
     "<br>";
*/
include 'footing.inc';

?>