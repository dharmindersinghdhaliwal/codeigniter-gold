<style type="text/css">
.video-card-list .user-image {float: left;height: auto;margin: 0 12px 0 0;width: 122px;}
.user-image {overflow: hidden;position: relative;}
</style>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-8">
					<div class="single-video-right">
						<div class="row">
							<div class="col-md-12">
								<div class="main-title">
									<h6>Search Result</h6>
								</div>
							</div>
							
							<!--Video Sarch view-->
							<?php 
							//echo '<pre>';print_r($videos);echo '</pre>';	die();
							$channels = $data['channels'];
							if(!empty($channels)){
								?>								
									<div class="col-md-12">
										<h5>Channels</h5>
										<hr>
									</div>
									
								<?php
							}
							?>
							<?php foreach ($channels as $channel) { ?>
							<div class="col-xl-3 col-sm-6 mb-3">
							<div class="channels-card">
							<div class="channels-card-image">
								<a href="<?= BASE_URL ?>channels/view/<?= $channel->id ?>">
									<?php if($channel->logo != ''){ ?>
										<img class="img-fluid" src="<?= BASE_URL ?>upload_data/channel/<?= $channel->logo ?>" alt="<?= $channel->name ?>">
									<?php } else { ?>
										<img class="img-fluid" src="<?= BASE_ASSET ?>img/s1.png" alt="<?= $channel->name ?>">
									<?php } ?>
								</a>
								<div class="channels-card-image-btn">
									<?php
									if($this->session->userdata('loggedin')){
										$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel->id,'user_id'=>$this->session->userdata('id')));
										if(count($subscribe) == 0){
											?>
											<button type="button" class="btn btn-outline-danger btn-sm sub-take" id="subscribe_button<?= $channel->id ?>" data-sub="<?= $channel->id ?>"><span id="sub-text<?= $channel->id ?>">Subscribe</span></button>
											<?php
										} else {
											?>
											<button type="button" class="btn btn-outline-secondary btn-sm sub-take" id="subscribe_button<?= $channel->id ?>" data-sub="<?= $channel->id ?>"><span id="sub-text<?= $channel->id ?>">Subscribed</span></button>
											<?php
										}
									} else {
										?>
										<button type="button" class="btn btn-outline-danger btn-sm sub-take" id="subscribe_button<?= $channel->id ?>" data-sub="<?= $channel->id ?>"><span id="sub-text<?= $channel->id ?>">Subscribe</span></button>
										<?php
									}
									?>
								</div>
							</div>
							<div class="channels-card-body">
								<div class="channels-title">
									<a href="<?= BASE_URL ?>channels/view/<?= $channel->id ?>">
										<?= $channel->name ?> 
										<?php if($channel->verified == 1){ ?>
											<span data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span>
										<?php } ?>
									</a>
								</div>
								<div class="channels-view">
									<span id="channel_subs_count<?= $channel->id ?>"><?= db_get_count_data('subscribe',array('channel_id'=>$channel->id)) ?></span> subscribers
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
							<?php 
							/*foreach ($videos as $vid) { ?>
								<div class="col-md-12">
									<div class="video-card video-card-list">
										<div class="video-card-image">
											<a class="play-icon" href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>"><i class="fas fa-play-circle"></i></a>
											<a href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>">
												<?php if($vid->video_thumbnail != ''){ ?>
													<img class="img-fluid" src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $vid->video_thumbnail ?>" alt="<?= $vid->title ?>">
												<?php } else { ?>
													<video preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $vid->video ?>#t=0.5"></video>
												<?php } ?>
											</a>
										</div>
										<div class="video-card-body">
											<div class="video-title">
												<a href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>"><?= $vid->title ?></a>
											</div>
											<div class="video-page text-success">
												<?= $vid->name ?>  <a href="#"><i class="fa <?= $vid->icon ?> text-success"></i></a>
											</div>
											<div class="video-view">
												<?= db_get_count_data('history',array('video_id'=>$vid->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($vid->date_created) ?>
											</div>
										</div>
									</div>
									<hr />
								</div>
							<?php } */
							//echo '<pre>';print_r($data);echo '</pre>';	die();
							$posts = $data['posts'];
							if(!empty($posts)){
								?>
									
									<div class="col-md-12">
										<h5>Posts</h5>
										<hr>
									</div>
								
								<?php
							}
							?>
							<!--Post search View-->
							<div class="col-md-12">
								<?php foreach ($posts as $pst) { ?>
									<div class="video-card video-card-list" style="cursor: pointer;" onclick="window.location.href='<?= BASE_URL?>post/<?= $pst->id ?>';">
										<div class="user-image text-center">
											<?php $usr = db_get_row_data('users',array('id'=>$pst->user_id)); ?>
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
												<?= substr(strip_tags($pst->content),0,300) . '....' ?>
											</div>
											<div class="video-view">
												<?= db_get_count_data('post_comment',array('post_id'=>$pst->id)) ?> comments &nbsp;<i class="fa fa-history"></i> <?= time_elapsed_string($pst->date_created) ?>
											</div>
										</div>
									</div>
									<hr />
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>