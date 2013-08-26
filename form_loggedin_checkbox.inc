<?php
/*   Program name: form_loggedin_checkbox.inc
 *   Description:  Program displays a list of 
 *                 checkboxes from database info.
 */

$sortedtagcountquery = "SELECT taglist.TagName, skilltag.TagID, COUNT( skilltag.SkillID ) "
                     . " AS SC FROM skilltag LEFT JOIN taglist ON taglist.ID = skilltag.TagID "
                     . " GROUP BY skilltag.TagID ORDER BY SC DESC ";

$sortedtaglist = mysqli_query($cxn, $sortedtagcountquery);


echo "<div class='stitchpatch' style='width: 90%''><h3>Which skills and crafts can you do?
       <span style='font-size: 80%; font-weight: normal'>
       (Check as many as you can)</span></h3>\n";
while($trow = $sortedtaglist->fetch_row()){
    $tcategoryid = $trow[1];
    $tcategoryname = $trow[0];
    echo " - <a href='#C$tcategoryid'>$tcategoryname</a>\n";
}
echo " - </div>\n",
     "</br>\n\n",
     "<div class='stitched'>\n";


$sortedtaglist = mysqli_query($cxn, $sortedtagcountquery);
echo "<form action='loggedin_scorecard.php' method='POST'>";
while($row = $sortedtaglist->fetch_row()){
    $categoryname = $row[0];
    $categoryid = $row[1];
    echo "<fieldset><legend style='font_weight: bold'><a id='C$categoryid'>$categoryname</a></legend>\n";
    $userid = $_SESSION['userid'];


    $skillsincatquery = "SELECT skilllist.Name, skilllist.Description, skilltag.SkillID, US.UserID "
                      . " FROM skilltag LEFT JOIN skilllist ON skilltag.SkillID = skilllist.SkillID "
                      . " LEFT JOIN (SELECT userskill.UserID, userskill.SkillID FROM userskill WHERE "
                      . " userskill.UserID = $userid) AS US ON skilltag.SkillID = US.SkillID WHERE "
                      . " skilltag.TagID = $categoryid ORDER BY skilllist.Name ";

    $skillsincat = mysqli_query($cxn,$skillsincatquery);
    echo "<ul style='list-style: none'>\n";
    while($srow = $skillsincat->fetch_row()){
        $skillname = $srow[0];
        $skilldescription = $srow[1];
        $skillid = $srow[2];
        if(!$srow[3]){
            echo "<li><input type='checkbox' name='userskill[$srow[2]]' id='$srow[2]' value='yes' />\n"
           . "<label for='$srow[0]' style='font-weight: bold'>$srow[0]</label> - $srow[1] </li>\n";
        }
        else {
            echo "<li> * <label for='$srow[0]' style='font-weight: bold'>$srow[0]</label> - $srow[1] </li>\n";
        }
    }
    echo "</ul></fieldset>";
    echo "<p><input type='submit' value='Calculate score' /></p>";
}
echo "</form>\n";
?>
