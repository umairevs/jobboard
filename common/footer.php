<!-- footer -->
	<footer id="footer" class="clearfix">
		<!-- footer-top -->
		<section class="footer-top clearfix">
			<div class="container">
				<div class="row">
					<!-- footer-widget -->
					<div class="col-sm-4">
						<div class="footer-widget">
							<h3>Quik Links</h3>
							<ul>
								<li><a href="<?php echo SERVER_ROOTPATH;?>about-us">About Us</a></li>
								<li><a href="<?php echo SERVER_ROOTPATH;?>privacy-policy">Privacy Policy</a></li>
                                <li><a href="<?php echo SERVER_ROOTPATH;?>contact-us">Contact Us</a></li>
                                <li><a href="<?php echo SERVER_ROOTPATH;?>faq">FAQ</a></li>
								<li><a href="<?php echo SERVER_ROOTPATH;?>job-list">Jobs</a></li>
							</ul>
						</div>
					</div><!-- footer-widget -->

					<!-- footer-widget -->
					<div class="col-sm-4" style="display:none;">
						<div class="footer-widget">
							<h3>How to sell fast</h3>
							<ul>
								<li><a href="#">How to sell fast</a></li>
								<li><a href="#">Membership</a></li>
								<li><a href="#">Banner Advertising</a></li>
								<li><a href="#">Promote your ad</a></li>
								<li><a href="#">Jobs Delivers</a></li>
								
							</ul>
						</div>
					</div><!-- footer-widget -->

					<!-- footer-widget -->
					<div class="col-sm-4">
						<div class="footer-widget social-widget">
							<h3>Follow us on</h3>
							<ul>
							<?php if($social['facebook']!="") { ?>
                            	<li><a href="<?php echo $social['facebook'];?>" target="_blank"><i class="fa fa-facebook-official"></i>Facebook</a></li>
                            <?php } ?>
                            <?php if($social['twitter']!="") { ?>    
								<li><a href="<?php echo $social['twitter'];?>" target="_blank"><i class="fa fa-twitter-square"></i>Twitter</a></li>
                            <?php } ?>
                            <?php if($social['linkedin']!="") { ?>    
								<li><a href="<?php echo $social['linkedin'];?>" target="_blank"><i class="fa fa-google-plus-square"></i>Google+</a></li>
                            <?php } ?>
                            <?php if($social['youtube']!="") { ?>    
								<li><a href="<?php echo $social['youtube'];?>" target="_blank"><i class="fa fa-youtube-play"></i>youtube</a></li>
                             <?php } ?>   
							</ul>
						</div>
					</div><!-- footer-widget -->

					<!-- footer-widget -->
					<div class="col-sm-4" >
						<div class="footer-widget news-letter">
							<h3>Newsletter</h3>
							<p>Jobs is Worldest leading Portal platform that brings!</p>
							<!-- form -->
							
							
							<form action="#">
								<input type="email" class="form-control" placeholder="Your email id">
								<button type="submit" class="btn btn-primary">Sign Up</button>
							</form><!-- form -->			
						</div>
					</div><!-- footer-widget -->
				</div><!-- row -->
			</div><!-- container -->
		</section><!-- footer-top -->

		<div class="footer-bottom clearfix text-center">
			<div class="container">
				<p>Copyright &copy; <a href="#">Jobs</a> 2017. <!--Developed by <a href="http://themeregion.com/">ThemeRegion</a>--></p>
			</div>
		</div><!-- footer-bottom -->
	</footer><!-- footer -->
	
	<!--/Preset Style Chooser--> 
	<!--<div class="style-chooser">
		<div class="style-chooser-inner">
			<a href="#" class="toggler" ><i class="fa fa-cog fa-spin" style="margin-top:10px;"></i></a>
			<h4>Presets</h4>
			<ul class="preset-list clearfix">
				<li class="preset1 active" data-preset="1"><a href="#" data-color="preset1"></a></li>
				<li class="preset2" data-preset="2"><a href="#" data-color="preset2"></a></li>
				<li class="preset3" data-preset="3"><a href="#" data-color="preset3"></a></li>
				<li class="preset4" data-preset="4"><a href="#" data-color="preset4"></a></li>
			</ul>
		</div>
	</div>-->
	<!--/End:Preset Style Chooser-->
	
    <!-- JS -->
    <?php
    if($current_File!='jobseeker_edit_resume.php' && $current_File!='emp_add_jobs.php')
	{
	?><script src="<?php echo SERVER_ROOTPATH;?>js/jquery.min.js"></script>
    <?php
	}
	?>
    <script src="<?php echo SERVER_ROOTPATH;?>js/bootstrap.min.js"></script>
    <script src="<?php echo SERVER_ROOTPATH;?>js/price-range.js"></script>   
    <script src="<?php echo SERVER_ROOTPATH;?>js/main.js"></script>
	<script src="<?php echo SERVER_ROOTPATH;?>js/switcher.js"></script>
	
	
  
  
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
    
	<?php 
	if($current_File!='index.php' and $current_File!='job-list.php')
	{
       ?> <script type="text/javascript" src="<?php echo SERVER_ROOTPATH;?>js/jquery-1.3.2.min.js"></script>
	<?php  }   ?>
		
      <script type="text/javascript" src="<?php echo SERVER_ROOTPATH;?>js/jsconfig.js"></script>
<script type="text/javascript" src="<?php echo SERVER_ROOTPATH;?>js/jquery.form.js" language="javascript"></script>
<script type="text/javascript" src="<?php echo SERVER_ROOTPATH;?>js/myscript.js" language="javascript"></script>

