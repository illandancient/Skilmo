<?
$COM_CONF['site_url'] = "http://chrisgilmour.co.uk";  // Without trailing slash

$COM_CONF['dbhost'] = "cust-mysql-123-05";
$COM_CONF['dbuser']="uchr_907455_0001@10.15.11.144";
$COM_CONF['dbpassword']="Ty6+w5*X";
$COM_CONF['dbname']="chrisgilmourcouk_907455_db1";
$COM_CONF['dbtablespreffix'] = "comments_";
$COM_CONF['dbmaintable'] = "{$COM_CONF['dbtablespreffix']}data";
$COM_CONF['dbemailstable'] = "{$COM_CONF['dbtablespreffix']}subscribes";
$COM_CONF['dbbannedipstable'] = "{$COM_CONF['dbtablespreffix']}banned";
$COM_CONF['dbjunktable'] = "{$COM_CONF['dbtablespreffix']}junk";

$COM_CONF['script_dir'] = "/comments";
$COM_CONF['admin_name'] = "illandancient";
$COM_CONF['admin_passw'] = "gilmour";
$COM_CONF['email_admin'] = "illandancient@googlemail.com";
$COM_CONF['email_from'] = "illandancient@googlemail.com";
$COM_CONF['admin_script_url']="{$COM_CONF['script_dir']}/admin.php";

$COM_CONF['script_url']="{$COM_CONF['script_dir']}/comments.php";
$COM_CONF['template']="default";
$COM_CONF['lang']="en";
$COM_CONF['sort_order']="desc";      // If you want newest comments at the beginig use "desc"
                 // otherwise leave blank

$COM_CONF['anti_flood_pause'] = '60';  // in seconds

$COM_CONF['akismet_apikey'] = "";
$COM_CONF['check_for_spam'] = 0;

// Possible values '', 'recaptcha', 'akismet'
$COM_CONF['check_for_spam_method'] = "";
$COM_CONF['recaptcha_publickey'] = "";
$COM_CONF['recaptcha_privatekey'] = "";

$COM_CONF['copy_random_seed'] = "mLrniRFMx8"; // Was generated during install.
                         // Using in email notifications for unsubscribing.
                         // Don't change it!
?>