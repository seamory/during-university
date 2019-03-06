<?php

function alertMsg($msg,$url)
{
	header("charset=utf8");
	echo "<script>alert('{$msg}');</script>";
	echo "<script>window.location='{$url}';</script>";
}

?>