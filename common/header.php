<header id="header" class="clearfix">
		<!-- navbar -->
		<nav class="navbar navbar-default">
			<div class="container">
				<!-- navbar-header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo SERVER_ROOTPATH;?>"><img class="img-responsive" src="<?php echo SERVER_ROOTPATH;?>images/logo.png" alt="Logo"></a>
				</div>
				<!-- /navbar-header -->
				
				<div class="navbar-left">
					<div class="collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav navbar-nav">	
							<li <?php if($current_File=='index.php'){?>class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>">Home</a></li>
							<li <?php if($current_File=='job-list.php'){?>class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>job-list">Job list</a></li>
						
						</ul>
					</div>
				</div><!-- navbar-left -->
				
				<!-- nav-right -->
				<div class="nav-right">				
					<ul class="sign-in">
						<li><i class="fa fa-user"></i></li>
						<?php
							if(isset($_SESSION['employer']))
							{
								?>  
                                <style>
								.sign-in li:last-child::before
								{
									background-image: none;
								}
								</style>                      
                                <li><a href="<?php echo SERVER_ROOTPATH;?>emp-profile">My Account</a></li>
                                <li><a href="<?php echo SERVER_ROOTPATH;?>logout">Logout</a></li>
                                
                               <?php
							}
							else
							if(isset($_SESSION['jobseeker']))
							{
								?>  
                                <style>
								.sign-in li:last-child::before
								{
									background-image: none;
								}
								</style>                      
                                <li><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-profile">My Account</a></li>
                                <li><a href="<?php echo SERVER_ROOTPATH;?>logout">Logout</a></li>
                                
                               <?php
							}
							else
							{
						?>                        
                            <li><a href="<?php echo SERVER_ROOTPATH;?>signin">Sign In</a></li>
                            <li><a href="<?php echo SERVER_ROOTPATH;?>signup">Upload your resume</a></li>
                           <?php
						   }
						   ?> 
					</ul><!-- sign-in -->					

					<?php
                    if(isset($_SESSION['employer']) || isset($_SESSION['jobseeker']))
					{
						
					}
					else
					{
						?>
                          <a href="<?php echo SERVER_ROOTPATH;?>employer-signup" class="btn">Post Your Job free</a>
                          <?php
					}
					?>
                          
				</div>
				<!-- nav-right -->
			</div><!-- container -->
		</nav><!-- navbar -->
	</header>