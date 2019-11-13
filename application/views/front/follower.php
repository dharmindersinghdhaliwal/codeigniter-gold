<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>My Followers</h6>
					</div>
				</div>
			</div>
		</div>
		<div class="video-block section-padding">
			<div class="row">
				<?php foreach($followers as $follower) { ?>
					<?php $user = db_get_row_data('users',array('id'=>$follower->user_id)); ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="channels-card">
							<div class="channels-card-image">
								<a href="<?= BASE_URL ?>user?usr=<?= base64_encode($user->email) ?>">
									<?php if($user->profile_image != ''){ ?>
										<?php if(file_exists(FCPATH . 'upload_data/user/' . $user->profile_image)){ ?>
											<img class="img-fluid" src="<?= BASE_URL . 'upload_data/user/' . $user->profile_image; ?>" alt="<?= $user->full_name ?>" />
										<?php } else { ?>
											<img class="img-fluid" src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $user->full_name ?>" />
										<?php } ?>
									<?php } else { ?>
										<img class="img-fluid" src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $user->full_name ?>" />
									<?php } ?>
								</a>
							</div>
							<div class="channels-card-body">
								<div class="channels-title">
									<a href="<?= BASE_URL ?>user?usr=<?= base64_encode($user->email) ?>"><?= $user->full_name ?></a>
								</div>
								<div class="channels-view">
									<small>Followed at : <?= date("jS M Y, h:i a",strtotime($follower->datetime)); ?></small>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>