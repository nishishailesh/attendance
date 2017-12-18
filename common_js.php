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

function make_post_string(key,value)
{
	var ret=\'\';
	for(var x=0;x<key.length;x++){
					ret=ret+encodeURIComponent(key[x])+\'=\'+encodeURIComponent(value[x])+\'&\';
					//ret=ret+key[x]+value[x];
					}		
	//alert(ret);				
	return ret;						
}

function do_work(key,value,div_id,fname)
{
	str=make_post_string(key,value);
	run_ajax(str,div_id,fname);
}


function showhide_with_label(one,labell,textt) {
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

	}
</script>

';


?>
