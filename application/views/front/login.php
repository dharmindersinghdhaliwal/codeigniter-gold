<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?= get_option('site_description') ?>">
	<meta name="author" content="<?= get_option('author') ?>">
	<title><?= get_option('site_name') ?> : <?= $page_title ?></title>
	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="<?= BASE_ASSET ?>img/favicon.png">
	<!-- Bootstrap core CSS-->
	<link href="<?= BASE_ASSET ?>vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="<?= BASE_ASSET ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<!-- Custom styles for this template-->
	<link href="<?= BASE_ASSET ?>css/osahan-gold.css" rel="stylesheet">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="<?= BASE_ASSET ?>vendor/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="<?= BASE_ASSET ?>vendor/owl-carousel/owl.theme.css">
</head>
<style type="text/css">
.message{
	position: fixed;
	right: 37%;
	top: 5px;
	width: 25%;
	z-index: 99999;
}
button#google-login {
	padding: 0;
}
</style>
<body class="login-main-body">
	<div class="message">
		<?= validation_errors('<div class="alert alert-danger">','</div>'); ?>
		<?php if(isset($_SESSION['success'])){ ?>
			<div class="alert alert-success"><?= $_SESSION['success']; ?></div>
		<?php } else if (isset($_SESSION['error'])){ ?>
			<div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
		<?php } else if (isset($_SESSION['warning'])){ ?>
			<div class="alert alert-warning"><?= $_SESSION['warning']; ?></div>
		<?php } ?>
	</div>
	<section class="login-main-wrapper">
		<div class="container-fluid pl-0 pr-0">
			<div class="row no-gutters">
				<div class="col-md-5 p-5 bg-white">
					<div class="login-main-left">
						<div class="text-center mb-5 login-main-left-header pt-4">
							<img src="<?= BASE_ASSET ?>img/favicon.png" class="img-fluid" alt="LOGO">
							<h5 class="mt-3 mb-3">Welcome to <?= get_option('site_name') ?></h5>
							<p>It is a long established fact that a reader <br> will be distracted by the readable.</p>
						</div>
						<?= form_open(BASE_URL . 'login', [
							'name'			=> 'Login', 
							'id'			=> 'Login', 
							'method'		=> 'POST',
							'enctype'		=> 'multipart/form-data'
						]);
						?>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Email" />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password" />
						</div>
						<div class="mt-4">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<button type="submit" class="btn btn-outline-primary btn-block btn-lg">Sign In</button>
									</div>
									<div class="form-group">
										<button id="google-login" class="btn btn-block" type="button">
											<img src="<?= BASE_ASSET ?>img/login_with_google.png" style="width: 100%;" />
										</button>
									</div>
									<div class="form-group">
										<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink"><img src="<?= BASE_ASSET ?>img/login_with_facebook.png" style="width: 100%; " /></a>
									</div>
								</div>
							</div>
						</div>
						<?= form_close(); ?>
						<div class="text-center mt-5">
							<p class="light-gray">Forgot your password ? <a href="<?= BASE_URL ?>forgot_password">Forgot Password</a></p>
							<p class="light-gray">Don’t have an account? <a href="<?= BASE_URL ?>register">Sign Up</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="login-main-right bg-white p-5 mt-5 mb-5">
						<div class="owl-carousel owl-carousel-login">
							<div class="item">
								<div class="carousel-login-card text-center">
									<img src="<?= BASE_ASSET ?>img/login.png" class="img-fluid" alt="LOGO">
									<h5 class="mt-5 mb-3">​Watch videos offline</h5>
									<p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
								</div>
							</div>
							<div class="item">
								<div class="carousel-login-card text-center">
									<img src="<?= BASE_ASSET ?>img/login.png" class="img-fluid" alt="LOGO">
									<h5 class="mt-5 mb-3">Create your own channel</h5>
									<p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Bootstrap core JavaScript-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="<?= BASE_ASSET ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Core plugin JavaScript-->
	<script src="<?= BASE_ASSET ?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Owl Carousel -->
	<script src="<?= BASE_ASSET ?>vendor/owl-carousel/owl.carousel.js"></script>
	<!-- Custom scripts for all pages-->
	<script src="<?= BASE_ASSET ?>js/custom.js"></script>
	<script async defer src="https://apis.google.com/js/api.js" onload="HandleGoogleApiLibrary();"></script>
	<script>
		setInterval(function() {
			$('.alert').fadeOut();
		}, 4000);

		function HandleGoogleApiLibrary() {
			gapi.load('client:auth2', {
				callback: function() {
					gapi.client.init({
				    	apiKey: '<?= get_option('google_api_key'); ?>',
				    	clientId: '<?= get_option('google_client_id'); ?>',
				    	scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me'
					}).then(
						function(success) {
						},
						function(error) {
							$('.message').html('<div class="alert alert-danger">Error : Failed to Load Library</div>');
							$('.message').fadeIn();
					  	}
					);
				},
				onerror: function() {
					$('.message').html('<div class="alert alert-danger">Error : Failed to Load Library</div>');
					$('.message').fadeIn();
				}
			});
		}

		$("#google-login").on('click', function() {
			gapi.auth2.getAuthInstance().signIn().then(
				function(success) {
					gapi.client.request({ path: 'https://www.googleapis.com/plus/v1/people/me' }).then(
						function(success) {
							console.log(success);
							var user_info = JSON.parse(success.body);
							console.log(user_info);

							$.post('<?= BASE_URL ?>social_login/', {oauth_provider:'google', userData: success.body}, function(res) {
								if(res.loggedin){
									window.location.replace("<?= BASE_URL ?>dashboard");
								} else {
									$('.message').html(res.message);
									$('.message').fadeIn();
								}
							});
						},
						function(error) {
							$('.message').html('<div class="alert alert-danger">Error : Failed to get user user information</div>');
							$('.message').fadeIn();
						}
					);
				},
				function(error) {
					$('.message').html('<div class="alert alert-danger">Error : Login Failed</div>');
					$('.message').fadeIn();
				}
			);
		});

		window.fbAsyncInit = function() {
			FB.init({
				appId      : '<?= get_option('facebook_app_id') ?>',
				cookie     : true,
				xfbml      : true,
				version    : 'v3.2'
			});
		};

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		function fbLogin() {
			FB.login(function (response) {
				if (response.authResponse) {
					getFbUserData();
				} else {
					document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
				}
			}, {scope: 'email'});
		}

		function getFbUserData(){
			FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
				function (response) {
					console.log(response);
					$.post('<?= BASE_URL ?>social_login/', {oauth_provider:'facebook',userData: JSON.stringify(response)}, function(res){
						if(res.loggedin){
							window.location.replace("<?= BASE_URL ?>dashboard");
						} else {
							$('.message').html(res.message);
							$('.message').fadeIn();
						}
					});
				});
		}
	</script>
</body>
</html>