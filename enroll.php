<?php
session_start();
include 'common_table_function.php';
require_once 'menu.php';
include '/var/gmcs_config/staff.conf';


echo '<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">		
	</head>
  <body>
	<div class="container-fluid" style="padding:100px;">
		<div class="row">';
echo '</head>';
echo '<body>';


//my_print_r($GLOBALS);


///////Get Link and verify application user /////////
$link=get_link($GLOBALS['main_user'],$GLOBALS['main_pass'],'lecturer');

if(!$link){exit(0);}

$ap_verification=verify_ap_user($GLOBALS['main_user'],	$GLOBALS['main_pass'],	'lecturer',
								'attendance',			'user',
								'id',					$_SESSION['user'],
								'password',				$_SESSION['password']);
								
if(!$ap_verification){exit(0);}

menu();
////////////data section

//List lectures
$sql='select * from lecture where teacher_id=\''.$_SESSION['user'].'\' order by date desc';
//show_sql($link,'attendance','lecture',$sql);
$result=run_query($link,'attendance',$sql);
echo '<form method=post>';
while($row=get_single_row($result))
{
	echo '<button style="text-align:left;" type=submit name=lecture_id value=\''.$row['id'].'\' >';
	my_print_r($row);
	echo '</button>';
}
echo '</form>';


if(isset($_POST['lecture_id']))
{
	$sql_lecture='select * from lecture where id=\''.$_POST['lecture_id'].'\'';
	$result_lecture=run_query($link,'attendance',$sql_lecture);
	$row_lecture=get_single_row($result_lecture);
	echo '<form method=post>';
	echo '<button type=submit name=audience value=\''.$row_lecture['audience'].'\'>All Students of '.$row_lecture['audience'].'</button>';
	echo '<input type=text readonly name=lecture_id value=\''.$_POST['lecture_id'].'\'>';
	echo '</form>';
}

if(isset($_POST['audience']))
{
	$sql_student='select * from student where round(id/1000)=\''.$_POST['audience'].'\'';
	echo $sql_student;
	$result_student=run_query($link,'attendance',$sql_student);
	while($row=get_single_row($result_student))
	{
		//echo '<button style="text-align:left;" type=submit name=lecture_id value=\''.$row['id'].'\' >';
		//my_print_r($row);
		//echo '</button>';
		
		$sql_expected='insert into attendance (student_id,lecture_id,expected) 
					values(\''.$row['id'].'\',\''.$_POST['lecture_id'].'\',\'1\')';
		run_query($link,'attendance',$sql_expected);
	}	
}

/////////display section







echo 	'</div>';
echo '</body></html>';


?>
