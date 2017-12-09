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
				<form method=post action=start.php>
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
