<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?= $page_title ?></title>
	<link rel="icon" href="<?= BASE_ASSET ?>admin/favicon.ico" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	<link href="<?= BASE_ASSET ?>admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/plugins/node-waves/waves.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/animate-css/animate.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/css/style.css" rel="stylesheet">
</head>
<style type="text/css">
.message{
	position: fixed;
	right: 37%;
	top: 5px;
	width: 25%;
	z-index: 9999;
}
</style>
<body class="login-page bg-orange">
	<div class="login-box">
		<div class="logo">
			<a href="<?= BASE_URL ?>"><?= get_option('site_name') ?><b> Admin</b></a>
			<small>Login</small>
		</div>
		<div class="card">
			<div class="body">
				<?= form_open('', [
					'name'    => 'form_login', 
					'id'      => 'form_login', 
					'method'  => 'POST'
				]);
				?>
				<div class="msg">Sign in to start your session</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">person</i>
					</span>
					<div class="form-line">
						<input type="text" class="form-control" name="email" placeholder="Email" value="<?= $email ?>" required autofocus />
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">lock</i>
					</span>
					<div class="form-line">
						<input type="password" class="form-control" name="password" placeholder="Password" required />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8 p-t-5">
						<input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-orange" value="1">
						<label for="rememberme">Remember Me</label>
					</div>
					<div class="col-xs-4">
						<button class="btn btn-block bg-orange waves-effect" type="submit">SIGN IN</button>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
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

	<script src="<?= BASE_ASSET ?>admin/plugins/jquery/jquery.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/bootstrap/js/bootstrap.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/node-waves/waves.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-validation/jquery.validate.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/admin.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/pages/examples/sign-in.js"></script>
	<script>
		setInterval(function() {
			$('.alert').fadeOut();
		}, 4000);
	</script>
</body>
</html>