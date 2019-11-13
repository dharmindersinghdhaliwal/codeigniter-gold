<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>My Subscribers</h6>
					</div>
				</div>
			</div>
		</div>
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-xl-3 col-sm-3 mb-3">
					<div class="osahan-form">
						<div class="row">
							<?php if(count($channel) > 1) { ?>
								<div class="col-lg-12">
									<div class="form-group">
										<label for="channel_id">Select Channel</label>
										<select id="channel_id" name="channel_id" class="custom-select" required="required">
											<option value="">All Channels</option>
											<?php foreach (db_get_all_data('channel',array('user_id'=>$this->session->userdata('id'))) as $chnl) { ?>
												<option value="<?= $chnl->id ?>"><?= $chnl->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="video-block section-padding">
			<div class="row">
				<?php foreach(db_get_all_data('channel',array('user_id'=>$this->session->userdata('id'))) as $channel) { ?>
					<?php foreach(db_get_all_data('subscribe',array('channel_id'=>$channel->id)) as $subscribe) { ?>
						<?php
						$user = db_get_row_data('users',array('id'=>$subscribe->user_id));

						$user_channel = db_get_row_data('channel',array('user_id'=>$subscribe->user_id));
						//echo '<pre>';	print_r($user_channel);
						?>
						<div class="col-xl-3 col-sm-6 mb-3 all-sub user-sub-<?= $channel->id ?>">
							<div class="channels-card">
								<div class="channels-card-image">
									<!--Redirect to Channel instead of user Profile-->
									<a href="<?= BASE_URL ?>channels/view/<?= $user_channel->id ?>">
									<!--<a href="<?= BASE_URL ?>user?usr=<?= base64_encode($user->email) ?>">-->

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
										<a href="<?= BASE_URL ?>channels/view/<?= $user_channel->id ?>"><?= $user->full_name ?></a>
									</div>
									<div class="channels-view">
										<small>Subscribe at : <?= date("jS M Y, h:i a",strtotime($subscribe->date_created)); ?></small>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<script> 
		$("#channel_id").on("change", function(){
			if($(this).val() == ''){
				$('.all-sub').fadeIn();
			} else {
				$('.all-sub').fadeOut();
				$('.user-sub-'+$(this).val()).fadeIn();
			}
		});
	</script>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>