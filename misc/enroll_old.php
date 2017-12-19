<?php
session_start();
include 'common_table_function.php';
require_once 'menu.php';
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

////////////data section/////////////////////////
$sql_t='select * from user where id=\''.$_SESSION['user'].'\' ';
$result_t=run_query($link,'attendance',$sql_t);
$data_t=get_single_row($result_t);
$t_name=$data_t['name'];

//List lectures
$sql='select * from lecture where teacher_id=\''.$_SESSION['user'].'\' order by date desc';
$result=run_query($link,'attendance',$sql);



if(isset($_POST['lecture_id']))
{
	$sql_lecture='select * from lecture where id=\''.$_POST['lecture_id'].'\'';
	$result_lecture=run_query($link,'attendance',$sql_lecture);
	$row_lecture=get_single_row($result_lecture);

	$sql_ld='select * from lecture where id=\''.$_POST['lecture_id'].'\'';
	$result_ld=run_query($link,'attendance',$sql_ld);
	$row_ld=get_single_row($result_ld);

}

if(isset($_POST['audience']))
{
	$ex=explode('_',$_POST['audience']);
	//my_print_r($ex);
	$count=count($ex);
	if($count==1)
	{
		$sql_student='select * from student where round(id/1000)=\''.$_POST['audience'].'\'';
		echo $sql_student;
		$result_student=run_query($link,'attendance',$sql_student);
		while($row=get_single_row($result_student))
		{	
			$sql_expected='insert into attendance (student_id,lecture_id,expected) 
						values(\''.$row['id'].'\',\''.$_POST['lecture_id'].'\',\'1\')';
			run_query($link,'attendance',$sql_expected);
		}	
	}
	
	if($count==1)
	{
		$sql_student='select * from student where round(id/1000)=\''.$_POST['audience'].'\'';
		echo $sql_student;
		$result_student=run_query($link,'attendance',$sql_student);
		while($row=get_single_row($result_student))
		{	
			$sql_expected='insert into attendance (student_id,lecture_id,expected) 
						values(\''.$row['id'].'\',\''.$_POST['lecture_id'].'\',\'1\')';
			run_query($link,'attendance',$sql_expected);
		}	
	}
}

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
			<div class="col-sm-12 bg-light text-center">	';
				menu();
echo		'</div>
		</div>
		<div class="row">
			<div class="col-sm-12 bg-light">	';
echo 			'<form method=post>';

	echo'			<div class="form-group">
						<h3 class="text-center bg-info">Enroll students in '.$t_name.'\'s Lectures</h3>
					</div>
					<div class="form-group text-center">';
			
										while($row=get_single_row($result))
										{
	echo 				'<button class="btn btn-info" type=submit name=lecture_id value=\''.$row['id'].'\' >';
	echo 					$row['topic'].'<br>'.$row['date'].'<br>'.$row['time'].'<br>'.$row['audience'];
	echo 				'</button>';
										}
echo 				'</div>
				</form>';
echo		'</div>
		</div>
		<div class="row">
			<div class="col-sm-12 bg-light">	';

										if(isset($_POST['lecture_id']))
										{
echo 			'<form method=post>';
echo 				'<div class="form-group">';
echo 					'<h3 class="text-center bg-warning">'.$row_ld['topic'].', '.$row_ld['date'].', '.$row_ld['time'].
								', '.$row_ld['audience'].'</h3>';
echo 				'</div>';
echo 				'<div class="form-group  text-center">';
echo 					'<button class="btn btn-danger" type=submit name=audience value=\''.$row_lecture['audience'].	
							'\'>Enroll All Students of '.$row_lecture['audience'].
						'</button>';
echo 					'<button class="btn btn-dark" type=submit name=audience value=\''.$row_lecture['audience'].	
							'\'>Enroll 1-50 Students of '.$row_lecture['audience'].
						'</button>';
echo 					'<button class="btn btn-dark" type=submit name=audience value=\'B_'.$row_lecture['audience'].	
							'\'>Enroll 51-100 Students of '.$row_lecture['audience'].
						'</button>';
echo 					'<button class="btn btn-dark" type=submit name=audience value=\'C_'.$row_lecture['audience'].	
							'\'>Enroll 101-150 Students of '.$row_lecture['audience'].
						'</button>';
echo 					'<input type=hidden readonly name=lecture_id value=\''.$_POST['lecture_id'].'\'>';
echo 				'</div>';
echo 			'</form>';
										}
echo		'</div>
		</div>
	</div>';	
echo '</body></html>';


?>
