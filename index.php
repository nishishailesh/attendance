<?php
session_start();

/* required files: 
-rw-r--r-- 1 root root  4035 Dec 18 19:03 attendance_blank_db.sql
drwxr-xr-x 4 root root  4096 Dec 10 09:43 bootstrap
-rw-r--r-- 1 root root  1477 Dec 17 16:09 common_js.php
-rw-r--r-- 1 root root 21710 Dec 10 09:43 common_table_function.php
-rw-r--r-- 1 root root  9751 Dec 18 18:37 enroll.php
-rw-r--r-- 1 root root  1348 Dec 18 18:55 index.php
-rw-r--r-- 1 root root   441 Dec 17 14:16 menu.php
-rw-r--r-- 1 root root  1581 Dec 12 16:58 save_presence.php
-rw-r--r-- 1 root root  1015 Dec 18 19:13 staff.conf.example

put bootstrep files(only css needed) in bootstrep folder of project root
 
create database attendance
import blank database
create users with encrypt(password)
Add lectures
Add students
Add batches

*/
 
if(isset($_SESSION['user']))
{
	unset($_SESSION['user']);
	unset($_SESSION['password']);
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">		
	</head>
  <body>
	<div class="container-fluid" style="padding:100px;">
		<div class="row">
			<div class="col-sm-3 bg-light mx-auto">
				<!--<form method=post action=start.php>-->
				<form method=post action=enroll.php>
					<div class="form-group">
						<h3 class="text-danger text-center  bg-dark">Attendance Marking System</h3>
					</div>
					<div class="form-group">
						<label for=user>Username</label>
						<input  class="form-control" id=user type=text name=user>
					</div>
					<div class="form-group">						
						<label for=password>Password</label>
						<input  class="form-control" id=password type=password name=password>
					</div>
					<div class="form-group">						
						<button class="btn btn-primary btn-block" name=login>Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>		</div>
  </body>
</html>
