<?php 
@ob_start();
include("common/top.php")
?>
<style>
	body
	{
		font-family:Arial, Helvetica, sans-serif;
	}
	
	tr
	{
		margin-bottom:18px;
		float:left;
		clear:both;
		width:100%;
	}
	
	h2
	{
	font-size:18px;
	}
	
	h4
	{
	font-size:14px;
	}
	
	strong
	{
		font-size:14px;
	}	
</style>
<?php				

 header("Content-type: application/msword");
 header("Content-Disposition: attachment; Filename=SaveAsWordDoc.doc");
	
    echo "<html>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
	//include("common/top_script.php");
    echo "<body>";
 	?>
    
     <table width="100%" style="border:none;">
     <tr style="margin-bottom:10px;"><td width="15%"><img src="http://demo.evsoft.pk/jobboard/media/user_images/679527421_14572937.jpg" class="img-responsive" title="Susie Queue" width="151" height="120"></td>
     <td><h2>Farhan Saeed</h2>
     <p>Address: Office#22, street 2, Alaska<br> 
     Phone: (213) 555-1234 <br> 
     Email:<a> evs.tester@gmail.com</a>
     </p></td></tr>
     
     <tr><td colspan="2">
     <h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/career.png" style="height:20px;" /> &nbsp; Career Objective:</h2>
     <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
     </td></tr>
     
      <tr><td colspan="2">
     <h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/work_history.png" style="height:20px;" /> &nbsp; Work History:</h2>
    <ul>
                                                                        <li>
				        		<h4>Software engineer @ B Brainz <span>2010-01-02 - 2012-01-02</span></h4>
				        		<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			        		</li>
                                                                                                <li>
				        		<h4>Software engineer @ EVS <span>2012-01-03 - 2012-01-02</span></h4>
				        		<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			        		</li>
                                                                                                
			        			
			        	</ul>
     </td></tr>
     
     
     <tr><td colspan="2">
     <h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/education.png" style="height:20px;" /> &nbsp; Education Background:</h2>
   <ul>
							                                    <li>
								<h4>Matric @ School 7</h4>
								<ul>
									<li>Year: <span>2002 - 2004</span> </li>
								</ul>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</li>
                                                                        <li>
								<h4>BCS @ Comsats</h4>
								<ul>
									<li>Year: <span>2004 - 2008</span> </li>
								</ul>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</li>
                                                                
							
						</ul>
     </td></tr>
     
     
      <tr><td width="100%" colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/qualification.png" style="height:20px;" /> &nbsp; Special Qualification:</h2>
						Special Qualification Special Qualification   
     
     </td></tr>
     
     
  
      <tr><td colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/language.png" style="height:20px;" /> &nbsp; Language Proficiency:</h2>
		<p>English: 4/5, English: 4/5, English: 4/5</p>
        
     
     </td></tr>
     
     
     <tr><td colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/personal.png" style="height:20px;" /> &nbsp; Personal Deatils:</h2>
		<ul class="address">
				            <li><strong>Full Name</strong> : Susie Queue</li>
				            <li><strong>Father's Name</strong> : Robert Doe</li>
				            <li><strong>Mother's Name</strong> : Smith</li>
				            <li><strong>Date of Birth</strong> : 1987-03-22</li>
				            <li><strong>Birth Place</strong>  : United states</li>
				            <li><strong>Nationality</strong> : Canadian</li>
				            <li><strong>Sex</strong> : Male</li>
				            <li><strong>Address</strong> : Office#22, street 2, Alaska</li>
				        </ul>
                        
     
     </td></tr>
     
     
      <tr><td width="100%" colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/declaration.png" style="height:20px;" /> &nbsp; Declaration:</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
     
     </td></tr>
     
     
     
     </table>           
    <?php
    echo "</body>";
    echo "</html>";
 exit();
?>
