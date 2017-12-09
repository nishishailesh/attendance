<?php
session_start();
echo '<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">		
	</head>
  <body>
	<div class="container-fluid">
		<div class="col-sm-8 mx-auto">';
echo '</head>';
echo '<body>';

include 'common_table_function.php';
require_once 'menu.php';
require_once 'common_js.php';
include '/var/gmcs_config/staff.conf';
//my_print_r($GLOBALS);


///////Get Link and verify application user /////////
$link=get_link($GLOBALS['main_user'],$GLOBALS['main_pass'],'lecturer');

if(!$link){exit(0);}

$ap_verification=verify_ap_user($GLOBALS['main_user'],	$GLOBALS['main_pass'],	'lecturer',
								'attendance',			'user',
								'id',					$_SESSION['user'],
								'password',				$_SESSION['password']);
								
if(!$ap_verification){exit(0);}

echo '	<div class="container-fluid mx-auto">
		<div class="row">
			<div class="col-sm-12 bg-light">';	
				menu();
echo '</div></div><div class="row">
			<div class="col-sm-12 bg-light">';
			
////////////data section
$sql_t='select * from user where id=\''.$_SESSION['user'].'\' ';
$result_t=run_query($link,'attendance',$sql_t);
$data_t=get_single_row($result_t);
$t_name=$data_t['name'];


$sql='select * from lecture where teacher_id=\''.$_SESSION['user'].'\' order by date desc';
//show_sql($link,'attendance','lecture',$sql);

$result=run_query($link,'attendance',$sql);
echo '<form method=post>';
echo '
		<div class="form-group">
			<h3 class="text-center bg-info">'.$t_name.'\'s Lectures</h3>
		</div>
		<div class="form-group">';
		
while($row=get_single_row($result))
{
	echo '<button class="btn btn-info" type=submit name=lecture_id value=\''.$row['id'].'\' >';
	echo $row['topic'].'<br>'.$row['date'].'<br>'.$row['time'].'<br>'.$row['audience'];
	echo '</button>';
}
echo '</div>';
echo '</form>';

echo '</div><div class="row">
			<div class="col-sm-12 bg-light">';

if(isset($_POST['lecture_id']))
{
$sql_ld='select * from lecture where id=\''.$_POST['lecture_id'].'\'';
$result_ld=run_query($link,'attendance',$sql_ld);
$row_ld=get_single_row($result_ld);
	
	$sqll='select * from attendance where lecture_id=\''.$_POST['lecture_id'].'\' and expected=\'1\' order by student_id';
	//show_sql($link,'attendance','lecture',$sql);
	$resultt=run_query($link,'attendance',$sqll);
echo '
		<div class="form-group">
			<h3 class="text-center bg-warning">';
echo 	'<h3 class="text-center bg-warning">'.$row_ld['topic'].','.$row_ld['date'].','.$row_ld['time'].','.$row_ld['audience'].'</h3>';
echo '</div>
		<div class="form-group text-center">';
	while($roww=get_single_row($resultt))
	{
		if($roww['present']==0){$style='background-color:red;';}
		elseif($roww['present']==1){$style='background-color:green';}
			
		echo '<div style="display:inline" id=\'student_id_'.$roww['student_id'].'\'>
						<button class="btn"  style=\''.$style.'\' onclick="do_work(
									\''.$roww['student_id'].'\',
									\''.$roww['lecture_id'].'\',
									\''.$roww['present'].'\',
									\'student_id_'.$roww['student_id'].'\')" 
						type=button style="text-align:left;" >';					
		echo '<h1>'.str_pad(($roww['student_id']%1000),3,"0",STR_PAD_LEFT).'</h1>';
		echo '</button></div>';
	}
	echo '</form></div></div>';	
}

/////////display section





echo 	'</div></div>';
echo '</body></html>';


?>
