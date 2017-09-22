<style>
/*
Plugin Name: WP-Digg Style Paginator
Plugin URI: http://www.mis-algoritmos.com/2007/09/09/wp-digg-style-pagination-plugin-v-10/
Author: Victor De la Rocha
Author URI: http://www.mis-algoritmos.com
*/
.pagination {
	padding: 3px;
	margin: 3px;
	text-align:center;
	float:right;
	
}

.pagination a {
	/*padding: 2px 5px 2px 5px;*/
	padding:10px;
	margin: 5px;
	border: 1px solid #047700;
	text-decoration: none; /* no underline */
	color: #FFF;
	background:linear-gradient(to bottom, #48a513 0%, #26990a 50%, #048d01 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	border-radius:4px;
	font-size:20px;
	line-height: 1.42857;
	padding:4px 23px 4px !important;	
	
	
}

.pagination a:hover,
.pagination a:active {
	border: 1px solid #047700;
	color: #FFF;
	background:linear-gradient(to bottom, #6a6c66 0%, #63655f 50%, #5b5c57 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	border-radius:4px;
}
.pagination .current {
	padding:10px;
	margin: 2px;
	border: 0 none;
	font-weight: bold;
	background-color: #ea3452;
	color: #FFF;
}
.pagination .disabled {
	padding:10px;
	margin: 5px;
	border: 1px solid #047700;
	color: #FFF;
	border-radius:4px;
	font-size:20px;
	line-height: 1.42857;
	padding:4px 23px 4px !important;
	background:linear-gradient(to bottom, #6a6c66 0%, #63655f 50%, #5b5c57 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
</style>
<?php
	/*
		Place code to connect to your DB here.
	*/


	$tbl_name="";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 2;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage/$prev\">Prev</a>";
		else
			$pagination.= "<span class=\"disabled\">Prev</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				/*if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage/$counter\">$counter</a>";	*/				
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					/*if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage/$counter\">$counter</a>";		*/			
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage/$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage/$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage/1\">1</a>";
				$pagination.= "<a href=\"$targetpage/2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					/*if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage/$counter\">$counter</a>";	*/				
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage/$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage/$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage/1\">1</a>";
				$pagination.= "<a href=\"$targetpage/2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					/*if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage/$counter\">$counter</a>";		*/			
				}
			}
		}
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage/$next\">Next</a>";
		else
			$pagination.= "<span class=\"disabled\">Next</span>";
		$pagination.= "</div>\n";		
	}
?>
<?php echo $pagination;?>