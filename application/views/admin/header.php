<?php 
	$userinfo = db_get_row_data('users',array('id'=>$this->session->userdata('id'))); 
	//print_r($userinfo);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?= $page_title ?></title>
	<link rel="icon" href="<?= BASE_ASSET ?>front/images/favicon.ico" type="image/x-icon">
	<link href="//fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	<link href="//use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/octicons/4.4.0/font/octicons.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/typicons/2.0.9/typicons.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/weather-icons/1.3.1/css/weather-icons.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/css/flag-icon.min.css"/>
	<link href="<?= BASE_ASSET ?>admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/plugins/node-waves/waves.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/animate-css/animate.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/morrisjs/morris.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
	<!-- JQuery DataTable Css -->
	<link href="<?= BASE_ASSET ?>admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	<!-- Bootstrap Material Datetime Picker Css -->
	<link href="<?= BASE_ASSET ?>admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/waitme/waitMe.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/plugins/dropzone/dropzone.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/plugins/multi-select/css/multi-select.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/plugins/nouislider/nouislider.min.css" rel="stylesheet" />
	<link href="<?= BASE_ASSET ?>admin/css/style.css" rel="stylesheet">
	<link href="<?= BASE_ASSET ?>admin/css/themes/all-themes.css" rel="stylesheet" />

	<script src="<?= BASE_ASSET ?>admin/plugins/jquery/jquery.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/bootstrap/js/bootstrap.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-validation/jquery.validate.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/bootstrap-select/js/bootstrap-select.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/dropzone/dropzone.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/multi-select/js/jquery.multi-select.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-spinner/js/jquery.spinner.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/node-waves/waves.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/autosize/autosize.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/momentjs/moment.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-countto/jquery.countTo.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-sparkline/jquery.sparkline.js"></script>
	<!-- Jquery DataTable Plugin Js -->
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-datatable/jquery.dataTables.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/ckeditor/ckeditor.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/tinymce/tinymce.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/sweetalert/sweetalert.min.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/chartjs/Chart.bundle.js"></script>

	<script src="<?= BASE_ASSET ?>admin/js/admin.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/pages/forms/basic-form-elements.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/pages/forms/advanced-form-elements.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/pagedatatables/tables/jquery-datatable.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/pages/index.js"></script>
	<script src="<?= BASE_ASSET ?>admin/js/demo.js"></script>
	<script>
		setInterval(function() {
			$('.alert-success, .alert-danger, .alert-warning, .alert-info').fadeOut();
		}, 4000);
		$(function () {
			$('[data-toggle="tooltip"]').tooltip({container: 'body'	});
		});

		$(document).ready(function () {
			var navListItems = $('div.setup-panel div a'),
			allWells = $('.setup-content'),
			allNextBtn = $('.nextBtn');

			allWells.hide();

			navListItems.click(function (e) {
				e.preventDefault();
				var $target = $($(this).attr('href')),
				$item = $(this);

				if (!$item.hasClass('disabled')) {
					navListItems.removeClass('btn-success').addClass('btn-default');
					$item.addClass('btn-success');
					allWells.hide();
					$target.show();
					$target.find('input:eq(0)').focus();
				}
			});

			allNextBtn.click(function () {
				var curStep = $(this).closest(".setup-content"),
				curStepBtn = curStep.attr("id"),
				nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
				curInputs = curStep.find("input[type='text'],input[type='url']"),
				isValid = true;

				$(".form-line").removeClass("error");
				for (var i = 0; i < curInputs.length; i++) {
					if (!curInputs[i].validity.valid) {
						isValid = false;
						$(curInputs[i]).closest(".form-line").addClass("error focused");
					}
				}

				if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
			});

			$('div.setup-panel div a.btn-success').trigger('click');
		});

		$(document).on('click', '.stp-prop', function (e) {
			e.stopPropagation();
		});
	</script>
</head>
<style type="text/css">
.message{position: fixed;right: 37%;top: 5px;width: 25%;z-index: 9999;}
.image-view img{margin-top: 10px;box-shadow: 0px 0px 5px 2px #ccc;padding: 5px;width: 20%;height: 20%;}
.image-view .remove{display: inline-block;padding: 0px 2px;font-weight: bolder;vertical-align: bottom;border: 1px solid transparent;
	border-radius: 4px;	color: #fff;background-color: #fb483a !important;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);
	-webkit-border-radius: 2px;-moz-border-radius: 2px;	-ms-border-radius: 2px;	border-radius: 2px;}
.image-view .remove i{line-height: 0;font-size: 13px !important;}
table input{font-size: 11px !important;}
@import "bourbon";
$col-secondary: #edc405;
body {background-color: #02111b;}.btn-default{border: 1px solid #b5b5b5 !important;box-shadow: none !important;color: #444;}
.btn-default:hover{background-color: #eee !important;}
</style>
<body class="theme-orange">
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
	<!-- Page Loader -->
	<div class="page-loader-wrapper">
		<div class="loader">
			<div class="preloader">
				<div class="spinner-layer pl-orange">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
			<p>Please wait...</p>
		</div>
	</div>
	<div class="overlay"></div>
	<nav class="navbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
				<a href="javascript:void(0);" class="bars"></a>
				<a class="navbar-brand" href="<?= BASE_URL ?>admin">
					<?php if(file_exists(FCPATH . 'asset/' . get_option('site_logo')) && get_option('site_logo') != ''){ ?>
						<img src="<?= BASE_ASSET . get_option('site_logo') ?>" alt="logo" style="width: 150px;margin-top: -18px;" />
					<?php } else { ?>
						<img src="<?= BASE_ASSET ?>img/logo.png" alt="logo" style="width: 150px;margin-top: -18px;" />
					<?php } ?>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" style="margin-top: 5px; margin-right: 15px;">
							<?php if($userinfo->profile_image != ''){ ?>
								<?php if(file_exists(FCPATH . 'upload_data/admin/' . $userinfo->profile_image)){ ?>
									<img src="<?= BASE_URL . 'upload_data/admin/' . $userinfo->profile_image; ?>" style="border-radius: 50%;width: 46px;height: 48px;" />
								<?php } else { ?>
									<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="border-radius: 50%;" />
								<?php } } else { ?>
									<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="border-radius: 50%;" />
								<?php } ?>
							</a>
							<ul class="dropdown-menu" style="margin-top: 3px !important">
								<li><a href="<?= BASE_URL ?>admin/setting"><i class="material-icons">settings</i>Settings</a></li>
								<li><a href="<?= BASE_URL ?>admin/dashboard/profile"><i class="material-icons">person</i>Profile</a></li>
								<li role="seperator" class="divider"></li>
								<li><a href="<?= BASE_URL ?>admin/logout"><i class="material-icons">input</i>Sign Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- #Top Bar -->
		<section>
			<!-- Left Sidebar -->
			<aside id="leftsidebar" class="sidebar">
				<!-- Menu -->
				<div class="menu">
					<ul class="list">
						<li class="header">MAIN NAVIGATION</li>
						<li class="active">
							<a href="<?= BASE_URL ?>admin/dashboard">
								<i class="material-icons">dashboard</i>
								<span>Dashboard</span>
							</a>
						</li>
						<li class="<?= ($this->uri->segment(2) == 'category')? 'active' : ''; ?>">
							<a href="<?= BASE_URL ?>admin/category">
								<i class="material-icons">category</i>
								<span>Categories</span>
							</a>
						</li>
						<li class="<?= ($this->uri->segment(2) == 'channel')? 'active' : ''; ?>">
							<a href="<?= BASE_URL ?>admin/channel">
								<i class="material-icons">voice_chat</i>
								<span>My Channels</span>
							</a>
						</li>
						<li class="<?= ($this->uri->segment(2) == 'video')? 'active' : ''; ?>">
							<a href="<?= BASE_URL ?>admin/video">
								<i class="material-icons">videocam</i>
								<span>My Video</span>
							</a>
						</li>
						<li class="<?= ($this->uri->segment(2) == 'user')? 'active' : ''; ?>">
							<a href="<?= BASE_URL ?>admin/user">
								<i class="material-icons">person</i>
								<span>Users</span>
							</a>
						</li>
						<li class="<?= ($this->uri->segment(2) == 'page')? 'active' : ''; ?>">
							<a href="<?= BASE_URL ?>admin/page">
								<i class="material-icons">web</i>
								<span>Pages Setup</span>
							</a>
						</li>
						<li class="">
							<a href="<?= BASE_URL ?>admin/advertisements">
								<i class="material-icons">announcement</i>
								<span>Advertisements</span>
							</a>
						</li>
						<li class="">
							<a href="<?= BASE_URL ?>admin/user_payments">
								<i class="material-icons">payment</i>
								<span>User Payments</span>
							</a>
						</li>
					</ul>
				</div>
				<!-- #Menu -->
			</aside>
		</section>

		<section class="content">
			<div class="container-fluid">