<?php
session_start();
include 'common_table_function.php';
include '/var/gmcs_config/staff.conf';
require_once 'menu.php';


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





/////////display section
echo '<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">		
	</head>
  <body>
	<div class="container-fluid">
		<div class="row">
		<div class="col-sm-8 mx-auto">';
menu();
echo 	'</div></div></div>';
echo '</body></html>';

?>
