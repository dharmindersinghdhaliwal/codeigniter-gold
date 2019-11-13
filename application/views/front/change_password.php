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
				<div class="col-md-5 p-5 bg-white full-height">
					<div class="login-main-left">
						<div class="text-center mb-5 login-main-left-header pt-4">
							<img src="<?= BASE_ASSET ?>img/favicon.png" class="img-fluid" alt="LOGO">
							<h5 class="mt-3 mb-3">Welcome to <?= get_option('site_name') ?></h5>
							<p>It is a long established fact that a reader <br> will be distracted by the readable.</p>
						</div>
						<?= form_open(BASE_URL . 'change_password?usr=' . $this->input->get('usr'), [
							'name'			=> 'form_change_password', 
							'id'			=> 'form_change_password', 
							'method'		=> 'POST',
							'enctype'		=> 'multipart/form-data'
						]);
						?>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password" />
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" name="confirm" class="form-control" placeholder="Confirm Password" />
						</div>
						<div class="mt-4">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<button type="submit" class="btn btn-outline-primary btn-block btn-lg">Reset</button>
									</div>
								</div>
							</div>
						</div>
						<?= form_close(); ?>
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
	<script>
		setInterval(function() {
			$('.alert').fadeOut();
		}, 4000);
	</script>
</body>
</html>