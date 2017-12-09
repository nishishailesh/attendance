<?php
	function menu()
	{
		echo '<div class="row">
				<div class="col-sm-12">';
					echo '<h3 class="text-danger text-center  bg-dark">Attendance Marking System</h3>';
		echo 	'</div>
			</div>';
		
		echo '<div class="row jumbotron mx-auto"><ul class="nav nav-pills nav-justified">';
		
		echo '<div class="col-*-6">';
		echo '			<li class="nav-item">';
		echo 			'<a class="nav-link active" href="enroll.php">Enroll Students</a>';		
		echo 		'</li>';
		echo '</div>';
		
		echo '<div class="col-*-6">';		
		echo '			<li class="nav-item">';
		echo 			'<a class="nav-link active" href="mark_presence.php">Mark Presence</a>';
		echo 		'</li>';
		echo '</div>';

		echo '</ul></div>';
		
	}
?>


