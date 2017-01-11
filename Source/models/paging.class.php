<?php

/*======================================================================*\
|| ####################################################################
|| # Pefect Paging Class - by Ata Sasmaz
|| # Contact: atasasmaz _/at/_ gmail.com
|| # Feel free to improve and edit
|| # - - - - - - - - - - - - - - - - - - 
|| # Needs PHP5 (maybe works on PHP4 but
|| # I'm using PHP5 and i couldn't try.)
|| ####################################################################
\*======================================================================*/



//---------------INFOS-----------------
//Give $url var to assign function like
//doc.php?
//doc.php?docid=5&

/*
Example usage of paging:

require_once ( 'paging.class.php' );
$paging = new paging;


--    --
//url - total records [ - records_per_page ( as class var ) ]
$paging->assign ( 'topic.php?id=5&' , '47'  );

-- OR --

//url - total records - records_per_page
$paging->assign ( 'docs.php?' , '47' , 20  );

-- OR --

//onclick function - total records - records_per_page
//[:page:] will be replaced with that link's page number
//href='#' will be used, so i suggest use return false
//end of the js function
$paging->assign ( 'onclick="ajax_show_page(\'[:page:]\'); return false;"' , '47' , 20  );

--    --

echo $paging->fetch;


Example usage of sql limit generator:

//You don't need these two lines
//if you do it before
require_once ( 'paging.class.php' );
$paging = new paging;

//function variable is $records_per_page
//Current page will be got automaticly.
$sql_limit = $paging->sql_limit ( 20 );

-- OR --

//If you set the records_per_page before
//or you are using the default class value
//no need to set variable.
$sql_limit = $paging->sql_limit ();

//And use it like that
mysql_query("SELECT * FROM table LIMIT $sql_limit");
*///-------------------------------------

require_once '../part/error_reporting.php';

class paging
{
	//--------------------------------------------------
	//This will be used at links like example.php?page=5
	//Default: page # Type: string
	//--------------------------------------------------
	var $page_url_var = 'page';
	
	//---------------------------------------
	//How many links will be showed?
	//Like 4-5-6-7-8-9-10-11-12
	//Except first, last, back, forward links
	//Default: 8 # Type: integer
	//---------------------------------------
	var $align_links_count = '8';
	
	//------------------------------------------------------------------
	//If you give this at assign function this value will be overwritten
	//This value will have been used if you use assign function like
	//$paging->assign ( 'example.php?' , 100 );
	//Default: 15 # Type: integer
	//------------------------------------------------------------------
	var $records_per_page = 15;
	
	
	//-----------------------------------------
	//Do we want to use back and forward links?
	//Back: « ---- Forward: »
	//-----------------------------------------
	var $use_back_forward = true;
	
	var $back_link_icon = '&laquo;'; // &laquo; = «
	
	var $fwd_link_icon  = '&raquo;'; // &raquo; = »
	
	#######
	
	
	//--------------------------------------------
	//Do we want to use first and last page links?
	//First: 1... ---- Last: ...[Last_Page]
	//--------------------------------------------
	var $use_first_last = true;
	
	//-------------------------------------------
	//The class for this page's element (span tag)
	//Make false if you don't want to use this
	//Default: paging_this_page # Type: string
	//-------------------------------------------
	var $active_page_class = 'paging_this_page';
	
	//-----------------------------------------------------
	//For other pager links' class
	//Take links into a div like with class "pager_links"
	//Use at css file something like this
	//.pager_links a { font-size: 10px; }
	//No need fo give all links "class" attribute
	//-----------------------------------------------------


	function assign ( $url , $total_records , $records_per_page = false, $current_page = FALSE )
	{
		$this->total_records = $total_records;
		
		
		//If $records_per_page given
		//at function, use it
		if ( $records_per_page != false )
			$this->records_per_page = $records_per_page;
		
	
		//Which page at we are?
		$this->current_page = ( $current_page ) ? $current_page : '1';
		
		$this->check_page_is_int ( $this->current_page );
		

		//-------------------------------------
		//Check if the url is given correctly
		//if we're not using js onclick
		//-------------------------------------
		if ( ! eregi ( '^onclick=' , $url ) )
		{
			if ( ! ereg ( '\?' , $url ) )
				$url .= '?';
			elseif ( ereg ( '\?.+' , $url ) && ! ereg ( '&$' , $url ) )
				$url .= '&';
				
			$url .= $this->page_url_var . '=';
		}
		else
			$this->onclick = true;
			
		$this->url = $url;

		
		if ( $this->active_page_class )
			$this->active_page_class = ' class="'.$this->active_page_class.'" ';
			

		
		
		//Let's clear the html function
		//to not generate same codes again
		unset ( $this->html );
	}
	
	
	function fetch ()
	{
		//If already generated?
		if ( $this->html )
			return $this->html;
		
		if($this->total_records >0)
		{
    		//Let's run our functions to generate
    		$this->generate_pages();
    		$this->generate_html();
    
    		return $this->html;
		}
		
		return '';
	}
	
	
	function generate_pages ()
	{
		
		//-------------------------
		//Find the true page count
		//-------------------------
		
		$page_count = $this->total_records / $this->records_per_page;
		
		if ( $page_count != intval ( $page_count ) )
			$page_count = intval ( $page_count ) + 1;
		
		#######


		
		//How many links do we want to show?
		//Let's check if the page count less
		//than the align_links_count
		$max_link = $page_count > $this->align_links_count ? $this->align_links_count : $page_count;

		
		//Make start and end page equal first
		$start_page = $this->current_page;
		$end_page = $this->current_page;

		
		//Now start start_page decreasing
		//and end page increasing
		while ( $max_link > '0' )
		{			
			$looped = false;
			
			if ( $end_page < $page_count )
			{
				$end_page++;
				$max_link--;
				$looped = true;
			}
			
			if ( $start_page > '1' && $max_link != '0' )
			{
				$start_page--;
				$max_link--;
				$looped = true;
			}

			if ( $looped == false )
				break;
		}

		
		//---------------------------------
		//Let's make the page number links
		//From start page to end page
		//---------------------------------
		$i = $start_page;
		
		while ( $i <= $end_page )
		{
			if ( $i != $this->current_page )
			{
				$pagearray[] = $this->generate_link ( $i , $i ) ;
			}
			else
				$pagearray[] = '<span'.$this->active_page_class.'>'.$i.'</span>';

			$i++;
		}
		
		#######
		
		
		
		//Do we want to use first and last page links?
		if ( $this->use_first_last == true )
		{		
			
			//Just make the first page url if we need
			if ( $start_page > 1 )
			{
				$threedot_first = ( $start_page != '2' ) ? '...' : ' ';
				$this->page_first = $this->generate_link ( '1' , '1' ) . $threedot_first ;
			}
			
			//Just make the last page url if we need
			if ( $end_page < $page_count  )
			{
				$threedot_last = ( $end_page != $page_count - 1 ) ? '...' : ' ';
				
				$this->page_last = $threedot_last . $this->generate_link ( $page_count , $page_count ) ;
			}
		}
			
		
		
		
		//Do we want to use back and forward links?
		if ( $this->use_back_forward == true )
		{
			//Let's make "back" « link
			//if page is not the first
			if ( $this->current_page != '1' )
				$this->page_back = $this->generate_link ( $this->back_link_icon , $this->current_page - 1 ) . ' ' ;
		
			
			//Let's make "forward" » link
			//if page is not the last
			if ( $this->current_page != $page_count )
				$this->page_fwd = ' ' . $this->generate_link ( $this->fwd_link_icon , $this->current_page + 1 ) ;

		}
		
		
		//Let's make them global class variable
		$this->page_count = $page_count;
		$this->pagearray = $pagearray;
	
	}
	
	
	//--------------------------------
	//Convert all php strings, arrays
	//as html output
	//--------------------------------
	function generate_html ()
	{
		$html = implode ( ' ' , $this->pagearray );
		
		$html = $this->page_back . $this->page_first . $html . $this->page_last . $this->page_fwd;
		
		$this->html = $html;
	}
	
	
	
	//----------------------------
	//Link (a tag) html generateor
	//----------------------------
	function generate_link ( $inner, $page_number )
	{
		//If we are using the js onclick
		if ( $this->onclick == true )
		{
			$onclick = ' ' . str_replace ( '[:page:]' , $page_number , $this->url );
			//++ CR20120915_BinhLV_M
			// $url = '#';
			$url = '';
			//-- CR20120915_BinhLV_M
		}
		//If not
		else
			$url = $this->url .  $page_number;

		//that's the line, i did all codes for :)
		$link = '<a href="'.$url.'"'.$onclick.'>'.$inner.'</a>';
		
		return $link;
	}
	
	
	//-------------------------------
	//The protection for url variable
	//-------------------------------
	function check_page_is_int ( $current_page )
	{
		if ( ! ereg ( '^[0-9]+$' , $current_page ) )
			die ( 'Page number is not integer.' );
	}
	
	
	//-----------------------------
	//Let's make the SQL LIMIT code
	//-----------------------------
	function sql_limit ( $records_per_page = false )
	{
		$current_page = ( $this->current_page ) ? $this->current_page : $_GET[$this->page_url_var];
		
		$this->check_page_is_int ( $current_page );
		
		$records_per_page = ( $records_per_page == false ) ? $this->records_per_page : $records_per_page;
		
		$limit_start = ( $current_page - 1 ) * $records_per_page;
		
		
		$sql = $limit_start . ',' . $records_per_page;
		
		return $sql;
	}
	
	
	
}