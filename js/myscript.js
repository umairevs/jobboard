var $j = jQuery.noConflict();
// $jj is now an alias to the jQuery function; creating the new alias is optional.
 

function validate_adduser(id){ 
	$j('#signup_form').unbind('submit');

		var options = {

		target: '',

		beforeSubmit: validate_adduser_Request,

		success: validate_adduser_Response,

		url: JS_SERVER_PATHROOT+'request_process.php?calling='+id
	};

	// bind to the form's submit event

	$j('#signup_form').submit(function() {

		$j(this).ajaxSubmit(options);

		return false;

	});

}

// pre-submit callback
function validate_adduser_Request(formData, jqForm, options)
{
	$('#preloader_div').html('<img src="'+JS_SERVER_PATHROOT+'images/loading.gif" />');
	
	var queryString = $j.param(formData);
	return true;
}

function validate_adduser_Response(responseText, statusText)
{
	$('#preloader_div').html('');
	if(responseText.search('done') != -1) 
	{ 
		alert("User added successfully");
		window.location.href = JS_SERVER_PATHROOT+"signup";
	}
	else
	if(responseText.search('step1') != -1)
			 {
				responseText = responseText.replace("step1", ""); 
				if(responseText!="")
				{
					alert(responseText);
				}
				
				$j("#step1").show();
				$j("#step2").hide();
				$j("#button_1").show();
				$j("#button_2").hide();
				$j("#employer_signin").hide();
				
				
	   }
	   else
	   if(responseText.search('step2') != -1)
	   {
		
			responseText = responseText.replace("step2", ""); 
			if(responseText!="")
			{ 
				alert(responseText);
			}

			$j("#step2").show();
			$j("#step1").hide();
			$j("#button_2").show();
			$j("#button_1").hide();
			$j("#employer_signin").show();
			
		
		}
	   else
	   if(responseText.search('step3') != -1)
	   {
			 responseText = responseText.replace("step3", ""); 
			 
			 $j("#jobseeker_register").hide();
			 $j("#success_message").show();
			 $j("#employer_signin").hide();
			 
			 document.getElementById("display_success_message").innerHTML = responseText;  
			
	   }
	 
} 

function validate_add(id){ 
	$j('#signup_form').unbind('submit');

		var options = {

		target: '',

		beforeSubmit: validate_add_Request,

		success: validate_add_Response,

		url: JS_SERVER_PATHROOT+'request_process.php?calling='+id
	};

	// bind to the form's submit event

	$j('#signup_form').submit(function() {

		$j(this).ajaxSubmit(options);

		return false;

	});

}

// pre-submit callback
function validate_add_Request(formData, jqForm, options)
{
	$('#preloader_div').html('<img src="'+JS_SERVER_PATHROOT+'images/loading.gif" />');
	$('#button1').hide();
	var queryString = $j.param(formData);
	return true;
}

function validate_add_Response(responseText, statusText)
{
	$('#preloader_div').html('');
	$('#button1').show();
	
	if(responseText.search('done') != -1) 
	{ 
		myarray = new Array();
		myarray = responseText.split('-SEPARATOR-');
		
		window.location.href = myarray[1];
	}
	else
	if(responseText.search('gotonext') != -1) 
	{ 
		myarray = new Array();
		myarray = responseText.split('-SEPARATOR-');
		
		window.location.href = myarray[1];
	}
	else
	{
		alert(responseText)	
	}
} 

function login_with(val)
{
	if(val==1)
	{
		$j('#employer_signin').show();
	}
	else
	{
		$j('#employer_signin').hide();	
	}
}


 function get_category(type_id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/get_category.php",
            data: { type_id : type_id } 
        }).done(function(data){
            $j("#category_data").html(data);
			$j("#category_data").show();
			$j("#display_subcat").show();
			
			
        });
  }
  
  function get_state(id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/get_state.php",
            data: { country_id : id } 
        }).done(function(data){
            $j("#state_div").html(data);
			$j("#state_div").show(); 
        });
		
		 $j("#city_div").html('<select class="form-control"  name="state" style="width:100%;"><option value="">City</option></select>');
  }
  
  
  
  
   function get_state_jobs(id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/get_state_jobs.php",
            data: { country_id : id } 
        }).done(function(data){
            $j("#state_div").html(data);
			$j("#state_div").show(); 
        });
		
		 $j("#city_div").html('<select class="form-control"  name="state" style="width:100%;"><option value="">City</option></select>');
  }
  
  
  function delete_account()
  {
	  msg = confirm("Are you sure, You want to delete this account?");
	  if(msg)
	  {
		 $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/seeker_delete_account.php",
            data: { pass : 'yes' } 
        }).done(function(data){
				
				if(data.search('done') != -1) 
				{ 
					myarray = new Array();
					myarray = data.split('-SEPARATOR-');
					
					alert(myarray[2]);
					window.location.href = myarray[1];
				}
				else
				{
					alert(data);
				}
           
        });


		  
	  }
  }
  
    function get_city(s_id, c_id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/get_city.php",
            data: { country_id : c_id, state_id : s_id } 
        }).done(function(data){
            $j("#city_div").html(data);
			$j("#city_div").show(); 
        });
  }
  
  function get_city_jobs(s_id, c_id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/get_city_jobs.php",
            data: { country_id : c_id, state_id : s_id } 
        }).done(function(data){
            $j("#city_div").html(data);
			$j("#city_div").show(); 
        });
  }
  
  function delete_bookmark(id)
  {
	  
	   var con = confirm("Are you sure you want to remove this job from Bookmark list?");
	   if(con)
	   {
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/delete_bookmark.php",
            data: { id : id} 
        }).done(function(data)
		{
			if(data.search('done') != -1) 
			{ 
				myarray = new Array();
				myarray = data.split('-SEPARATOR-');
				
				window.location.href = myarray[1];
			}
			else
			{
				alert(data)	
			}
           
        });
	   }
  	
  }
  
   function delete_job(id){
	   var con = confirm("Are you sure you want to delete this job?");
	   if(con)
	   {
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"process/delete_job.php",
            data: { id : id} 
        }).done(function(data)
		{
			if(data.search('done') != -1) 
			{ 
				myarray = new Array();
				myarray = data.split('-SEPARATOR-');
				
				window.location.href = myarray[1];
			}
			else
			{
				alert(data)	
			}
           
        });
	   }
  }
  
  function uncheck()
  {
	$('input[name="days_list"]').attr('checked', false);	 
	$('#uncheck').hide();
  }
  
   function apply_for_job(id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"applyjob",
            data: { job_id : id } 
        }).done(function(data){
			if(data.search('done') != -1) 
			{ 
				myarray = new Array();
				myarray = data.split('-SEPARATOR-');
				
				$("#job_"+myarray[1]).hide(); 
				$("#success_"+myarray[1]).html(myarray[2]); 
				$("#success_"+myarray[1]).show(); 
				
			}
			else
			if(data.search('gotonext') != -1) 
			{ 
				myarray = new Array();
				myarray = data.split('-SEPARATOR-');
				alert(myarray[2]);
				window.location.href = myarray[1];
			}
			else
			{
				alert(data);	
			}
            
        });
		
  }
  
  function bookmark_job(id){
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT+"bookmark",
            data: { job_id : id } 
        }).done(function(data){
			if(data.search('done') != -1) 
			{ 
				myarray = new Array();
				myarray = data.split('-SEPARATOR-');
				
				
				$("#bookmark").html(myarray[1]); 
				$("#bookmark").show(); 
				
			}
			else
			{
				alert(data);	
			}
            
        });
		
  }