<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="top-mobile-search">
			<div class="row">
				<div class="col-md-12">   
					<form class="mobile-search" action="<?= BASE_URL ?>search" method="get">
						<div class="input-group">
							<input type="text" placeholder="Search for..." name="srch" id="srch" class="form-control">
							<div class="input-group-append">
								<button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</form>   
				</div>
			</div>
		</div>
		<div class="top-category section-padding mb-4">
			<div class="row">
				<div class="col-md-12">
					<?= get_option('ads_header') ?>
					<!-- <div class="owl-carousel owl-carousel-category">
						<?php foreach (db_get_all_data('category') as $category) { ?>
							<div class="item">
								<div class="category-item">
									<a href="<?= BASE_URL ?>category/<?= $category->id ?>">
										<i class="fa <?= $category->icon ?> fa-2x"></i>
										<h6><?= $category->name ?></h6>
									</a>
								</div>
							</div>
						<?php } ?>
					</div> -->
				</div>
			</div>
		</div>
		<hr>
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>New Videos</h6>
					</div>
				</div>
				<?php foreach ($videos as $video) { ?>
					<div class="col-lg-2 col-xl-3 col-sm-6 col-md-4 mb-3">
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
									<?= $category->name ?>  <a href="javascript:void(0);"><i class="fas <?= $category->icon ?> text-success"></i></a>
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
		<hr class="mt-0">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>New Channels</h6>
					</div>
				</div>
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
			</div>
		</div>
	</div>