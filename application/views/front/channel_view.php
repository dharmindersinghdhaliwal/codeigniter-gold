<style type="text/css">
.video-card-list .user-image {float: left;height: auto;margin: 0 12px 0 0;width: 122px;}
.user-image {overflow: hidden;position: relative;}
</style>
<div id="customUrlModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Channel Custom URL</h4>
			</div>
			<?= form_open(BASE_URL . 'channels/custom/' . $channel->id, [
				'name'			=> 'form_custom_url', 
				'id'			=> 'form_custom_url', 
				'method'		=> 'POST',
				'enctype'		=> 'multipart/form-data'
			]);
			?>
			<div class="modal-body">
				<div class="osahan-form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="custom_url">URL</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="custom_url"><?= BASE_URL ?>channel/</span>
									</div>
									<input type="text" placeholder="Your Channel Name..." id="custom_url" name="custom_url" class="form-control" required="required" aria-describedby="basic-addon3" value="<?= $channel->custom_url ?>" />
								</div>
								<small class="text-danger">Use only alphanumeric value.</small>
								<?php if($channel->custom_url != ''){ ?>
									<hr />
									<p>
										<a href="<?= BASE_URL . 'channel/' . $channel->custom_url ?>" class="btn btn-outline-warning btn-sm" target="_blank">Visit Channel link</a>
									</p>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-warning border-none" name="save">Submit</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<?= form_close(); ?>
		</div>
	</div>
</div>
<div class="single-channel-page" id="content-wrapper">
	<div class="single-channel-image">
		<div style="width: 100%; height: 400px; object-fit: scale-down; overflow: hidden;">
			<img class="img-fluid" alt="<?= $channel->name ?>" onerror="this.src='<?= BASE_ASSET ?>img/default_banner.jpg'" src="<?= BASE_URL ?>upload_data/channel/<?= $channel->banner ?>">
		</div>
		<div class="channel-profile">
			<img class="channel-profile-img" alt="<?= $channel->name ?>" onerror="this.src='<?= BASE_ASSET ?>img/s1.png'" src="<?= BASE_URL ?>upload_data/channel/<?= $channel->logo ?>">
		</div>
	</div>
	<div class="single-channel-nav">
		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="channel-brand" href="#">
				<?= $channel->name ?> 
				<?php if($channel->verified == 1){ ?>
					<span data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span>
				<?php } ?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="javascript:set_active('tab_home');">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript:set_active('tab_video');">Videos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript:set_active('tab_post');">Posts</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript:set_active('tab_about');">About</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript:set_active('tab_contact_us');">Contact Us</a>
					</li>
				</ul>
				<?php if($channel->user_id == $this->session->userdata('id')){ ?>
					<form class="my-2 my-lg-0">
						<span data-toggle="modal" data-target="#customUrlModal">
							<a class="btn btn-outline-danger btn-sm" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Manage Your Channel Custom url"><i class="fa fa-cog"></i></a>
						</span>
						<a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>channels/edit/<?= $channel->id ?>" data-toggle="tooltip" data-placement="bottom" title="Update Channel">Edit Channel</a>
						<a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>channels/delete/<?= $channel->id ?>" data-toggle="tooltip" data-placement="bottom" title="Remove Channel" onclick="return confirm('Are you sure to remove the channel ?');">Delete Channel</a>
					</form>
				<?php } else { ?>
					<form class="my-2 my-lg-0">
						<?php
						if($this->session->userdata('loggedin')){
							$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel->id,'user_id'=>$this->session->userdata('id')));
							if(count($subscribe) == 0){
								?>
								<button type="button" class="btn btn-outline-danger sub-take" id="subscribe_button<?= $channel->id ?>" data-sub="<?= $channel->id ?>">
									<span id="channel_subs_count<?= $channel->id ?>"><?= db_get_count_data('subscribe',array('channel_id'=>$channel->id)) ?></span> 
									<span id="sub-text<?= $channel->id ?>">Subscribe</span>
								</button>
								<?php
							} else {
								?>
								<button type="button" class="btn btn-outline-secondary sub-take" id="subscribe_button<?= $channel->id ?>" data-sub="<?= $channel->id ?>">
									<span id="channel_subs_count<?= $channel->id ?>"><?= db_get_count_data('subscribe',array('channel_id'=>$channel->id)) ?></span> 
									<span id="sub-text<?= $channel->id ?>">Subscribed</span>
								</button>
								<?php
							}
						} else {
							?> 
						<button type="button" class="btn btn-outline-danger sub-take" id="subscribe_button<?= $channel->id ?>" data-sub="<?= $channel->id ?>">
							<span id="channel_subs_count<?= $channel->id ?>"><?= db_get_count_data('subscribe',array('channel_id'=>$channel->id)) ?></span> 
							<span id="sub-text<?= $channel->id ?>">Subscribe</span>
						</button>
							<?php
						}
						?>
					</form>
				<?php } ?>
			</div>
		</nav>
	</div>
	<div class="container-fluid">
		<div class="video-block section-padding" id="tab_home">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>Channel Home</h6>
					</div>
				</div>
				<?php foreach ($videos as $video) { ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="video-card">
							<div class="video-card-image">
								<a class="play-icon" href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>"><i class="fas fa-play-circle"></i></a>
								<a href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>">
									<?php if($video->video_thumbnail != ''){ ?>
										<img class="img-fluid" style="height: 142px;" src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $video->video_thumbnail ?>" alt="<?= $video->title ?>">
									<?php } else { ?>
										<video style="width: 100%; height: 142px;" preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $video->video ?>#t=0.5"></video>
									<?php } ?>
								</a>
							</div>
							<div class="video-card-body">
								<div class="video-title">
									<a href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>"><?= $video->title ?></a>
								</div>
								<div class="video-page text-success">
									<?php $category = db_get_row_data('category',array('id'=>$video->category_id)); ?>
									<?= $category->name ?>  <a href="#"><i class="fa <?= $category->icon ?> text-success"></i></a>
								</div>
								<div class="video-view">
									<?= db_get_count_data('history',array('video_id'=>$video->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($video->date_created) ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="video-block section-padding" id="tab_video" style="display: none;">
			<div class="row">
			<?php
				$current_userChannels = db_get_all_data('channel',array('user_id'=>$this->session->userdata('id')));
				$ids = array();
				foreach ($current_userChannels as $userChannel) {
					array_push($ids,$userChannel->id);
				}
				if(in_array($channel->id, $ids)){
			?>
				<div class="col-md-12">
					<div class="main-title">
						<h6>Channel Videos</h6>
						<div class="btn-group float-right right-action">
							<a href="<?= BASE_URL ?>upload?chnl=<?= $channel->id ?>" class="right-action-link text-gray">Upload More Video
								<i class="fa fa-plus"></i>
							</a>
						</div>
					</div>
				</div>
			<?php }	?>
				<?php foreach ($videos as $video) { ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="video-card">
							<div class="video-card-image">
								<a class="play-icon" href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>"><i class="fas fa-play-circle"></i></a>
								<a href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>">
									<?php if($video->video_thumbnail != ''){ ?>
										<img class="img-fluid" style="height: 142px;" src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $video->video_thumbnail ?>" alt="<?= $video->title ?>">
									<?php } else { ?>
										<video style="width: 100%; height: 142px;" preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $video->video ?>#t=0.5"></video>
									<?php } ?>
								</a>
							</div>
							<div class="video-card-body">
								<div class="video-title">
									<a href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>"><?= $video->title ?></a>
								</div>
								<div class="video-page text-success">
									<?php $category = db_get_row_data('category',array('id'=>$video->category_id)); ?>
									<?= $category->name ?>  <a href="#"><i class="fa <?= $category->icon ?> text-success"></i></a>
								</div>
								<div class="video-view">
									<?= db_get_count_data('history',array('video_id'=>$video->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($video->date_created) ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="video-block section-padding" id="tab_post" style="display: none;">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>
							Posts
							<?php if($this->session->userdata('loggedin')) { ?>
								<?php if($channel->user_id == $this->session->userdata('id')) { ?>
									<div class="float-right">
										<a href="<?= BASE_URL ?>post/create/<?= $channel->id ?>" class="right-action-link text-gray">Create new post <i class="fa fa-plus"></i></a>
									</div>
								<?php } ?>
							<?php } ?>
						</h6>
					</div>
				</div>
				<div class="col-xl-12 col-sm-12 mb-12">
					<?php if(count($posts) != 0) { ?>
						<?php foreach ($posts as $post) { ?>
							<div class="col-md-12">
								<div class="video-card video-card-list" style="cursor: pointer;" onclick="window.location.href='<?= BASE_URL?>post/view/<?= $channel->id ?>/<?= $post->id ?>';">
									<div class="user-image text-center">
										<?php $usr = db_get_row_data('users',array('id'=>$post->user_id)); ?>
										<div class="channels-card-image" data-toggle="tooltip" data-placement="bottom" title="<?= $usr->full_name ?>">
											<?php if($usr->profile_image != ''){ ?>
												<?php if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){ ?>
													<img src="<?= BASE_URL . 'upload_data/user/' . $usr->profile_image; ?>" alt="<?= $usr->full_name ?>" />
												<?php } else { ?>
													<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" />
												<?php } ?>
											<?php } else { ?>
												<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" />
											<?php } ?>
										</div>
									</div>
									<div class="video-card-body">
										<div class="video-page">
											<?= substr(strip_tags($post->content),0,300) . '....' ?>
										</div>
										<div class="video-view">
											<?= db_get_count_data('post_comment',array('post_id'=>$post->id)) ?> comments &nbsp;<i class="fa fa-history"></i> <?= time_elapsed_string($post->date_created) ?>
										</div>
									</div>
								</div>
								<hr />
							</div>
						<?php } ?>
					<?php } else { ?>
						<?php if($channel->user_id == $this->session->userdata('id')) { ?>
							<div class="col-xl-3 col-sm-6 mb-3">
								<div class="channels-card">
									<div class="channels-card-image">
										<a href="<?= BASE_URL ?>post/create/<?= $channel->id ?>"><i class="fa fa-plus fa-4x"></i></a>
									</div>
									<div class="channels-card-body">
										<div class="channels-title">
											<a href="<?= BASE_URL ?>post/create/<?= $channel->id ?>">Submit Your First Post</a>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="video-block section-padding" id="tab_about" style="display: none;">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>About Channel</h6>
					</div>
				</div>
				<div class="col-xl-12 col-sm-12 mb-12">
					<?php
						if(!empty($channel->description))
						{
					?>
					<div class="video-card">
						<div class="video-card-body">
							<p style="text-align: justify; font-size: 14px; padding-top: 15px;"><?= $channel->description ?></p>
							<hr />
							<?php if ($channel->website != '') { ?>
								<p>Visit our website : <a href="<?= $channel->website ?>" target="_blank"><?= $channel->website ?></a></p>
							<?php } ?>
							<?php if ($channel->facebook_url != '') { ?>
								<p><i class="fa fa-facebook-square"></i> Follow us on Facebook : <a href="<?= $channel->facebook_url ?>" target="_blank"><?= $channel->facebook_url ?></a></p>
							<?php } ?>
							<?php if ($channel->instagram_url != '') { ?>
								<p><i class="fa fa-instagram"></i> Follow us on Instagram : <a href="<?= $channel->instagram_url ?>" target="_blank"><?= $channel->instagram_url ?></a></p>
							<?php } ?>
							<?php if ($channel->twitter_url != '') { ?>
								<p><i class="fa fa-twitter-square"></i> Follow us on Twitter : <a href="<?= $channel->twitter_url ?>" target="_blank"><?= $channel->twitter_url ?></a></p>
							<?php } ?>
							<?php if ($channel->google_url != '') { ?>
								<p><i class="fa fa-google-plus-square"></i> Check us on Google+ : <a href="<?= $channel->google_url ?>" target="_blank"><?= $channel->google_url ?></a></p>
							<?php } ?>
							<?php if ($channel->linkedin_url != '') { ?>
								<p><i class="fa fa-linkedin-square"></i> Join us on Linkedin : <a href="<?= $channel->linkedin_url ?>" target="_blank"><?= $channel->linkedin_url ?></a></p>
							<?php } ?>
							<?php if ($channel->pinterest_url != '') { ?>
								<p><i class="fa fa-pinterest-square"></i> Follow us on Pinterest : <a href="<?= $channel->pinterest_url ?>" target="_blank"><?= $channel->pinterest_url ?></a></p>
							<?php } ?>
							<?php if ($channel->email != '') { ?>
								<p><i class="fa fa-envelope"></i> Follow us on Pinterest : <a href="<?= $channel->email ?>" target="_blank"><?= $channel->email ?></a></p>
							<?php } ?>
						</div>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="video-block section-padding" id="tab_contact_us" style="display: none;">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>Contact Us</h6>
					</div>
				</div>
				<div class="col-xl-12 col-sm-12 mb-12">
					<?= form_open('', [
						'name'			=> 'form_contact_us', 
						'id'			=> 'form_contact_us', 
						'method'		=> 'POST',
						'enctype'		=> 'multipart/form-data'
					]);
					?>
					<div class="osahan-form">
						<div class="row">
							<?php if(!$this->session->userdata('loggedin')) { ?>
								<div class="col-lg-12">
									<div class="form-group">
										<label for="email">Email</label>
										<input type="email" placeholder="Email Adderss" id="email" name="email" class="form-control" required="required" />
									</div>
								</div>
							<?php } ?>
							<div class="col-lg-12">
								<div class="form-group">
									<label for="title">Title</label>
									<input type="text" placeholder="Title" id="title" name="title" class="form-control" required="required" />
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label for="message">Message</label>
									<textarea rows="5" id="message" name="message" class="form-control" placeholder="Post your query..."></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="osahan-area mt-3">
						<button type="submit" class="btn btn-success border-none" name="save">Send</button>
					</div>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<script>
		function set_active(tab_value) {
			$('.video-block').hide();
			$('#'+tab_value).fadeIn();
		}
		$(document).on('keypress','#custom_url',function (e) {
			var k;
			document.all ? k = e.keyCode : k = e.which;
			return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
		});

		$(document).on('keyup','#custom_url',function () {
			var channelUrl = $(this).val();
			channelUrl = channelUrl.replace(/\s+/g, '-').toLowerCase();
			$(this).val(channelUrl);
		})
	</script>