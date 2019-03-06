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
$user = phpCAS::getUser();

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
                 * login anonymous, only applicable when server is configured without authentication
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
                            var redir;
                            if (getURLparams()['redirurl'] != undefined) {
                                redir='http://'+getURLparams()['redirurl']+'?refresh';
                            } else {
                                redir='/index.html'
                            }
                            $(location).attr('href',redir);
                        } else {
                            $("#inputUsername").val("");
                            $("#inputPassword").val("");
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
          <!-- User option 1: login needed with name and password -->
          <div id="login_password" class="hidden">
              <form class="form-signin">
                  <h2 class="form-signin-heading">Please sign in</h2>
                  <label for="inputUsername" class="sr-only">Username</label>
                  <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus autocomplete="none" autocapitalize="none" autocorrect="off">
                  <label for="inputPassword" class="sr-only">Password</label>
                  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                  <button class="btn btn-primary btn-block" id="signin" type="button">Sign in</button>
              </form>
          </div>
          <!-- User option 2: login needed, without username, password -->
          <div id="login_none" class="hidden">
            <form class="form-signin">
                <button class="btn btn-primary btn-block" id="signin_anon" type="button">Sign in</button>
            </form>
          </div>
          <!-- User option 3: Already logged in, show logout button -->
          <div id="logout_frm" class="hidden">
            <form class="form-signin">
                <button class="btn btn-primary btn-block" id="logoff" type="button">Logout</button>
            </form>
          </div>
          <!-- Message dialog -->
          <div class="alert alert-danger alert-dismissible hidden" role="alert" id="alertMSG">
              <button type="button" class="close" id="btnCloseError" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <span id="errorMSGtext"></span>
          </div>
        </main>

        <!-- bootstrap script -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
