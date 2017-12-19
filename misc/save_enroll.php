<?php
session_start();
include 'common_table_function.php';
include '/var/gmcs_config/staff.conf';

///////Get Link and verify application user /////////
$link=get_link($GLOBALS['main_user'],$GLOBALS['main_pass'],'lecturer');

if(!$link){exit(0);}

$ap_verification=verify_ap_user($GLOBALS['main_user'],	$GLOBALS['main_pass'],	'lecturer',
								'attendance',			'user',
								'id',					$_SESSION['user'],
								'password',				$_SESSION['password']);
								
if(!$ap_verification){exit(0);}
////////////////


//my_print_r($_POST);

    
	if($_POST['present']==0){$change_to=1;}
	elseif($_POST['present']==1){$change_to=0;}
	
	$sql='update attendance set present=\''.$change_to.'\' where 
				student_id=\''.$_POST['student_id'].'\' and 
				lecture_id=\''.$_POST['lecture_id'].'\'';
	$ret=run_query($link,'attendance',$sql);
	
	//echo $_POST['student_id'].'<br>'.$_POST['lecture_id'].'<br>'.$_POST['present'].'-'.$ret;
	//echo $_POST['student_id'].'<br>'.$_POST['lecture_id'].'<br>'.$_POST['present'].'-'.$ret;


		if($change_to==0){$style='background-color:red;';}
		elseif($change_to==1){$style='background-color:green';}
			
		echo '
						<button class="btn"  style=\''.$style.'\' onclick="do_work(
									\''.$_POST['student_id'].'\',
									\''.$_POST['lecture_id'].'\',
									\''.$change_to.'\',
									\'student_id_'.$_POST['student_id'].'\',
									\'save_enroll.php\')" 
						type=button style="text-align:left;" >';
						
												
		echo '<h1>'.str_pad(($_POST['student_id']%1000),3,"0",STR_PAD_LEFT).'</h1>';
		echo '</button>';
	
?>
