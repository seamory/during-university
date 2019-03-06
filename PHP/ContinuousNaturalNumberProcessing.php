<?php
//计算时间周期
function countWeek($start, $end, $type = NULL){
    $j = 0;
    if( $type == '单'){
        for($i = $start; $i <= $end; $i++){
            if( $i % 2 != 0 ) $week[$j++] = $i;
        }
    }elseif( $type == '双'){
        for($i = $start; $i <= $end; $i++){
            if( $i % 2 == 0 ) $week[$j++] = $i;
        }
    }else{
        for($i = $start; $i <= $end; $i++){
            $week[$j++] = $i;
        }
    }
    return join(',', $week);
}

function reduceOrderNum($array){
    $stack = array();
    $str = array();
    foreach ($array as $value){
        if( empty($stack )){
            array_push($stack, $value);
        }
        if( $next = next($array) ){
            if($value + 1 != $next ){
                if( ($element = array_pop($stack)) != $value ) $str[] = $element . '-' . $value;
                else $str[] = $element;
            }
        } else {
            if( ($element = array_pop($stack)) != $value ) $str[] = $element . '-' . $value;
            else $str[] = $element;
        }
    }
    return $str;
}

function reduceOrderNumFlag($array){
    $stack = array();
    $str = array();
    foreach ($array as $value){
        if( empty($stack )){
            array_push($stack, $value);
        }
        if( ( $next = next($array) ) && is_int($next) ){
            if( is_int($value) && $value + 2 != $next ){
                if( ($element = array_pop($stack)) != $value )
                    if( $value % 2 == 0 ) $str[] = '(' . $element . '-' . $value . ')双';
                    else $str[] = '(' . $element . '-' . $value . ')单';
                else $str[] = $element;
            }
        } else {
            if( ($element = array_pop($stack)) != $value )
                if( $value % 2 == 0 ) $str[] = '(' . $element . '-' . $value . ')双';
                else $str[] = '(' . $element . '-' . $value . ')单';
            else $str[] = $element;
        }
    }
    return $str;
}