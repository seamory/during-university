<?php
require_once '../../config.php';
$o = new SaeTOAuthV2( WB_KEY , WB_SEC );
$code_url = $o->getAuthorizeURL( WB_CBU );
header('location:'.$code_url);
?>