<?php
class pageControl
{
	//	内部私有变量
	private $SQL_BASIC;
	private $SQL_LIMIT;
	private $PAGE_LOCATION;
	private $PAGE_TOTAL;
	
	//	由外部负责传入
	public $limit;
	
	// $OFFSET 由浏览器参数进行传递
	public function setSql($filed, $table, $condition, $offset, $limit)
	{
		$this -> PAGE_LOCATION = $offset;
		$this -> limit = $limit;
		if($offset < 1) $offset = 1;
		$record = ($offset - 1) * $limit;
		if( $condition ){
			$this -> SQL_LIMIT = 'select ' . $filed . ' from ' . $table . ' where ' . $condition . ' limit ' . $record . ',' . $this -> limit;
			$this -> SQL_BASIC = 'select ' . $filed . ' from ' . $table . ' where ' . $condition;
		}else{
			$this -> SQL_LIMIT = 'select ' . $filed . ' from ' . $table . ' limit ' . $record . ',' . $this -> limit;
			$this -> SQL_BASIC = 'select ' . $filed . ' from ' . $table;
		}
	}
	
	//	返回查询结果集，以二维数组的形式返回
	public function getRows($type = MYSQL_BOTH)
	{
		$sql = $this -> SQL_LIMIT;
		@$resources = mysql_query($this -> SQL_LIMIT);
		while( @$result = mysql_fetch_array($resources, $type) ){
			$results[] = $result;
		}
		return $results;
	}
	
	public function getPages()
	{
		$resources = mysql_query($this -> SQL_BASIC);
		$pages = ( mysql_num_rows( $resources ) / $this -> limit);
		$pages = is_float($pages) ? (int)$pages + 1 : $pages;
		return $pages;
	}
	
	public function pageLocation($left = 3, $right = 3)
	{
		$pages = $this -> getPages();
		if($pages < $right + $left ){
			for($i = 0; $i < $pages; $i++){
				$array[$i] = $i + 1;
			}
		}else{
			if($this -> PAGE_LOCATION < 1){
				for($i = 0; $i < $right + $left ; $i++){
					$array[$i] = $i + 1;
				}	
			}elseif($this -> PAGE_LOCATION >= $pages - $left - $right + 1 ){
				for($i = 0; $i < $right + $left ; $i++){
					$array[$i] = $pages - ( $right + $left ) + $i + 1; 
				}			
			}else{
				for($i = 0; $i < $left; $i++){
					$array[$i] = $this -> PAGE_LOCATION + $i;
				}
				for($right ; $right > 0; $right--, $i++){
					$array[$i] = $pages - $right + 1;
				}
			}
		}
		return $array;
	}
	
	public function showPage($argQuery, $argStr = 'query',  $left = 3, $right = 3)
	{
		$pages = $this -> pageLocation($left, $right);
		$URL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . $argQuery;
		$INDEX = $URL . $argStr . '=1';
		echo '<a href="'. $INDEX . '" style="margin: 0px 5px 0px 5px;" > << </a>';
		foreach($pages as $key => $val){
			echo '<a href="'. $URL . $argStr . '=' . $val . '" style="margin: 0px 5px 0px 5px;" >' . $val . '</a>';
		}
	}
}
?>