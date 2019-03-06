<?php
require_once '../../config.php';

$o = new SaeTOAuthV2( WB_KEY , WB_SEC );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CBU;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['wbtoken'] = $token;
	header('location:http://'.$_SESSION['url']);
}else{
	header('location:wblogin.php');
}
?>