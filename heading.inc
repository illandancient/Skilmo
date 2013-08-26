    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
    <link href='skilmo.css' rel='stylesheet' type='text/css'>

<script type="text/javascript">
<!--
dayNames = ["weekend", "weekday", "tuesday", "wednesday", "thursday", "weekend", "weekend"];
dayNumber = new Date().getDay();
document.writeln('<link rel="stylesheet" type="text/css" href="' + dayNames[dayNumber] + '.css">');
//-->
</script>
<noscript>
<link rel="stylesheet" type="text/css" href="skilmo.css">
</noscript>
</head>

<body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-40345475-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

    <div class="claim">SKILMO</br>Like Songkick, but with arts, crafts and skills</div>
    <div class="navigation">
        <?php 
        if(@$_SESSION['auth'] == "yes") {
          /* If logged in, provide one navigation bar, including
             link to the user's specific userpage, if not logged
             in, provide a different nav bar */
          $puserid = @$_SESSION['userid'];
          echo "<a href='index.php'>Home</a> - \n",
               "<a href='userinfo.php?user=$puserid'>Profile</a> - \n",
               "<a href='checklist.php'>Checklist</a> - \n",
               "<a href='tagmenu.php'>Categories</a> - \n",
               "<a href='memberlist.php'>Members</a> -\n",
               "<a href='logout.php'>Log out</a>\n";
        }
        else {
          echo "<a href='index.php'>Home</a> - \n",
               "<a href='checklist.php'>Register</a> -\n",
               "<a href='tagmenu.php'>Categories</a> - \n",
               "<a href='memberlist.php'>Members</a> - \n",
               "<a href='login.php'>Log in</a>\n";
        } ?>
    </div>

