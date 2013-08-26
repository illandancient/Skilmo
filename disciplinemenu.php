<?php
$host="cust-mysql-123-05";
$user="uchr_907455_0001@10.15.11.144";
$password="Ty6+w5*X";
$dbname="chrisgilmourcouk_907455_db1";
$socket="/tmp/mysql.sock";
$cxn = mysqli_connect($host, $user, $password, $dbname) or die ("Could not log on to database, check host, account, password and dbname");

$query = "SELECT taglist.ID, skilltag.TagName FROM taglist, `skilltag` WHERE skilltag.TagName = taglist.TagName GROUP BY skilltag.TagName ORDER BY COUNT(skilltag.TagName) DESC";

$top1tag = "SELECT taglist.ID, skilltag.TagName FROM taglist, `skilltag` WHERE skilltag.TagName = taglist.TagName GROUP BY skilltag.TagName ORDER BY COUNT(skilltag.TagName) DESC LIMIT 1";

$top2tag = "select tagname from skilltag where skillname not in (SELECT skillname FROM skilltag WHERE tagname = \"Graphic Arts\") group by tagname order by count(tagname) desc limit 1";

$top3tag = "SELECT TagName from skilltag where SkillName NOT IN (SELECT skillname FROM skilltag WHERE tagname = \"Graphic Arts\" OR tagname = \"Textile arts\" ) GROUP BY TagName ORDER BY COUNT(TagName) DESC LIMIT 1";

$top4tag = "SELECT TagName from skilltag where SkillName NOT IN (SELECT skillname FROM skilltag WHERE tagname = \"Graphic Arts\" OR tagname = \"Textile arts\" OR TagName = \"Photography\" ) GROUP BY TagName ORDER BY COUNT(TagName) DESC LIMIT 1";

$top5tag = "SELECT TagName from skilltag where SkillName NOT IN (SELECT skillname FROM skilltag WHERE tagname = \"Graphic Arts\" OR tagname = \"Textile arts\" OR TagName = \"Photography\" OR TagName = \"Music\" OR TagName = \"Food\" ) GROUP BY TagName ORDER BY COUNT(TagName) DESC LIMIT 1";

$top6tag = "SELECT TagName from skilltag where SkillName NOT IN (SELECT skillname\n"
    . "FROM skilltag\n"
    . "WHERE tagname = \"Graphic Arts\" OR tagname = \"Textile arts\" OR TagName = \"Photography\" OR TagName = \"Music\" OR TagName = \"Food\" ) GROUP BY TagName ORDER BY COUNT(TagName) DESC LIMIT 1";

$top7tag = "SELECT TagName from skilltag where SkillName NOT IN (SELECT skillname\n"
    . "FROM skilltag\n"
    . "WHERE tagname = \"Graphic Arts\" OR tagname = \"Textile arts\" OR TagName = \"Photography\" OR TagName = \"Music\" OR TagName = \"Food\" OR TagName = \"Programming\") GROUP BY TagName ORDER BY COUNT(TagName) DESC LIMIT 1";

$top8tag = "SELECT TagName from skilltag where SkillName NOT IN (SELECT skillname\n"
    . "FROM skilltag\n"
    . "WHERE tagname = \"Graphic Arts\" OR tagname = \"Textile arts\" OR TagName = \"Photography\" OR TagName = \"Music\" OR TagName = \"Food\" OR TagName = \"Programming\" OR TagName = \"Literature\" ) GROUP BY TagName ORDER BY COUNT(TagName) DESC LIMIT 1";


echo '<html><head><title>Menu of Tags</title></head><body bgcolor="#FFFF88">';
echo '<font color="#880000">';
echo '<p>SKILMO';
echo ' - Indie Eyespy, but with skills and crafts and DIY</p></p>';

echo '<p>Here\'s a list of all the disciplines and tags in the database:-</p></p>';
echo '<table cellpadding="0" cellspacing="0">';
echo '<tr><th>Tag</th></tr>';
		
if ($result = mysqli_query($cxn,$query)) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        printf ("<tr><td><a href=\"taginfo.php?tag=%s\"> %s </a></td></tr>", $row[0], $row[1]);
    }

    /* free result set */
$result->close();
}


echo '</font></body></html>';

?>