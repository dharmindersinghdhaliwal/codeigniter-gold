<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="GoldTubeTV">
	<meta name="author" content="GoldTubeTV">
	<title>GoldTubeTV</title>
	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="<?= BASE_ASSET ?>img/favicon.png">
	<!-- Bootstrap core CSS-->
	<link href="<?= BASE_ASSET ?>vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="<?= BASE_ASSET ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<!-- Custom styles for this template-->
	<link href="<?= BASE_ASSET ?>css/osahan.css" rel="stylesheet">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="<?= BASE_ASSET ?>vendor/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="<?= BASE_ASSET ?>vendor/owl-carousel/owl.theme.css">
</head>
<body id="page-top">
	<nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
		&nbsp;&nbsp; 
		<button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
			<i class="fas fa-bars"></i>
		</button> &nbsp;&nbsp;
		<a class="navbar-brand mr-1" href="<?= BASE_URL ?>index"><img class="img-fluid" alt="" src="<?= BASE_ASSET ?>img/logo.png" style="height: 42px;"></a>
	</nav>
	<div id="wrapper">
		<!-- Sidebar -->
		<ul class="sidebar navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="<?= BASE_URL ?>index">
					<i class="fas fa-fw fa-home"></i>
					<span>Home</span>
				</a>
			</li>
		</ul>
		<div id="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8 mx-auto text-center  pt-4 pb-5">
						<h1><img alt="404" src="<?= BASE_ASSET ?>img/404.png" class="img-fluid"></h1>
						<h1>Sorry! Page not found.</h1>
						<p class="land">Unfortunately the page you are looking for has been moved or deleted.</p>
						<div class="mt-5">
							<a class="btn btn-outline-primary" href="<?= BASE_URL ?>index"><i class="mdi mdi-home"></i> GO TO HOME PAGE</a>
						</div>
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container">
					<div class="row no-gutters">
						<div class="col-lg-6 col-sm-6">
							<p class="mt-1 mb-0">&copy; Copyright <?= date('Y') ?> <strong class="text-dark">GoldTubeTV</strong>. All Rights Reserved<br>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<!-- /.content-wrapper -->
	</div>
	<!-- /#wrapper -->
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>
	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="<?= BASE_URL ?>login">Logout</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Bootstrap core JavaScript-->
	<script src="<?= BASE_ASSET ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= BASE_ASSET ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Core plugin JavaScript-->
	<script src="<?= BASE_ASSET ?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Owl Carousel -->
	<script src="<?= BASE_ASSET ?>vendor/owl-carousel/owl.carousel.js"></script>
	<!-- Custom scripts for all pages-->
	<script src="<?= BASE_ASSET ?>js/custom.js"></script>
</body>
</html>