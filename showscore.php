<?php
  $sniff = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    if ($sniff == true){
    $browser = 'iphone';
  }
  $sniff = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    if ($sniff == true){
    $browser = 'Android';
  }
  $sniff = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    if ($sniff == true){
    $browser = 'iPad';
  }

?>
<html>
  <head>
    <title>London Indiepop Eyespy - Show Score</title>
    <meta name="description"
      content="A game of celebrity spotting in the London Indiepop music scene" />
    <meta name="keywords"
      content="London, indiepop, live music, celebrities, gigs" />
    <meta http-equiv="author"
      content="Christopher David Gilmour" />
    <meta http-equiv="pragma"
      content="no-cache" />
<?php if($browser == 'iphone'){ ?>
    <meta name="viewport"
      content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<?php } ?>
<?php if($browser == 'Android'){ ?>
    <link href="androideyespy.css" type="text/css"
      rel="stylesheet" />
<?php }else{ ?>
    <link href="eyespy.css" type="text/css"
      rel="stylesheet" />
<?php } ?>
  </head>
  <body>

  <h2>London Indiepop Eyespy<br>Highscores</h2>
  <div class="league">
<?php
include 'dbstuff.inc';

$spyerid = $_GET['spyer'];
$score = 0;

if (!is_numeric($spyerid)) {
  $spyerid = 14;
}

$spyerdatequery = "SELECT DATE_FORMAT(eyespylog.DateTimeAdded, '%d-%b-%Y') "
                . "FROM eyespylog WHERE eyespylog.SpyerID = '$spyerid' LIMIT 1";

if ($spyerdateresult = mysqli_query($cxn, $spyerdatequery)) {
  while ($spyerdate = $spyerdateresult->fetch_row()) {
    echo "$spyerdate[0] <br>";
  }
}

$spyernamequery = "SELECT eyespyspyers.SpyerName "
                . "FROM eyespyspyers "
                . "WHERE eyespyspyers.SpyerID = '$spyerid' ";

if ($spyernameresult = mysqli_query($cxn, $spyernamequery)) {
  while ($spyername = $spyernameresult->fetch_row()) {
    echo "\n$spyername[0] scored";
  }
}

$spyerscorequery = "SELECT SUM(eyespylog.SpyeeScore) AS Score "
                 . "FROM eyespylog "
                 . "WHERE eyespylog.SpyerID = '$spyerid'";

if ($spyerscoreresult = mysqli_query($cxn, $spyerscorequery)) {
  while ($spyerscore = $spyerscoreresult->fetch_row()) {
    echo " $spyerscore[0] points by spying <br><br> ";
    $score = $spyerscore[0];
  }
}

$spyeelistquery = "SELECT CONCAT(eyespypeople.ScreenName, ' - ', eyespybands.BandName) "
                . "FROM eyespylog "
                . "LEFT JOIN eyespypeoplebands "
                . "ON SUBSTRING(eyespylog.SpyeeID, 4) = eyespypeoplebands.PeopleBandID "
                . "LEFT JOIN eyespypeople "
                . "ON eyespypeoplebands.PersonID = eyespypeople.PersonID "
                . "LEFT JOIN eyespybands "
                . "ON eyespypeoplebands.BandID = eyespybands.BandID "
                . "WHERE eyespylog.SpyerID = '$spyerid' "
                . "AND SUBSTRING(eyespylog.SpyeeID, 1, 3) = 'pbp' ";

if ($result = mysqli_query($cxn, $spyeelistquery)) {
  while ($spyeeinfo = $result->fetch_row()) {
    echo "\n $spyeeinfo[0] <br>";
  }
}
echo "\n\n";
?>
</div>
<div class="score">
  <div id="custom-tweet-button">
    <a href="https://twitter.com/intent/tweet?text=I scored <?php
     echo $score; 
     ?> points in %23LondonIndiepopEyespy http%3A%2F%2Fchrisgilmour.co.uk%2Fshowscore.php?spyer=<?php echo $spyerid;?>"
     title="Tweet This"
     target="_blank"
     rel="nofollow">Tweet your score</a> 
  </div>
</div>
<div class="league">
  <a href="http://chrisgilmour.co.uk/londonindiepopeyespy.php">Back to London Indiepop Eyespy</a>
</div>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=8393916; var sc_invisible=1; var sc_security="0e12c866"; 
</script>
<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="hits counter"
href="http://statcounter.com/free-hit-counter/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/8393916/0/0e12c866/0/"
alt="hits counter"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

  </body>
</html>