<?php
session_start();
include 'common_table_function.php';
include '/var/gmcs_config/staff.conf';
//my_print_r($GLOBALS);


///////Get Link/////////
$link=get_link($GLOBALS['main_user'],$GLOBALS['main_pass'],'lecturer');

if(!$link){exit(0);}

$ap_verification=verify_ap_user($GLOBALS['main_user'],	$GLOBALS['main_pass'],	'lecturer',
								'attendance',			'user',
								'id',					$_SESSION['user'],
								'password',				$_SESSION['password']);
								
if(!$ap_verification){exit(0);}


////////////data section


$sql='select * from lecture where teacher_id=\''.$_SESSION['user'].'\' order by date desc';
//show_sql($link,'attendance','lecture',$sql);

$result=run_query($link,'attendance',$sql);

if(isset($_POST['lecture_id']))
{
	$sqll='select * from attendance where lecture_id=\''.$_POST['lecture_id'].'\' order by student_id';
	//show_sql($link,'attendance','lecture',$sql);
	$resultt=run_query($link,'attendance',$sqll);
}

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

echo '<form method=post>';
while($row=get_single_row($result))
{
	echo '<button style="text-align:left;" type=submit name=lecture_id value=\''.$row['id'].'\' >';
	my_print_r($row);
	echo '</button>';
}
echo '</form>';


echo '<form method=post>';
while($roww=get_single_row($resultt))
{
	echo '<button style="text-align:left;" type=submit name=lecture_id value=\''.$roww['student_id'].'\' >';
	my_print_r($roww);
	echo '</button>';
}
echo '</form>';

echo '</body></html>';


?>
