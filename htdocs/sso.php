<?php require_once 'phpCAS-1.3.6/CAS.php';

$cas_host='cas.leschartreux.com';
$cas_port=443;
$cas_context='/';
$cas_cert='cas.leschartreux.com.pem';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setCasServerCACert($cas_cert);


phpCAS::forceAuthentication();



?>
