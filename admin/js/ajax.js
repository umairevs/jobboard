 function makeRequest4(url,obj)
	{  
		showobj2=obj;
		var http_request = false;
		if (window.XMLHttpRequest) 
		{ // Mozilla, Safari, ...
		  http_request = new XMLHttpRequest();
			if (http_request.overrideMimeType) 
			{
				http_request.overrideMimeType('text/xml');
				// See note below about this line
			}
		} 
	
		else if (window.ActiveXObject) 
		{ // IE
			try 
			{
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			} 
	
			catch (e) 
			{
				try 
				{
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			}
		}
	
		if (!http_request) 
		{
			alert('Giving up :( Cannot create an XMLHTTP instance');
			return false;
		}
	
		http_request.onreadystatechange = function() { alertContents4(http_request,obj); };
		http_request.open('GET', url, true);
		http_request.send(null);
	}



	function alertContents4(http_request,obj) 	
	{
		if (http_request.readyState == 4) 
		{
			if (http_request.status == 200) 
			{	
				
				document.getElementById(obj).innerHTML = http_request.responseText;
			}
			else 
			{
				alert('There was a problem with the request.');
			}
		}
	}
	
//------------------------------------------------------------------------
			   //  admin site function 
//-----------------------------------------------------------------------
		
function popCountry(countryId)
	{
	 if(countryId!='')
		{    
		   //document.getElementById('hide').style.display='none';
			var myRandom = parseInt(Math.random()*99999999);
			url = "ajax_php/ajax.php?countryId="+encodeURI(countryId)+"&rand="+myRandom;
			makeRequest4(url,'statediv');
		}
	}
	
	
function popState(stateId)
	{
		
		if(stateId!='')
		{   
		    
			//document.getElementById('hide').style.display='none';
			var myRandom = parseInt(Math.random()*99999999);
			url = "ajax_php/ajax.php?stateId="+encodeURI(stateId)+"&rand="+myRandom;
			makeRequest4(url,'citydiv');
		}
	}	
	
function show_industry(i_type)
{
	
	if(i_type!='')
	{   
		if(i_type=='sector_s'){
			document.getElementById('showind').style.display='none';
			document.getElementById('showcom').style.display='none';
		}else{
			document.getElementById('showind').style.display='';
			document.getElementById('showcom').style.display='';
			
			var myRandom = parseInt(Math.random()*99999999);
			url = "ajax_php/ajax.php?i_type="+encodeURI(i_type)+"&rand="+myRandom;
			//alert(url);
			makeRequest4(url,'industrydiv');
		}
	}
}

function show_emaillist()
{
	var checkmail_f = document.getElementById('checkmail').value;
	var industry_f = document.getElementById('industry').value;
	var company_f = document.getElementById('company').value;
	
	if(checkmail_f!='')
	{   
		var myRandom = parseInt(Math.random()*99999999);
		url = "ajax_php/ajax.php?checkmail_f="+encodeURI(checkmail_f)+"&industry_f="+encodeURI(industry_f)+"&company_f="+encodeURI(company_f)+"&rand="+myRandom;
		//alert(url);
		makeRequest4(url,'show_alist');
	}
}


function show_company(i_id)
{
	
	if(i_id!='')
	{   
		
		//document.getElementById('hide').style.display='none';
		var myRandom = parseInt(Math.random()*99999999);
		url = "ajax_php/ajax.php?i_id="+encodeURI(i_id)+"&rand="+myRandom;
		//alert(url);
		makeRequest4(url,'companydiv');
	}
}	
	

//------------------------------------------------------------------------
			   //  Client side Function
//-----------------------------------------------------------------------


function manage_bank(id)

{


	$('#frmbank').unbind('submit');

	var options = {

	target: '', 				// target element(s) to be updated with server response

	beforeSubmit: validate_bank_account_Request, 	

	success: show_bank_account_frm_Response, 		

	url: 'request_process.php?calling='+id

	};

	$('#frmbank').submit(function() {

		$(this).ajaxSubmit(options);

		return false;

	});
	
}

function validate_bank_account_Request(formData, jqForm, options)

{

	var queryString = $.param(formData);	

	document.getElementById("loader1").innerHTML = '<img src=img/loading.gif>'; 

	$("#bank_button").hide();

	return true;



}



function show_bank_account_frm_Response(responseText, statusText)

{

	document.getElementById("loader1").innerHTML = '';

	$("#bank_button").show();

	if(responseText.search('done') != -1)

	{

		//alert(responseText);

		myarray = new Array();

		myarray = responseText.split('-SEPARATOR-');

		window.location.href = myarray[1];

	}

	else

	{

				//alert(responseText);

				$('#error_div').fadeIn("slow");

				$('#error_div').html('');

				$('#error_div').html(responseText);

				$('html, body').animate({scrollTop:100}, 'slow');

	}

	

}


	
function get_state_dropdown(value)

{

	if(value !='')

	{

	$.ajax({

		   type: "POST",

		   url: 'request_process.php?calling=4',  

		   data: 'country_id='+value,



		   beforeSend: function(){

		   },

		   success: function(data){

			

			$('#part').css({'display' : 'none'});

			$('#parts').css({'display' : ''});

			document.getElementById('parts').innerHTML = data;  

			$(".parts").html(data);

			},

			error: function() {

			}

		 });

		 

		}

		 else

		{

		$('#parts').css({'display' : 'none'});

		}	

}	

	