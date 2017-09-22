<?php
	$tbl_name="";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 2;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	$page = $_REQUEST['page'];;
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

		$paging_url = "$targetpage/";
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination\">";
		
		
		
		//previous button
		if ($page > 1) 
			$pagination.= "<li><a href=\"$paging_url$prev\"><i class=\"fa fa-chevron-left\"></i></a></li>";
		else
			$pagination.= "<li><a><i class=\"fa fa-chevron-left\"></i></a></li>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"active\"><a>$counter</a></li>";
				else
					$pagination.= "<li><a href=\"$paging_url$counter\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<li><a href=\"$paging_url$counter\">$counter</a></li>";
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$paging_url$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$paging_url$lastpage\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$paging_url/1\">1</a></li>";
				$pagination.= "<li><a href=\"$paging_url/2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a>$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$paging_url/$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$paging_url/$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$paging_url/$lastpage\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$paging_url/1\">1</a></li>";
				$pagination.= "<li><a href=\"$paging_url/2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a>$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$paging_url/$counter\">$counter</a></li>";					
				}
			}
		}
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"$paging_url$next\"><i class=\"fa fa-chevron-right\"></i></a></li>";
		else
			$pagination.= "<li><a><i class=\"fa fa-chevron-right\"></i></a>";
		//$pagination.= "</div>\n";		
		
		$pagination.= "</ul>\n";
	}
?>
<?php echo $pagination;?>