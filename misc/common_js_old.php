<?php

echo '<script>

function run_ajax(str,rid,fname)
{
	//create object
	xhttp = new XMLHttpRequest();
	
	//4=request finished and response is ready
	//200=OK
	//when readyState status is changed, this function is called
	//responceText is HTML returned by the called-script
	//it is best to put text into an element
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById(rid).innerHTML = this.responseText;
	  }
	};

	//Setting FORM data
	xhttp.open("POST", fname, true);
	
	//Something required as header
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	// Submitting FORM
	xhttp.send(str);
	
	//used to debug script
	//alert("Used to check if script reach here");
}

function make_post_string(student_id,lecture_id,present)
{
	sid=encodeURIComponent(student_id);					//to encode almost everything
	lid=encodeURIComponent(lecture_id);					//to encode almost everything
	pre=encodeURIComponent(present);					//to encode almost everything
	post=\'student_id=\'+sid+\'&lecture_id=\'+lid+\'&present=\'+pre;
	return post;						
}

function do_work(student_id,lecture_id,pre,div_id,fname)
{
	str=make_post_string(student_id,lecture_id,pre);
	//alert(post);
	run_ajax(str,div_id,fname);
}

</script>

';


?>
