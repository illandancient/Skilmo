<?php
/*   Program name: form_checkbox.inc
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
echo " - \n</div>\n</br>\n\n";


$sortedtaglist = mysqli_query($cxn, $sortedtagcountquery);
echo "<div class='stitched'>\n<form action='scorecard.php' method='POST'>";
while($row = $sortedtaglist->fetch_row()){
    $categoryname = $row[0];
    $categoryid = $row[1];
    echo "<fieldset><legend>", 
         "<a id='C$categoryid'>$categoryname</a></legend>\n";

    $skillsincatquery = "SELECT skilllist.Name, skilllist.Description, skilltag.SkillID from skilltag "
                      . " LEFT JOIN skilllist ON skilltag.SkillID = skilllist.SkillID "
                      . " WHERE skilltag.TagID = $categoryid ORDER BY skilllist.Name";
    $skillsincat = mysqli_query($cxn,$skillsincatquery);
    echo "<ul style='list-style: none'>\n";
    while($srow = $skillsincat->fetch_row()){
        $skillname = $srow[0];
        $skilldescription = $srow[1];
        $skillid = $srow[2];
        echo "<li><input type='checkbox' name='userskill[$srow[2]]' id='$srow[2]' value='yes' />\n"
           . "<label for='$srow[0]' style='font-weight: bold'>$srow[0]</label> - $srow[1] </li>\n";
    }
    echo "</ul></fieldset>\n";
    echo "<p><input type='submit' value='Calculate score' />\n";
}
echo "</form>\n</div>\n";
?>
