<?php 
include("top.php");

?>
<!-- script for auto search -->
				<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#skills" ).autocomplete({
      source: 'autocomplete_search.php'
	 
    });
  });
  </script>
  <!-- end of auto search -->
  

<div class="banner-job">
		<div class="banner-overlay"></div>
		<div class="container text-center">
			<h1 class="title">The Easiest Way to Get Your New Job</h1>
			<h3>We offer 12000 jobs vacation right now</h3>
			<div class="banner-form banner-form-full job-list-form">
					<form action="<?php echo SERVER_ROOTPATH;?>job-list" method="post">
					<!-- category-change -->
					

					
						
					<input type="text"  id="skills" class="form-control"  placeholder="Type your keyword " name="keyword" value="<?php echo $_SESSION['search']['keyword'];?>" style="margin-left: 0px; width: 92%; background-color:white; border-radius:0;">

					<div id="livesearch"></div>
					<div class="clear_screen"></div>
                    <button type="submit" class="btn btn-primary" value="Search" name="submit_search">Search</button>
				</form>
                
			</div><!-- banner-form -->
			
			
		</div><!-- container -->
	</div>
	
	