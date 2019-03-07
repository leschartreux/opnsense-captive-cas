<?php require_once 'phpCAS-1.3.6/CAS.php';

$portal_url='https://cpative_portal_fqdn:8000';
$cas_host='cas_fqdn';
$cas_port=443;
$cas_context='/'; // cas
$cas_cert='/usr/local/etc/cert.pem';

phpCAS::setDebug('/tmp/CAS.log');
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setCasServerCACert($cas_cert);
//phpCAS::setNoCasServerValidation();


phpCAS::handleLogoutRequests();


phpCAS::forceAuthentication();
$user = phpCAS::getUser();
if ( isset($_GET['logout']) )
{
	phpCAS::logoutWithRedirectService($portal_url .'/index.php?logout');
}

?>
<html>
	<head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="robots" content="noindex, nofollow, noodp, noydir" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="copyright" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />

        <title></title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/signin.css" rel="stylesheet">

        <!-- static zone info -->
        <script src="js/zone.js"></script>

        <script src="js/jquery-1.11.2.min.js"></script>
        <script>
            function getURLparams()
            {
                var vars = [], hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for(var i = 0; i < hashes.length; i++)
                {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }

            $( document ).ready(function() {

				/**
				 * login with authenticated user, use the nologin api with Cas Username
				 */
				// try to login
				$.ajax({
					type: "POST",
					url: "/api/captiveportal/access/logon/" + zoneid + "/",
					dataType:"json",
					data:{ user: '<?php echo $user?>', password: '' }
				}).done(function(data) {
					// redirect on successful login
					if (data['clientState'] == 'AUTHORIZED') {
						$("#successMSGtext").html("login OK");
						$("#successMSG").removeClass("hidden");
						/*var redir=getURLparams();
						if (redir['redirurl'] != undefined) {
							window.location.replace('inde.php'); = 'http://'+redir['redirurl']+'?refresh';
						} else {
							window.location.reload();
						}*/
						window.location.replace("index.php");
					} else {
						$("#errorMSGtext").html("login failed");
						$("#alertMSG").removeClass("hidden");
					}
				}).fail(function(){
					$("#errorMSGtext").html("unable to connect to authentication server");
					$("#alertMSG").removeClass("hidden");
				});
	

			});
 
        </script>
    </head>
    <body>
        <header class="page-head">
            <nav class="navbar navbar-default" >
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">
                            <img class="brand-logo" src="images/default-logo.png" height="30" width="150">
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <main class="page-content col-sm-6 col-sm-push-3">
            <!-- Message dialog -->
          <div class="alert alert-danger alert-dismissible hidden" role="alert" id="alertMSG">
              <button type="button" class="close" id="btnCloseError" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <span id="errorMSGtext"></span>
          </div>
          <div class="alert alert-success alert-dismissible hidden" role="alert" id="successMSG">
              <button type="button" class="close" id="btnSuccessCloseError" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <span id="successMSGtext"></span>
          </div>
        </main>

        <!-- bootstrap script -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
