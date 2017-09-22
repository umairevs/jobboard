<?php
include("common/top.php");
include("common/functions.php");

$where_query = '';
$cat_query = ''; 
if($_REQUEST['parent_cat']!='')
{
	$_SESSION['search']['job_category']	=	base64_decode($_REQUEST['parent_cat']);
	$cat_query	.=	" AND j.job_category = '".base64_decode($_REQUEST['parent_cat'])."'";	
}

if($_REQUEST['sub_cat']!='')
{
	$_SESSION['search']['job_subcategory']	=	base64_decode($_REQUEST['sub_cat']);
	$cat_query	.=	" AND j.job_subcategory = '".base64_decode($_REQUEST['sub_cat'])."'";	
}

if($_REQUEST['submit_search'])
{
	if($_REQUEST['job_country']!='')
	{
		$_SESSION['search']['job_country']	=	$_REQUEST['job_country'];
		$where_query	.=	" AND j.job_country = '".$_REQUEST['job_country']."'";
	}
	else
	{
		unset($_SESSION['search']['job_country']);
	}	
	
	
	if($_REQUEST['job_state']!='')
	{
		$_SESSION['search']['job_state']	=	$_REQUEST['job_state'];
		$where_query	.=	" AND j.job_state = '".$_REQUEST['job_state']."'";
	}
	else
	{
		unset($_SESSION['search']['job_state']);
	}	
	
	if($_REQUEST['job_city']!='')
	{
		$_SESSION['search']['job_city']	=	$_REQUEST['job_city'];
		$where_query	.=	" AND j.job_city = '".$_REQUEST['job_city']."'";
	}
	else
	{
		unset($_SESSION['search']['job_city']);
	}	
	
	if($_REQUEST['job_category']!='')
	{
		$_SESSION['search']['job_category']	=	$_REQUEST['job_category'];
		$where_query	.=	" AND j.job_category = '".$_REQUEST['job_category']."'";
	}
	else
	{
		unset($_SESSION['search']['job_category']);
	}	
	
	if($_REQUEST['job_subcategory']!='')
	{
		$_SESSION['search']['job_subcategory']	=	$_REQUEST['job_subcategory'];
		$where_query	.=	" AND j.job_subcategory = '".$_REQUEST['job_subcategory']."'";
	}
	else
	{
		unset($_SESSION['search']['job_subcategory']);
	}	
	
	if($_REQUEST['keyword']!='')
	{
		$_SESSION['search']['keyword']	=	$_REQUEST['keyword'];
		$where_query	.=	" AND j.job_title like '%".$_REQUEST['keyword']."%'";
	}
	else
	{
		unset($_SESSION['search']['keyword']);
	}	
	$_SESSION['search_query']  =  $where_query;
	
	unset($_SESSION['search_query_left']);
	unset($_SESSION['search']['days_list']);
	unset($_SESSION['search']['emp_type']);
	unset($_SESSION['search']['exp_level']);
	unset($_SESSION['search']['company_list']);
	unset($_SESSION['search']['price_range']);
}

if($_REQUEST['submit_left_search'])
{
	
	$days_list = $_REQUEST['days_list'];
	$price_range	= $_REQUEST['price_range'];
	$emp_type_size	= sizeof($_REQUEST['emp_type']);
	$exp_level_size	= sizeof($_REQUEST['exp_level']);
	$company_list_size	= sizeof($_REQUEST['company_list']);
	$price_range	=	$_REQUEST['price_range'];
	$where_query = '';
	
	if($days_list!='')
	{
		
		if($days_list!='')
		{
			if($days_list == 'today')
			{
				 $where_query	.=	"  AND j.posted_date like '".date("Y-m-d")." %'";
			}	
			else
			if($days_list == '7days')
			{
				$where_query	.=	"  AND j.posted_date >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)";
			}	
			else
			if($days_list == '30days')
			{
				$where_query	.=	"  AND j.posted_date >= DATE_ADD(CURDATE(), INTERVAL -30 DAY)";
			}	
			
			
			$_SESSION['search']['days_list'] = $days_list;
		}
		else
		{
			unset($_SESSION['search']['days_list']);
			
		}
	}
	else
	{
		unset($_SESSION['search']['days_list']);
	}
	
	if($emp_type_size!=0)
	{
		$emp_type = $_REQUEST['emp_type'];
		for($k=0;$k<$emp_type_size;$k++)
		{
			if($k==0)
			{
				$where_query  .=  " AND ( job_type = '".$emp_type[$k]."'";
			}
			else
			{
				$where_query  .=  " OR job_type = '".$emp_type[$k]."'";
			}
			
			
			if(($emp_type_size-1)==$k)
			{
				$where_query  .=  " )";
			}
		}
		
		$_SESSION['search']['emp_type'] = $emp_type;
		
	}
	else
	{
		unset($_SESSION['search']['emp_type']);
	}
	
	
	if($exp_level_size!=0)
	{
		$exp_level = $_REQUEST['exp_level'];
		for($k=0;$k<$exp_level_size;$k++)
		{
			if($k==0)
			{
				$where_query  .=  " AND (  	j.job_experience_level = '".$exp_level[$k]."'";
			}
			else
			{
				$where_query  .=  " OR j.job_experience_level = '".$exp_level[$k]."'";
			}
			
			
			if(($exp_level_size-1)==$k)
			{
				$where_query  .=  " )";
			}
		}
		
		$_SESSION['search']['exp_level'] = $exp_level;
		
	}
	else
	{
		unset($_SESSION['search']['exp_level']);
	}
	
	
	if($company_list_size!=0)
	{
		$company_list = $_REQUEST['company_list'];
		for($k=0;$k<$company_list_size;$k++)
		{
			if($k==0)
			{
				$where_query  .=  " AND (  	j.employer_id = '".$company_list[$k]."'";
			}
			else
			{
				$where_query  .=  " OR j.employer_id = '".$company_list[$k]."'";
			}
			
			
			if(($company_list_size-1)==$k)
			{
				$where_query  .=  " )";
			}
		}
		
		$_SESSION['search']['company_list'] = $company_list;
		
	}
	else
	{
		unset($_SESSION['search']['company_list']);
	}
	
	
	
		if($price_range!='')
		{
			$array_price  =  explode(",", $price_range);
			$min_price  =  $array_price[0];
			$max_price  =  $array_price[1];
			
			 $where_query	.=	"  AND (( j.job_salary_min >= $min_price AND j.job_salary_min <= $max_price)";
			$where_query	.=	"  OR ( j.job_salary_max >= $min_price AND j.job_salary_max <= $max_price))";
			
			$_SESSION['search']['price_range'] = $price_range;
		}
		else
		{
			unset($_SESSION['search']['price_range']);
			
		}
	
	 $_SESSION['search_query_left']  =  $where_query;
	
	
}

	 
$search_query  =  $_SESSION['search_query']." ".$_SESSION['search_query_left'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title>Jobs | Job Listing</title>
 	<?php include("common/top_script.php");?>   
	
 
    <script type="text/javascript">
		function  show_category(val)
		{
			$("#show_subcatgory_"+val).toggle();
		}
	</script>
  </head>
  <body>
	<!-- header -->
		<?php 
			include("common/header.php");
			 
			 $jobs_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 $search_query $cat_query order by id desc";	
	 		 $list_jobs			=	$db->get_results($jobs_query,ARRAY_A);	 	
	 
			//$list_jobs  =  jobs_list_all();
			
			$sizeof_array  = sizeof($list_jobs);
			?>   	
    <!-- header -->

	
	<section class="job-bg page job-list-page">
		<div class="container">
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
                
				<ol class="breadcrumb">
					<li><a href="<?php echo SERVER_ROOTPATH;?>">Home</a></li>
					<li><?php
					if($_SESSION['search']['job_category']!='')
					{
						$get_cat_info	=	get_job_category_details($_SESSION['search']['job_category']);
						echo stripslashes($get_cat_info['category_name']);
					}
					else
					{
						echo "Job Listing";
					}
				?>
               </li>
				</ol><!-- breadcrumb -->						
				<?php
                if($_SESSION['search']['job_category']!='')
					{
						$get_cat_info	=	get_job_category_details($_SESSION['search']['job_subcategory']);
						$sub_catname =  stripslashes($get_cat_info['category_name']);
						?>
                        <h2 class="title"><?php echo $sub_catname;?></h2>
                        <?php
					}
					?>
                    
			</div>

			<div class="banner-form banner-form-full job-list-form">
				<form action="<?php echo SERVER_ROOTPATH;?>job-list" method="post">
					<!-- category-change -->
					
					
					
					
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
  
					<input type="text" id="skills" class="form-control" placeholder="Type your keyword " name="keyword" value="<?php echo $_SESSION['search']['keyword'];?>" style="margin-left: 0px; width: 92%; background-color:white; border-radius:0;">
					<button type="submit" class="btn btn-primary" value="Search" name="submit_search">Search</button>
				</form>
			</div><!-- banner-form -->
	
			<div class="category-info">	
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<div class="accordion">
							<!-- panel-group -->
							<form method="post" action="<?php echo SERVER_ROOTPATH;?>job-list">
                            <div class="panel-group" id="accordion">
							 	
								<!-- panel -->
								<div class="panel panel-default panel-faq">	
									<!-- panel-heading -->
									
                                    <div class="panel-heading">
										<div  class="panel-title">
											<a data-toggle="collapse" href="#accordion-one">
												<h4>Categories<span class="pull-right"><i class="fa fa-minus"></i></span></h4>
											</a>
										</div>
									</div><!-- panel-heading -->

									<div id="accordion-one" class="panel-collapse collapse in">
										<!-- panel-body -->
										<div class="panel-body">
											<h5><a href="categories-main.html"><i class="fa fa-caret-down"></i> All Categories</a></h5>
											<?php
												$main_cat  =  get_job_main_categories_list();
												if($main_cat)
												{
												
													$s=1;
													foreach($main_cat as $row_category)
													{
														?>
                                                        <a href="javascript:;" onClick="show_category(<?php echo $s;?>)"><i class="icofont icofont-man-in-glasses"></i><?php echo stripslashes($row_category['category_name']);?></a>
                                                        
                                           <div class="see-more" id="show_subcatgory_<?php echo $s;?>" <?php if($_SESSION['search']['job_category']==$row_category['category_id']){?> style="display:block;" <?php } else {?> style="display:none;"<?php }?>>
												
												<ul>
													<?php
												$sub_main_cat  =  get_job_main_sub_categories_list($row_category['category_id']);
												if($sub_main_cat)
												{
												
													
													foreach($sub_main_cat as $row_subcategory)
													{
														 ?>
                                                         <li><a href="<?php echo SERVER_ROOTPATH;?>job-category/<?php echo base64_encode($row_category['category_id']);?>/<?php echo base64_encode($row_subcategory['category_id']);?>" <?php if($_SESSION['search']['job_sub_category']==$row_subcategory['category_id']){?> style="color:#00A651;" <?php }?>><?php echo stripslashes($row_subcategory['category_name']);?></a></li>
                                                         <?php
													}
												}
												?> 
												</ul>
											</div>
                                                        <?php		
															$s++;
													}
												}
											?>	
                                            
                                            
											

										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<div  class="panel-title">
											<a data-toggle="collapse" href="#accordion-two">
												<h4>Date Posted <span class="pull-right"><i class="fa fa-plus"></i></span></h4>
											</a>
										</div>
									</div><!-- panel-heading -->

									<div id="accordion-two" class="panel-collapse collapse <?php if($_SESSION['search']['days_list']!=''){?> in<?php }?>">
										<!-- panel-body -->
										<div class="panel-body">
											<input type="radio" name="days_list" id="today" value="today" <?php if($_SESSION['search']['days_list']=="today"){?> checked<?php }?>> Today <br>
											<input type="radio" name="days_list" id="7-days" value="7days" <?php if($_SESSION['search']['days_list']=="7days"){?> checked<?php }?>> 7 days <br>
											<input type="radio" name="days_list" id="30-days" value="30days" <?php if($_SESSION['search']['days_list']=="30days"){?> checked<?php }?>> 30 days <br>
                                            <?php
											if($_SESSION['search']['days_list']!='')
											{
												?>
                                                	<a href="javascript:;" onClick="uncheck()" style="font-size:12px; float:right;" id="uncheck">Uncheck Option</a>
                                                <?php
											}
											?>
											
                                            
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<div class="panel-title">
											<a data-toggle="collapse"  href="#accordion-three">
												<h4>
												Salary Range
												<span class="pull-right"><i class="fa fa-plus"></i></span>
												</h4>
											</a>
										</div>
									</div><!-- panel-heading -->

									<div id="accordion-three" class="panel-collapse collapse <?php if($_SESSION['search']['price_range']!=''){?> in<?php }?>">
										<!-- panel-body -->
										<div class="panel-body">
											<div class="price-range"><!--price-range-->
												<div class="price">
                                                <?php
												$minprice	=	get_min_price();
													$maxprice	=	get_max_price();
													
													if($_SESSION['search']['price_range']!='')
												{
													$price_range_Search  =  explode("," , $_SESSION['search']['price_range']);
													$first_price  = $price_range_Search[0];
													
													$last_price  = $price_range_Search[1];
												}
												else
												{
													$first_price  = 1;
													
													$last_price  = $maxprice;
												}
												
													
												
												
												?>
													<span>$<?php echo $first_price;?> - <strong>$<?php echo $last_price;?></strong></span>
													<div class="dropdown category-dropdown pull-right">	
														<!--<a data-toggle="dropdown" href="#"><span class="change-text">USD</span><i class="fa fa-caret-square-o-down"></i></a>-->			
													</div><!-- category-change -->													
													 <input type="text" name="price_range" value="" data-slider-min="0" data-slider-max="<?php echo $maxprice;?>" data-slider-step="5" data-slider-value="[<?php echo $first_price;?>,<?php echo $last_price;?>]" id="price" ><br />
												</div>
											</div><!--/price-range-->
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<div class="panel-title">
											<a data-toggle="collapse"  href="#accordion-four">
												<h4>Employment Type<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
											</a>
										</div>
									</div><!-- panel-heading -->

									<div id="accordion-four" class="panel-collapse collapse <?php if(isset($_SESSION['search']['emp_type'])){?> in<?php }?>">
										<!-- panel-body -->
										<div class="panel-body">
											 <?php
										
										 $list_emp_type  =  get_emp_type();
 										if($list_emp_type)
										{
											
											foreach($list_emp_type as $row_type)
											{
												?>
                                      
                                               
                                                 <label for="emp_type_<?php echo stripslashes($row_type['emp_id']);?>" class=" <?php  if (in_array($row_type['emp_id'], $_SESSION['search']['emp_type'])){?> checked<?php }?> " ><input type="checkbox" name="emp_type[]" value="<?php echo stripslashes($row_type['emp_id']);?>" id="emp_type_<?php echo stripslashes($row_type['emp_id']);?>" <?php  if (in_array($row_type['emp_id'], $_SESSION['search']['emp_type'])){?> checked<?php }?>  ><?php echo stripslashes($row_type['emp_title']);?></label>
                                                <?php
											}
										}	
										?>
											
                                            
                                           
											
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<div class="panel-title">
											<a data-toggle="collapse"  href="#accordion-five">
												<h4>Experience Level<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
											</a>
										</div>
									</div><!-- panel-heading -->

									<div id="accordion-five" class="panel-collapse collapse <?php if(isset($_SESSION['search']['exp_level'])){?> in<?php }?>">
										<!-- panel-body -->
										<div class="panel-body">
                                        <?php
										$list_job_salary  =  get_job_expeience_level();
										if($list_job_salary)
										{
											foreach($list_job_salary as $row_type)
											{
												?>
                                                <label for="exp_level_<?php echo stripslashes($row_type['exp_id']);?>" class=" <?php  if (in_array($row_type['exp_id'], $_SESSION['search']['exp_level'])){?> checked<?php }?>"><input type="checkbox" name="exp_level[]" id="exp_level_<?php echo stripslashes($row_type['exp_id']);?>" value="<?php echo stripslashes($row_type['exp_id']);?>" <?php  if (in_array($row_type['exp_id'], $_SESSION['search']['exp_level'])){?> checked<?php }?>> <?php echo stripslashes($row_type['exp_title']);?></label>
                                                <?php
											}
										}	
										?>
											
											
										</div><!-- panel-body -->
									</div>
								</div> <!-- panel --> 

								<!-- panel -->
								<div class="panel panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<div class="panel-title"></div>
										<a data-toggle="collapse"  href="#accordion-six">
											<h4>Company<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-six" class="panel-collapse collapse <?php if(isset($_SESSION['search']['company_list'])){?> in<?php }?>">
										<!-- panel-body -->
										<div class="panel-body">
											<!--<input type="text" placeholder="Search Company" class="form-control">-->
											<?php
                                            $list_company  =  company_list();
			
											$sizeofcompany_array  = sizeof($list_company);
											if($list_company)
											{
												$count_company = 0;
											
												foreach($list_company as $row_company)
												{
													$count_company++;
													$db_company_name  = stripslashes($row_company['company_name']);
													?>
                                                    <label for="company_list_<?php echo $row_company['employer_id'];?>" class=" <?php  if (in_array($row_company['employer_id'], $_SESSION['search']['company_list'])){?> checked<?php }?>"><input type="checkbox" name="company_list[]" value="<?php echo stripslashes($row_company['employer_id']);?>" id="company_list_<?php echo stripslashes($row_company['employer_id']);?>" <?php  if (in_array($row_company['employer_id'], $_SESSION['search']['company_list'])){?> checked<?php }?>> <?php echo $db_company_name;?></label>
                                                    <?php
													
													if($sizeofcompany_array>6)
													{
														if($count_company==7)
														{
														?>
                                                        <div class="see-more">
                                                        <button type="button" class="show-more two"><i class="fa fa-plus-square-o" aria-hidden="true"></i>See More</button>
                                                        <div class="more-category two">	
                                                        <?php
                                                        }
												?>
												
													<label for="company_list_<?php echo stripslashes($row_company['employer_id']);?>"  class=" <?php  if (in_array($row_company['employer_id'], $_SESSION['search']['company_list'])){?> checked<?php }?>"><input type="checkbox" name="company_list[]" value="<?php echo stripslashes($row_company['employer_id']);?>" id="company_list_<?php echo stripslashes($row_company['employer_id']);?>"  <?php  if (in_array($row_company['employer_id'], $_SESSION['search']['company_list'])){?> checked<?php }?>> <?php echo $db_company_name;?></label>
												
                                                <?php
													if($sizeofcompany_array==$count_company)
													{
														?>
                                                        	</div>
                                                        </div>
                                                        <?php
													}
											      }
												}
											}
											?>	
																						
										</div><!-- panel-body -->
									</div>
								</div> <!-- panel -->

							 </div><!-- panel-group -->
                             <button type="submit" name="submit_left_search" class="btn btn-primary" value="Search" style="width:100%;" >Search Resut</button>
                            </form> 
						</div>
					</div><!-- accordion-->
<?php
$targetpage = SERVER_ROOTPATH."job-list"; 	//your file name  (the name of this file)	
											$total_pages =$sizeof_array;
						$limit = 10; 								//how many items to show per page					
											
											$page = $_GET['page'];
											if($page) 
											{
												$start = ($page - 1) * $limit; 			//first item to display on this page
											}	
											else
											{
												$start = 0;								//if no page var is given, set start to 0
												$page=1;
											}	
											//PAGGING CODE ENDS HERE	
											//============================================================
											
											if(isset($page))
											{
												$sr_no = ($page*$limit)-$limit;
											}
											else
											{
												$sr_no = 0;
												$page=1;
											}
										

?>
					<!-- recommended-ads -->
					<div class="col-sm-10 col-md-9">				
						<div class="section job-list-item">
							<div class="featured-top">
								<h4>Showing <?php if($sizeof_array==0){ echo "0";} else { if($page==''){echo "1";} else { echo (($page-1)*$limit) + 1;}}?>-<?php   if($page==''){echo "1";} else { $total_page =  $page * $limit; if($total_page>=$sizeof_array){ echo $sizeof_array;} else { echo $total_page;}}?> of <?php echo $sizeof_array;?> ads</h4>
								<div class="dropdown pull-right">
								
								</div>							
							</div><!-- featured-top -->	

							<?php
									
										
											?>
											<input type="hidden" name="page" value="<?php echo $page;?>">
											<?php $c=1;	
											
						 $jobs_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 $search_query $cat_query order by id desc LIMIT $start, $limit";	
	 		 $list_jobs			=	$db->get_results($jobs_query,ARRAY_A);	 							
                 if($list_jobs)
				 {   					
					foreach($list_jobs as $row_info)
					{
						$job_id  = stripslashes($row_info['id']);
						$job_title  = stripslashes($row_info['job_title']);
						$country_id  = stripslashes($row_info['job_country']);
						$state_id  = stripslashes($row_info['job_state']);
						$city_id  = stripslashes($row_info['job_city']);
						$job_type  = stripslashes($row_info['job_type']);
						$job_function  = stripslashes($row_info['job_function']);
						$company_name  = stripslashes($row_info['company_name']);
						
						$job_salary_min  = stripslashes($row_info['job_salary_min']);
						$job_salary_max  = stripslashes($row_info['job_salary_max']);
						
						$image  = stripslashes($row_info['image']);
						
						$country_name = country_name($country_id);
						$state_name = state_name($country_id, $state_id);
						$city_name = city_name($country_id, $state_id, $city_id);
						
						$type_info = get_emp_type_name($job_type);
						
						if($image!="")
						{
							$img_url = SERVER_ROOTPATH. "media/emp_images/".$image;
						}
						else
						{
							$img_url = SERVER_ROOTPATH. "images/no-image.png";
						}
						
						?>
                        <div class="job-ad-item">
								<div class="item-info">
									<div class="item-image-box">
										<div class="item-image col-md-3 padding_all" >
											<a href="<?php echo SERVER_ROOTPATH;?>job-detail/<?php echo $job_id;?>"><img style="height:100%;" src="<?php echo $img_url;?>" alt="Image" class="img-responsive"></a>
										</div><!-- item-image -->
									</div>

									<div class="ad-info col-md-9 padding_all">
										<span><a href="<?php echo SERVER_ROOTPATH;?>job-detail/<?php echo $job_id;?>" class="title"><?php echo $job_title;?></a> @ <a href="#"><?php echo $company_name;?></a></span>
										<div class="ad-meta">
										<ul>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo stripslashes($city_name['City']);?>, <?php echo stripslashes($state_name['Region']);?> , <?php echo stripslashes($country_name['Country']);?> </li>
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo stripslashes($type_info['emp_title']);?></li>
                                            <li><i class="fa fa-money" aria-hidden="true"></i>$<?php echo $job_salary_min;?> - $<?php echo $job_salary_max;?></li>
                                           
                                        </ul>
										</div><!-- ad-meta -->									
									</div><!-- ad-info -->
								</div><!-- item-info -->
							</div>
                        <?php
					}
				 }
				 else
				 {
				 		?>
                        <div class="alert alert-danger"> No positions found, 
try widening your search.</div>
                        <?php
				 }
				?>
                <!-- job-ad-item -->

						

												
	
							
							<!-- pagination  -->
							<div class="text-center">
								<?php include("common/paging.php"); ?>
                               
							</div>
                            <!-- pagination  -->	
                            
				
						</div>
					</div><!-- recommended-ads -->

				</div>	
			</div>
		</div><!-- container -->
	</section><!-- main -->
	
	<!-- ad-profile-page -->
	<?php include("common/footer.php");?>   
  </body>
</html>
