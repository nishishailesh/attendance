<?php
session_start();
include 'common_table_function.php';
require_once 'menu.php';
include '/var/gmcs_config/staff.conf';
require_once 'common_js.php';

//my_print_r($_POST);
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
$sql_ld='select * from lecture where id=\''.$_POST['lecture_id'].'\'';
$result_ld=run_query($link,'attendance',$sql_ld);
$row_ld=get_single_row($result_ld);
	
	//$sqll='select * from attendance where lecture_id=\''.$_POST['lecture_id'].'\' and expected=\'1\' order by student_id';
	//show_sql($link,'attendance','lecture',$sql);
	//$resultt=run_query($link,'attendance',$sqll);
	
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
		</div>';

/////row start
echo	'<div class="row">
			<div class="col-sm-12 bg-light text-center">	';

						if(isset($_POST['lecture_id']))
						{
							echo '<form method=post>';
echo '
				<div class="form-group">';
echo 				'<h3 class="text-center bg-warning">'.$row_ld['topic'].','.$row_ld['date'].','.$row_ld['time'].','.
						$row_ld['audience'].'</h3>';
echo 			'</div>';
							
echo '						<button class="btn btn-info" type=submit name=enroll_type value=batch>Batch Enrollment</button>';
echo '						<button class="btn btn-info" type=submit name=enroll_type value=individual>Individual Enrollment</button>';
echo 						'<input type=hidden name=lecture_id value=\''.$_POST['lecture_id'].'\'>';  
						}
echo							'</form>';
						
echo		'</div>';
echo'	</div>';
///////row end


/////row start
						if(isset($_POST['lecture_id']) && isset($_POST['enroll_type']))
						{
echo	'<div class="row">
			<div class="col-sm-12 bg-light text-center">	';
							if($_POST['enroll_type']=='batch')
							{
								echo '<form method=post>';
echo '				<div class="form-group">';
echo 					'<h3 class="text-center bg-warning">Select batch to enroll</h3>';
echo 				'</div>';
							
echo '				<div class="form-group">';
							$sql_batch='select * from batch';
							$result_batch=run_query($link,'attendance',$sql_batch);
								while($data_batch=get_single_row($result_batch))
								{
echo 				'<button class="btn btn-info" type=submit name=batch_id value=\''.$data_batch['id'].'\' >';
echo 					'<span class="badge-pill badge-danger">'.$data_batch['name'].'</span><br>'.$data_batch['from_roll_no'].'<br>'.$data_batch['to_roll_no'];
echo 				'</button>';
								
								}
echo 						'<input type=hidden name=lecture_id value=\''.$_POST['lecture_id'].'\'>';  
echo							'</form>';
							}
echo				'</div>';
echo		'</div>';
echo'	</div>';
						}

///////row end
	
/////row start
if(isset($_POST['lecture_id']) && isset($_POST['batch_id']))
{
	$batch_s='select * from batch where id=\''.$_POST['batch_id'].'\'';
	$batch_r=run_query($link,'attendance',$batch_s);
	$batch_d=get_single_row($batch_r);
	
	$err='';
	
	echo '
	<script>function showhide_with_label(one,labell,textt) {
				if(document.getElementById(one).style.display == "none")
				{
					document.getElementById(one).style.display = "block";
					labell.innerHTML="hide "+textt;
				}
				else
				{
					document.getElementById(one).style.display = "none";
					labell.innerHTML="show "+textt;
				}

		}</script>
	<span id=error_sh class="badge-pill badge-danger"
			onclick="showhide_with_label(\'error\',\'error\',this)">error</span><div id=error style="display:none;">';
	for($i=$batch_d['from_roll_no'];$i<=$batch_d['to_roll_no'];$i++)
	{
		$att_s='insert into attendance (student_id,lecture_id,expected) values(
								\''.$i.'\',
								\''.$_POST['lecture_id'].'\',
								\'1\')';
								
		$att_r=run_query($link,'attendance',$att_s);
		
		if(!$att_r)
		{$err=$err.'can not enroll roll number \''.$i.'\' in lecture_id \''.$_POST['lecture_id'].'\'<br>';}
		//else
		//{echo 'enrolled roll number \''.$i.'\' in lecture_id \''.$_POST['lecture_id'].'\'<br>';}
	}
	echo '</div>';
}


///////row end


if(isset($_POST['lecture_id']))
{
//==============enrollment
echo	'<div class="row">';
echo 		'<div class="col-sm-12 bg-light text-center">	';

//---------------------heading
echo '
				<div class="form-group">';
//echo 				'<h3 class="text-center bg-warning">'.$row_ld['topic'].','.$row_ld['date'].','.$row_ld['time'].','.
//						$row_ld['audience'].'</h3>';
echo 				'<h3 class="text-center bg-warning">Current enrollment</h3>';
						
echo 			'</div>';
///-----------------heading end

////---------------enrolled students
echo '				<div class="form-group text-center">';
$sql_ld='select * from lecture where id=\''.$_POST['lecture_id'].'\'';
$result_ld=run_query($link,'attendance',$sql_ld);
$row_ld=get_single_row($result_ld);
	
	$sqll='select * from attendance where lecture_id=\''.$_POST['lecture_id'].'\' and expected=\'1\' order by student_id';
	//show_sql($link,'attendance','lecture',$sql);
	$resultt=run_query($link,'attendance',$sqll);
	
							while($roww=get_single_row($resultt))
							{
								if($roww['present']==0){$style='background-color:red;';}
								elseif($roww['present']==1){$style='background-color:green';}

				$to_jkey=array('student_id','lecture_id','present');
				$to_jval=array($roww['student_id'],$roww['lecture_id'],$roww['present']);
				
				$jkey=htmlspecialchars(json_encode($to_jkey));
				$jval=htmlspecialchars(json_encode($to_jval));

//------------------roll number button			
echo 				'<div style="display:inline" id=\'student_id_'.$roww['student_id'].'\'>
							<button 	class="btn"  
										style=\''.$style.'\'
			onclick="		
			do_work('.$jkey.','.$jval.',\'student_id_'.$roww['student_id'].'\',\'save_presence.php\');"
							
										type=button 
										style="text-align:left;" >';
																	
echo 						'<h1>'.str_pad(($roww['student_id']%1000),3,"0",STR_PAD_LEFT).'</h1>';
echo 					'</button>
					</div>';
//----------------roll number button end					
					
							}
	echo		'</div>';
//---------------enrolled students end

	echo '</div>';
	echo '</div>';
//============enrollement end
}
	
echo '</body></html>';


?>
