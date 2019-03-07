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
		
		var redir=getURLparams();
		if (redir.indexOf('logout') >= 0) {
			// hide alerts
			$("#alertMSG").addClass("hidden");
			// try to logoff
			$.ajax({
				type: "POST",
				url: "/api/captiveportal/access/logoff/" + zoneid + "/",
				dataType:"json",
				data:{ user: '', password: '' }
			}).done(function(data) {
				// refresh page
				window.location = window.location.pathname + window.location.hash;
			}).fail(function(){
				$("#errorMSGtext").html("unable to connect to authentication server");
				$("#alertMSG").removeClass("hidden");
			});
		}

		/**
		 * close / hide error message
		 */
		$("#btnCloseError").click(function(){
			$("#alertMSG").addClass("hidden");
		});

		/**
		 * execute after pageload
		 */
		
		$.ajax({
			type: "POST",
			url: "/api/captiveportal/access/status/" + zoneid + "/",
			dataType:"json",
			data:{ user: $("#inputUsername").val(), password: $("#inputPassword").val() }
		}).done(function(data) {
			var redirurl=getURLparams()['redirurl'];
			if (data['clientState'] == 'AUTHORIZED') {
				$("#logout_frm").removeClass('hidden');
				$("#successMSG").removeClass('hidden');
			} else if (data['authType'] == 'none') {
				$("#login_none").removeClass('hidden');
				$("#alertMSG").removeClass("hidden");
			} else {
				$("#login_password").removeClass('hidden');
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
			<span id="errorMSGtext">Vous devez vous connecter pour accéder à Internet</span>
		</div>
		<div class="alert alert-success alert-dismissible hidden" role="alert" id="successMSG">
              <button type="button" class="close" id="btnSuccessCloseError" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <span id="successMSGtext">Vous êtes connectés, vous pouvez accéder à Internet.</span>
          </div>
		<!-- User option 2: login needed, without username, password -->
		<div id="login_none" class="hidden">
			<form class="form-signin" id="formsso">
				<?php
					if ( isset($_GET['redirurl']) )
						$redir = "sso.php?redirurl=" . $_GET['redirurl'];
					else
						$redir = "sso.php";
				?>
				<a class="btn btn-primary btn-block" id="signin_sso" role="button" href="<?php echo $redir?>" >Connexion CAS</a>
			</form>
		</div>
		<div id="logout_frm" class="hidden">
			<form class="form-signin" id="formlogout">
				<a class="btn btn-primary btn-block" id="logoff" role="button" href='sso.php?logout'>Déconnexion CAS</a>
			</form>
		</div>

	</main>

	<!-- bootstrap script -->
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>
