<?php
$userinfo = db_get_row_data('users',array('id'=>$this->session->userdata('id')));

$color = $this->input->get('color');
if($color != ''){
	$_SESSION['view_color'] = $color;
} elseif(isset($_SESSION['view_color'])){
	$_SESSION['view_color'] = $_SESSION['view_color'];
} else {
	$_SESSION['view_color'] = 'gold';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />	
	<meta name="description" content="<?= get_option('site_description') ?>" />
	<meta name="author" content="<?= get_option('author') ?>" />
	<title><?= get_option('site_name') ?> : <?= $page_title ?></title>
	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="<?= BASE_ASSET ?>img/favicon.png">
	<!-- Bootstrap core CSS-->
	<link href="<?= BASE_ASSET ?>vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="<?= BASE_ASSET ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<!-- Custom styles for this template-->
	<link href="<?= BASE_ASSET ?>css/osahan-<?= $_SESSION['view_color'] ?>.css" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="<?= BASE_ASSET ?>bootstrap-tagsinput/bootstrap_tagsinput.css" rel="stylesheet" />
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="<?= BASE_ASSET ?>vendor/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="<?= BASE_ASSET ?>vendor/owl-carousel/owl.theme.css">

	<!--<link src="<?= BASE_ASSET ?>zoom-video-player/css/zoomplayer.css" rel="stylesheet" type="text/css">-->

	<!-- Bootstrap core JavaScript-->
	<script src="<?= BASE_ASSET ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= BASE_ASSET ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Core plugin JavaScript-->
	<script src="<?= BASE_ASSET ?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Owl Carousel -->
	<script src="<?= BASE_ASSET ?>vendor/owl-carousel/owl.carousel.js"></script>
	<script src="<?= BASE_ASSET ?>bootstrap-tagsinput/bootstrap_tagsinput.js"></script>
	<script src="<?= BASE_ASSET ?>admin/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

	<!--Zoom Player-->
	<script src="<?= BASE_ASSET ?>zoom-video-player/js/zoomplayer.js"></script>
	<script src="https://www.youtube.com/iframe_api"></script>
	<script>
		setInterval(function() {$('.alert').fadeOut();}, 4000);
		function signOut() {window.location.replace("<?= BASE_URL ?>logout");}
	</script>
</head>
<style type="text/css">
.sticky-footer{position:absolute;bottom:0;width:83%;}
.image-view img{margin-top: 10px;box-shadow: 0px 0px 5px 2px #ccc;padding: 5px;width: 20%;height: 20%;}
.image-view .remove{display: inline-block;padding: 0px 2px;font-weight: bolder;vertical-align: bottom;border: 1px solid transparent;
	border-radius: 4px;color: #fff;background-color: #fb483a !important;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);
	-webkit-border-radius: 2px;-moz-border-radius: 2px;	-ms-border-radius: 2px;	border-radius: 2px;
}
.image-view .remove i{line-height: 0;font-size: 13px !important;}
.message{position: fixed;right: 37%;top: 5px;width: 25%;z-index: 99999;}
.nav-tabs {border-bottom: 1px solid #ddd;}
.nav {padding-left: 0;margin-bottom: 0;list-style: none;}
.nav-tabs > li {float: left;margin-bottom: -1px;position: relative;display: block;}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {color: #555;cursor: default;background-color: #fff;	border: 1px solid #ddd;	border-bottom-color: transparent;}
.nav-tabs > li > a {margin-right: 2px;line-height: 1.42857143;border: 1px solid transparent;border-radius: 4px 4px 0 0;
	position: relative;	display: block;	padding: 10px 15px;}
.navlink{display: block;padding: 15px 5px !important;position: relative;}
.navlink .badge {border: medium none !important;border-radius: 3px;font-size: 9px;font-weight: 700;height: 15px;line-height: 9px;
	min-width: 8px;position: absolute;text-align: center;top: 7px;right: -2px;}
.theme-color-code-gold{color: #FF9800;}
.theme-color-code-blue{color: #03A9F4;}
.theme-color-code-red{color: #fb2717;}
.theme-color-code-dark{color: #222222;}
</style>
<body id="page-top">
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
					<a class="btn btn-primary" href="javascript:signOut();">Logout</a>
				</div>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
		&nbsp;&nbsp; 
		<button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
			<i class="fa fa-bars"></i>
		</button> &nbsp;&nbsp;
		<a class="navbar-brand mr-1" href="<?= BASE_URL ?>index"><img class="img-fluid" alt="" src="<?= BASE_ASSET ?>img/logo.png" style="height: 42px;"></a>
		<!-- Navbar Search -->
		<form action="<?= BASE_URL ?>search" method="get" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search" style="margin: auto !important;">
			<div class="input-group">
				<input type="text" class="form-control" name="srch" id="srch" placeholder="Search for...">
				<div class="input-group-append">
					<button class="btn btn-light" type="submit">
						<i class="fa fa-search"></i> 
					</button>
				</div>
			</div>
		</form>
		<!-- Navbar -->
		<ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">
			<li class="nav-item dropdown no-arrow mx-1">
				<a class="navlink dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span data-toggle="tooltip" data-placement="bottom" title="Change Theme">
						<i class="fa fa-cog"></i>
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
					<a class="dropdown-item" href="?color=gold"><i class="fa fa-square theme-color-code-gold"></i> &nbsp; Default</a>
					<a class="dropdown-item" href="?color=blue"><i class="fa fa-square theme-color-code-blue"></i> &nbsp; Blue</a>
					<a class="dropdown-item" href="?color=red"><i class="fa fa-square theme-color-code-red"></i> &nbsp; Red</a>
					<a class="dropdown-item" href="?color=dark"><i class="fa fa-square theme-color-code-dark"></i> &nbsp; Dark</a>
					<div class="dropdown-divider"></div>
				</div>
			</li>
			<li class="nav-item mx-1">
				<span class="navlink">
					<a href="<?= BASE_URL ?>upload" data-toggle="tooltip" data-placement="bottom" title="Upload Video">
						<i class="fa fa-upload"></i>
					</a>
				</span>
			</li>
			<?php if(!$this->session->userdata('loggedin')) { ?>
				<li class="nav-item mx-1">
					<span class="navlink">
						<a href="<?= BASE_URL ?>login"><i class="fa fa-sign-in"></i> Sign-in</a> <a href="javascript:void(0);">|</a> 
						<a href="<?= BASE_URL ?>register"><i class="fa fa-user-plus"></i> Sign-up</a>
					</span>
				</li>
			<?php } else { ?>
				<li class="nav-item dropdown no-arrow mx-1">
					<a id="notifications" title="Notifications" class="navlink dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<i class="fa fa-bell"></i>
						<span class="badge badge-primary"><?= db_get_count_data('notification',array('user_type'=>'user','user_id'=>$this->session->userdata('id'),'status'=>0)) ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
						<!--Get notification only with status 0-->
						<?php foreach(db_get_all_data('notification',array('user_type'=>'user','user_id'=>$this->session->userdata('id'),'status'=>0),false,'datetime DESC',4) as $notification) {
								$user_channel = db_get_all_data('channel',array('user_id'=>$notification->user_id,'is_default'=>1));
								//	echo '<pre>';print_r($user_channel); exit; 
							//foreach(db_get_all_data('notification',array('user_type'=>'user','user_id'=>$this->session->userdata('id')),false,'datetime DESC',4) as $notification) { ?>
							<a class="dropdown-item" href="<?= BASE_URL ?>/channels/view/<?php echo $user_channel[0]->id; ?>"><i class="fa fa-envelope"></i> &nbsp; <?= substr($notification->message, 0,12) . '...' ?></a>
							<div class="dropdown-divider"></div>
						<?php } ?>
						<a class="dropdown-item" href="<?= BASE_URL ?>notification/"><i class="fa fa-history"></i> &nbsp; See All</a>
					</div>
				</li>
				<li class="nav-item dropdown no-arrow mx-1">
					<a id="messages" title="Messages" class="navlink dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<i class="fa fa-envelope"></i>
						<span class="badge badge-primary"><?= db_get_count_data('user_query',array('owner_id'=>$this->session->userdata('id'),'status'=>0)) ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
						<?php foreach(db_get_all_data('user_query',array('owner_id'=>$this->session->userdata('id'),'status'=>0),false,'date_created DESC',4) as $user_query) { ?>
							<a class="dropdown-item" href="<?= BASE_URL ?>message/view/<?= $user_query->id ?>" status="<?php echo $user_query->status ?>"><i class="fa fa-envelope"></i> &nbsp; <?= substr($user_query->title, 0,12) . '...' ?></a>
							<div class="dropdown-divider"></div>
						<?php } ?>
						<a class="dropdown-item" href="<?= BASE_URL ?>message/"><i class="fa fa-history"></i> &nbsp; See All</a>
					</div>
				</li>
				<li class="nav-item dropdown no-arrow osahan-right-navbar-user">
					<a class="navlink dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php if($userinfo->profile_image != ''){ ?>
							<?php if(file_exists(FCPATH . 'upload_data/user/' . $userinfo->profile_image)){ ?>
								<img src="<?= BASE_URL . 'upload_data/user/' . $userinfo->profile_image; ?>" style="width: 30px; height: 30px;" alt="<?= $userinfo->full_name ?>" />
							<?php } else { ?>
								<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="width: 30px; height: 30px;" alt="<?= $userinfo->full_name ?>" />
							<?php } ?>
						<?php } else { ?>
							<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="width: 30px; height: 30px;" alt="<?= $userinfo->full_name ?>" />
						<?php } ?>
						<?= substr($userinfo->full_name,0,7) ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
						<a class="dropdown-item" href="<?= BASE_URL ?>account"><i class="fa fa-user-circle"></i> &nbsp; My Account</a>
						<?php if (db_get_count_data('channel',array('is_default'=>1,'user_id'=>$this->session->userdata('id'))) == 1) { ?>
							<?php $channel = db_get_row_data('channel',array('is_default'=>1,'user_id'=>$this->session->userdata('id'))); ?>
							<a class="dropdown-item" href="<?= BASE_URL ?>channels/view/<?= $channel->id ?>"><i class="fa fa-video-camera"></i> &nbsp; My Channel</a>
						<?php } else { ?>
							<a class="dropdown-item" href="<?= BASE_URL ?>channels"><i class="fa fa-video-camera"></i> &nbsp; My Channels</a>
						<?php } ?>
						<!-- <a class="dropdown-item" href="<?= BASE_URL ?>profile"><i class="fa fa-user"></i> &nbsp; <?= ($userinfo->first_name == '')? 'Create Your' : 'My' ?> Profile</a> -->
						<a class="dropdown-item" href="<?= BASE_URL ?>settings"><i class="fa fa-cog"></i> &nbsp; Settings</a>
						<!-- <a class="dropdown-item" href="<?= BASE_URL ?>post/my"><i class="fa fa-clipboard"></i> &nbsp; My Posts</a> -->
						<a class="dropdown-item" href="<?= BASE_URL ?>user/group"><i class="fa fa-users"></i> &nbsp; My Groups</a>
						<a class="dropdown-item" href="<?= BASE_URL ?>post/create"><i class="fa fa-pencil"></i> &nbsp; Create Post</a> 
						<a class="dropdown-item" href="<?= BASE_URL ?>advertisement"><i class="fa fa-adn"></i> &nbsp; Promotion</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?= BASE_URL ?>help"><i class="fa fa-question-circle"></i> &nbsp; Help</a>
						<a class="dropdown-item" href="<?= BASE_URL ?>feedback"><i class="fa fa-commenting-o"></i> &nbsp; Feedback</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out"></i> &nbsp; Logout</a>
					</div>
				</li>
			<?php } ?>
		</ul>
	</nav>
	<div id="wrapper">
		<!-- Sidebar -->
		<ul class="sidebar navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="<?= BASE_URL ?>index">
					<i class="fa fa-home"></i>
					<span>Home</span>
				</a>
			</li>
			<?php if($this->session->userdata('loggedin')) { ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>channels">
						<i class="fa fa-user-circle-o"></i>
						<span>My Channels</span>
					</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>profile">
						<i class="fa fa-user"></i>
						<span><?= ($userinfo->first_name == '')? 'Create Your' : 'My' ?> Profile</span>
					</a>
				</li> -->
			<?php } else { ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>channels">
						<i class="fa fa-user-circle-o"></i>
						<span>Channels</span>
					</a>
				</li>
			<?php } ?>
			<?php if($this->session->userdata('loggedin')) { ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>my_videos">
						<i class="fa fa-video"></i>
						<span><?= ($this->session->userdata('loggedin'))? 'Edit My' : ''; ?> Videos</span>
					</a>
				</li>
			<?php } ?>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>history">
					<i class="fa fa-history"></i>
					<span>History</span>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>post">
					<i class="fa fa-clipboard"></i>
					<span>Posts</span>
				</a>
			</li> -->
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>live_stat">
					<i class="fa fa-line-chart"></i>
					<span>Live Stat</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>watch_later">
					<i class="fa fa-calendar-check-o"></i>
					<span>Watch Later</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>my_subscribers">
					<i class="fa fa-users"></i>
					<span>My Subscribers</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>post">
					<i class="fa fa-sticky-note"></i>
					<span>My Posts</span>
				</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="<?= BASE_URL ?>video_advertisement" role="button" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false">
					<i class="fas fa-bullhorn"></i>
					<span>Video Advertising</span>
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="<?= BASE_URL ?>my_advertisements">My Advertisements</a>
					<a class="dropdown-item" href="<?= BASE_URL ?>video_advertisement">Submit Advertisement</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="<?= BASE_URL ?>categories" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-list-alt"></i>
					<span>Categories</span>
				</a>
				<div class="dropdown-menu">
					<?php foreach (db_get_all_data('category') as $category) { ?>
						<a class="dropdown-item" href="<?= BASE_URL ?>category/<?= $category->id ?>"><?= $category->name ?></a>
					<?php } ?>
				</div>
			</li>
			<?php if($this->session->userdata('loggedin')) { ?>
				<li class="nav-item channel-sidebar-list">
					<h6>MY CHANNELS</h6>
					<ul>
						<?php foreach (db_get_all_data('channel',array('user_id'=>$this->session->userdata('id'))) as $channel) { ?>
							<li>
								<a href="<?= BASE_URL ?>channels/view/<?= $channel->id ?>">
									<?php if($channel->logo != ''){ ?>
										<img class="img-fluid" src="<?= BASE_URL ?>upload_data/channel/<?= $channel->logo ?>" alt="<?= $channel->name ?>">
									<?php } else { ?>
										<img class="img-fluid" src="<?= BASE_ASSET ?>img/s1.png" alt="<?= $channel->name ?>">
									<?php } ?> <?= $channel->name ?> 
								</a>
							</li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
			<?php if($this->session->userdata('loggedin')) { ?>
				<li class="nav-item channel-sidebar-list">
					<h6>SUBSCRIPTIONS</h6>
					<ul>
						<?php foreach (db_get_all_data('subscribe',array('user_id'=>$this->session->userdata('id')),false,'date_created DESC',4) as $subscribe) { ?>
							<?php $chnl = db_get_row_data('channel',array('id'=>$subscribe->channel_id)); ?>
							<li>
								<a href="<?= BASE_URL ?>channels/view/<?= $subscribe->channel_id ?>">
									<?php if($chnl->logo != ''){ ?>
										<img class="img-fluid" src="<?= BASE_URL ?>upload_data/channel/<?= $chnl->logo ?>" alt="<?= $chnl->name ?>">
									<?php } else { ?>
										<img class="img-fluid" src="<?= BASE_ASSET ?>img/s1.png" alt="<?= $chnl->name ?>">
									<?php } ?> <?= $chnl->name ?> 
								</a>
							</li>
						<?php } ?>
						<li>
							<a href="<?= BASE_URL ?>channels/my_subscription">View More</a>
						</li>
					</ul>
				</li>
			<?php } ?>
			<li class="nav-item">
				<?= get_option('ads_sidebar') ?>
			</li>
		</ul>