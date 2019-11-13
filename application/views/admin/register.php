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
<body class="signup-page bg-blue-grey">
	<div class="signup-box">
		<div class="logo">
			<a href="javascript:void(0);">Online Course Lab<b> Admin</b></a>
			<small>Register</small>
		</div>
		<div class="card">
			<div class="body">
				<?= form_open('', [
					'name'    => 'form_login', 
					'id'      => 'form_login', 
					'method'  => 'POST'
				]);
				?>
				<div class="msg">Register a new membership</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">person</i>
					</span>
					<div class="form-line">
						<input type="text" class="form-control" name="full_name" placeholder="Full Name" value="<?= $full_name ?>" required autofocus />
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">email</i>
					</span>
					<div class="form-line">
						<input type="email" class="form-control" name="email" placeholder="Email Address" value="<?= $email ?>" required />
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">phone</i>
					</span>
					<div class="form-line">
						<input type="text" class="form-control" name="phone" placeholder="Phone / Mobile no." value="<?= $phone ?>" required />
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">lock</i>
					</span>
					<div class="form-line">
						<input type="password" class="form-control" name="password" placeholder="Password" value="<?= $password ?>" required />
					</div>
				</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">lock</i>
					</span>
					<div class="form-line">
						<input type="password" class="form-control" name="confirm" placeholder="Confirm Password" value="<?= $confirm ?>" required />
					</div>
				</div>
				<div class="form-group">
					<input type="checkbox" name="agree" id="agree" class="filled-in chk-col-blue-grey">
					<label for="agree">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
				</div>

				<button class="btn btn-block btn-lg bg-blue-grey waves-effect" type="submit">SIGN UP</button>

				<div class="m-t-25 m-b--5 align-center">
					<a href="<?= BASE_URL ?>admin/login">You already have a membership?</a>
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
	<script src="<?= BASE_ASSET ?>admin/js/pages/examples/sign-up.js"></script>
	<script>
		setInterval(function() {
			$('.alert').fadeOut();
		}, 4000);
	</script>
</body>
</html>