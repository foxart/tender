<?php
class SQL extends DB {
	private static $instance = NULL;
	private $connection;
	var $pagination = '';
	private function __construct() {
		$this->connection = @pg_connect("host=".DB::HOST." port=".DB::PORT." dbname=".DB::NAME." user=".DB::USER." password=".DB::PASS);
		if (!$this->connection)
			mail('jerosilinvinoth.jeyaraj@comodo.com', 'mdm.comodo.com', "Database connection failed: " . pg_last_error());
	}
	public static function getInstance() {
		if(self::$instance === NULL) {
			self::$instance = new SQL();
		}
		return self::$instance;
	}
	public function __destruct() {
    	if( is_resource($this->connection))
			pg_close($this->connection);
   	}
	private function strip_tags_attributes($string, $allowtags = '<strong><em><br>', $allowattributes = NULL) {
		if($allowattributes) {
			if(!is_array($allowattributes)) $allowattributes = explode(",",$allowattributes);
			if(is_array($allowattributes)) $allowattributes = implode("|",$allowattributes);
			$rep = '/([^>]*) ('.$allowattributes.')(=)(\'.*\'|".*")/i';
			$string = preg_replace($rep, '$1 $2_-_-$4', $string);
		}
		if(preg_match('/([^>]*) (.*)(=\'.*\'|=".*")(.*)/i',$string) > 0) {
			$string = preg_replace('/([^>]*) (.*)(=\'.*\'|=".*")(.*)/i', '$1$4', $string);
		}
		$rep = '/([^>]*) ('.$allowattributes.')(_-_-)(\'.*\'|".*")/i';
		if($allowattributes) $string = preg_replace($rep, '$1 $2=$4', $string);
		return strip_tags($string, $allowtags);
	}
	public function cleanQuery($string) {
		// prevent quotes and enter umpersand sites		
		$string = str_replace(chr(38), "&amp;", $string);
		$string = str_replace(chr(34), "&quot;", $string);
		$string = str_replace(chr(10), "", $string);
		$string = str_replace(chr(13), "<br />", $string);
		// prevent xss
		$string = $this->strip_tags_attributes($string);
		//prevent sql injection		
		if (!get_magic_quotes_gpc()) {
			$string = pg_escape_string($string);
		}
		return $string;
	}
	public function clean($data, $allow_tags = FALSE) {
		//make sure _all_ html entities are converted to the plain ascii equivalents - it appears 
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
		//decode url
		//$data = urldecode($data);
		// Fix &entity\n;
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
		// Some additional checks
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript 
				   /*'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags */
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly 
				   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
		); 
		$data = preg_replace($search, '', $data);
		//$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		do
		{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);
		$data = strip_tags($data);
		$string = htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
		if (!get_magic_quotes_gpc())
			$string = pg_escape_string($string);
		return $string;
	}
	public function cleanString($string) {
		$string = trim($string);
		//prevent sql injection		
		if (!get_magic_quotes_gpc()) {
			$string = pg_escape_string($string);
		}
		return $string;
	}
	public function query($sql) {
		if (!$this->connection) {
			return false;
			mail('jerosilinvinoth.jeyaraj@comodo.com', 'mdm.comodo.com', "Database connection failed inside query: " . pg_last_error());
		}
		$result = @pg_query($this->connection, $sql);
		if (!$result) {
			//echo "Query Execute: An error occurred.\n" . $sql;
			//exit;
			mail('jerosilinvinoth.jeyaraj@comodo.com', 'mdm.comodo.com', "Query Execute: An error occurred: " . pg_last_error($this->connection) . "; SQL:"  . $sql);
			return false;
		}
		return $result;
	}
	public function fetchRow($result) {
		if (!$this->connection)
			return false;
		$row = @pg_fetch_row($result);
		return $row;
	}
	public function getTotalRecords($sql) {		
		if (!$this->connection)
			return '0';
		$result = @pg_query($this->connection, $sql);
		if (!$result) {
			//echo "Query Execute: An error occurred.\n";
			//exit;
			return false;
		}
		$row = @pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$total_pages = $row['num'];
		return $total_pages;
	}
	public function getNumRows($result) {
		if (!$this->connection)
			return '0';
		$no_rows = @pg_num_rows($result);
		return $no_rows;
	}
	public function getPaginateResults($sql, $page, $limit, $adjacents, $targetpage, $total_pages) {		
		if (!$this->connection)
			return false;
		$response = $this->query($sql);
		$results = array();
		while( $row = @pg_fetch_array($response, NULL, PGSQL_ASSOC)) {
			$results[] = $row;
		}		
		if( !empty($results))
			$this->setPagination($page, $limit, $total_pages, $adjacents, $targetpage);
		return $results;
	}
	private function setPagination($page, $limit, $total_pages, $adjacents, $targetpage) {			
		/* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev 		= $page - 1;					//previous page is page - 1
		$next 		= $page + 1;					//next page is page + 1
		$lastpage 	= ceil($total_pages/$limit);	//lastpage is = total pages / items per page, rounded up.
		$lpm1 		= $lastpage - 1;				//last page minus 1
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
				$pagination.= "<a href=\"$targetpage?page=$prev\">&laquo; Previous</a>";
			else
				$pagination.= "<span class=\"disabled\">&laquo; Previous</span>";	
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
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
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
					}
				}
			}
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage?page=$next\">Next &raquo;</a>";
			else
				$pagination.= "<span class=\"disabled\">Next &raquo;</span>";
			$pagination.= "</div>\n";		
		}
		$this->pagination = $pagination;
	}
	public function getPagination() {
		return $this->pagination;
	}
}
?>