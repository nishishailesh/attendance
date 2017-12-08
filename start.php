<?php
session_start();
include 'common_table_function.php';
include '/var/gmcs_config/staff.conf';


////////////login section///////////
$link=get_link($GLOBALS['main_user'],$GLOBALS['main_pass'],'lecturer');

if(!$link){exit(0);}

$ap_verification=verify_ap_user($GLOBALS['main_user'],	$GLOBALS['main_pass'],	'lecturer',
								'attendance',			'user',
								'id',					$_POST['user'],
								'password',				$_POST['password']);
								
if(!$ap_verification){exit(0);}

$_SESSION['user']=$_POST['user'];
$_SESSION['password']=$_POST['password'];

/////////////////////////////////////
echo '<a href="mark_presence.php">Mark Presence</a>';




/////////display section

echo '<html><head>';
echo '<style>
form {margin-bottom:0;}
table {border-collapse: collapse;background-color:#F5DBED}
.recordtable {border-collapse: collapse;border:3px solid black;}
.fld {color:green;font-weight:bold;}
.toprow {color:blue;font-weight:bold;}
.note {color:red;font-weight:bold;}
.button {background-color:lightblue;color:purple;}
td {border:1px solid lightgray;}
</style>';

echo '</head>';
echo '<body>';

echo '</body></html>';

?>
