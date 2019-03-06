<?php
$a1 = [
[1,2,3,4,5,6],
[1,2,3,4,5,6],
[1,2,3,4,5,6],
[1,2,3,4,5,6],
[1,2,3,4,5,6],
[1,2,3,4,5,6],
];

$a2 = [
[a,b,c,d,e,f],
[a,b,c,d,e,f],
[a,b,c,d,e,f],
[a,b,c,d,e,f],
[a,b,c,d,e,f],
[a,b,c,d,e,f],
];

function mergeArray(&$result, $array){
	foreach($array as $key => $arrayRow){
		foreach($arrayRow as $rowKey => $value){
			$result[$key][$rowKey][] = $value;
		}
	}
	return $result;
}

echo '<pre>';
$result = array();
mergeArray($result, $a1);
mergeArray($result, $a2);
var_dump( $result );
