<?php require_once 'phpCAS-1.3.6/CAS.php';

$cas_host='cas.leschartreux.com';
$cas_port=443;
$cas_context='/';
$cas_cert='/usr/local/etc/cert.pem';

phpCAS::setDebug('/tmp/CAS.log');
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setCasServerCACert($cas_cert);
//phpCAS::setNoCasServerValidation();


phpCAS::forceAuthentication();



?>
<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>
    
    <p>the user's login is <b><?php echo phpCAS::getUser(); ?></b>.</p>
    <p>phpCAS version is <b><?php echo phpCAS::getVersion(); ?></b>.</p>
    <p><a href="?logout=">Logout</a></p>
  </body>
</html>
