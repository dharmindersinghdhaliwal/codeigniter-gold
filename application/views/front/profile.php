<link rel="Stylesheet" type="text/css" href="<?= BASE_ASSET ?>croppie/croppie.css" />
<script src="<?= BASE_ASSET ?>croppie/croppie.js"></script>
<style type="text/css">
#my-image, #use {
	display: none;
}
</style>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<?= form_open('', [
			'name'			=> 'form_profile',
			'id'			=> 'form_profile',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div id="profileImageModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Make Your Profile Image</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<input type='file' id="imgInp" accept="image/x-png,image/gif,image/jpeg" />
						<img id="my-image" src="#" />
					</div>
					<div class="modal-footer">
						<button type="button" id="use" class="btn btn-primary btn-sm" data-dismiss="modal">Done</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-title">
							<h6>Profile</h6>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#profileImageModal">Profile Image</button>
							<input type="hidden" id="profile_image" name="profile_image" value="" /><br />
							<small class="text-danger">max-width : 300px | max-height : 300px</small>
							<div class="image-view">
								<?php if($user->profile_image != ''){ ?>
									<img src="<?= BASE_URL ?>upload_data/user/<?= $user->profile_image ?>" />
									<a href="<?= BASE_URL ?>settings/remove_user_image" onclick="return confirm('Are you sure to remove the image ?');" class="remove"><i class="fa fa-trash"></i></a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<div class="col-xl-6 col-sm-6 mb-3">
						<div class="card text-white bg-success o-hidden h-100 border-none">
							<div class="card-body">
								<div class="card-body-icon">
									<i class="fas fa-fw fa-users"></i>
								</div>
								<div class="mr-5"><b><?= db_get_count_data('user_follow',array('follow_id'=>$this->session->userdata('id'))) ?></b> Followers</div>
							</div>
							<a class="card-footer text-white clearfix small z-1" href="<?= BASE_URL ?>follower">
								<span class="float-left">View Details</span>
								<span class="float-right">
									<i class="fas fa-angle-right"></i>
								</span>
							</a>
						</div>
					</div>
					<div class="col-xl-6 col-sm-6 mb-3">
						<div class="card text-white bg-info o-hidden h-100 border-none">
							<div class="card-body">
								<div class="card-body-icon">
									<i class="fa fa-fw fa-user-plus"></i>
								</div>
								<div class="mr-5"><b><?= db_get_count_data('user_follow',array('user_id'=>$this->session->userdata('id'))) ?></b> Following</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">First Name <span class="required">*</span></label>
							<input class="form-control border-form-control" value="<?= $user->first_name ?>" id="first_name" name="first_name" placeholder="First Name" type="text" />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Last Name <span class="required">*</span></label>
							<input class="form-control border-form-control" value="<?= $user->last_name ?>" id="last_name" name="last_name" placeholder="Last Name" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?= BASE_URL ?>" class="btn btn-danger border-none"> Cancel </a>
						<button type="submit" class="btn btn-success border-none"> Save Changes </button>
					</div>
				</div>
			</div>
		</div>
		<?= form_close(); ?>
		<div class="row">
			<div class="col-sm-12">
				<hr />
				<div class="video-block section-padding">
					<div class="row">
						<div class="col-md-12">
							<div class="main-title">
								<h6>
									My All Posts
									<div class="float-right">
										<a href="<?= BASE_URL ?>post/create" class="right-action-link text-gray"><i class="fa fa-plus"></i> Create your post</a>
										<a href="<?= BASE_URL ?>user/group" class="right-action-link text-gray"><i class="fa fa-users"></i> Manage Groups</a>
									</div>
								</h6>
							</div>
						</div>
						<?php foreach ($posts as $post) { ?>
							<div class="col-xl-3 col-sm-6 mb-3">
								<div class="channels-card">
									<div class="channels-card-image">
										<a href="<?= BASE_URL ?>post/<?= $post->id ?>">
											<?php $usr = db_get_row_data('users',array('id'=>$post->user_id)); ?>
											<?php if($usr->profile_image != ''){ ?>
												<?php if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){ ?>
													<img src="<?= BASE_URL . 'upload_data/user/' . $usr->profile_image; ?>" alt="<?= $usr->full_name ?>" />
												<?php } else { ?>
													<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" />
												<?php } ?>
											<?php } else { ?>
												<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" />
											<?php } ?>
										</a>
										<div class="channels-card-image-btn">
											<a href="<?= BASE_URL ?>post/edit/<?= $post->id ?>" class="btn btn-outline-danger btn-sm">Edit</a>
										</div>
									</div>
									<div class="channels-card-body">
										<div class="channels-title">
											<a href="<?= BASE_URL ?>post/<?= $post->id ?>"><?= substr(strip_tags($post->content),0,50) . '....' ?></a>
										</div>
										<div class="channels-view">
											<?= db_get_count_data('post_comment',array('post_id'=>$post->id)) ?> comments &nbsp;<i class="fa fa-history"></i> <?= time_elapsed_string($post->date_created) ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imgInp').fadeOut();
					$('#my-image').attr('src', e.target.result);
					var resize = new Croppie($('#my-image')[0], {
						viewport: { width: 300, height: 300 },
						boundary: { width: 400, height: 400 },
						showZoomer: false,
						enableResize: false,
						enableOrientation: true
					});
					$('#use').fadeIn();
					$('#use').on('click', function() {
						resize.result('base64').then(function(dataImg) {
							var data = [{ image: dataImg }, { name: 'myimgage.jpg' }];
							$('.image-view').html('<img src="'+dataImg+'" />');
							$('#profile_image').val(dataImg);
						})
					})
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		$("#imgInp").change(function() {
			readURL(this);
		});
	</script>