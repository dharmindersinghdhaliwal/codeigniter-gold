<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="row">
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card text-white bg-primary o-hidden h-100 border-none">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fas fa-fw fa-users"></i>
						</div>
						<div class="mr-5"><b><?= db_get_count_data('channel',array('user_id'=>$this->session->userdata('id'))) ?></b> Channels</div>
					</div>
					<a class="card-footer text-white clearfix small z-1" href="<?= BASE_URL ?>channels">
						<span class="float-left">View Details</span>
						<span class="float-right">
							<i class="fas fa-angle-right"></i>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card text-white bg-warning o-hidden h-100 border-none">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fas fa-fw fa-video"></i>
						</div>
						<div class="mr-5"><b><?= db_get_count_data('videos',array('user_id'=>$this->session->userdata('id'))) ?></b> Videos</div>
					</div>
					<a class="card-footer text-white clearfix small z-1" href="<?= BASE_URL ?>my_videos">
						<span class="float-left">View Details</span>
						<span class="float-right">
							<i class="fas fa-angle-right"></i>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card text-white bg-success o-hidden h-100 border-none">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fas fa-fw fa-list-alt"></i>
						</div>
						<div class="mr-5"><b><?= $subscribers ?></b> Total Subscribers</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card text-white bg-danger o-hidden h-100 border-none">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fas fa-fw fa-cloud-upload-alt"></i>
						</div>
						<div class="mr-5"><b><?= $views ?></b> User viewed Video</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>My Videos</h6>
						<div class="btn-group float-right right-action">
							<a href="<?= BASE_URL ?>upload" class="right-action-link text-gray">Upload New Video <i class="fa fa-plus"></i></a>
						</div>
					</div>
				</div>
				<?php if (count($videos) != 0) { ?>
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
									<!-- <div class="time">3:50</div> -->
								</div>
								<div class="video-card-body">
									<div class="video-title">
										<a href="<?= BASE_URL ?>video_play?vid=<?= $video->id ?>"><?= $video->title ?></a>
									</div>
									<div class="video-page text-success">
									<?php $category = db_get_row_data('category',array('id'=>$video->category_id)); ?>
									<?= $category->name ?> <a href="#"><i class="fa <?= $category->icon ?> text-success"></i></a>
									</div>
									<div class="video-view">
										<?= db_get_count_data('history',array('video_id'=>$video->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($video->date_created) ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="channels-card">
							<div class="channels-card-image">
								<a href="<?= BASE_URL ?>upload"><i class="fa fa-plus fa-4x"></i></a>
							</div>
							<div class="channels-card-body">
								<div class="channels-title">
									<a href="<?= BASE_URL ?>upload">Upload Your First Video</a>
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
						<h6>My Channels</h6>
						<div class="btn-group float-right right-action">
							<a href="<?= BASE_URL ?>channels/create" class="right-action-link text-gray">Create New Channel <i class="fa fa-plus"></i></a>
						</div>
					</div>
				</div>
				<?php if (count($channels) != 0) { ?>
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
								</div>
								<div class="channels-card-body">
									<div class="channels-title">
										<a href="<?= BASE_URL ?>channels/view/<?= $channel->id ?>"><?= $channel->name ?></a>
									</div>
									<div class="channels-view">
										<?= db_get_count_data('subscribe',array('channel_id'=>$channel->id)) ?> subscribers
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="channels-card">
							<div class="channels-card-image">
								<a href="<?= BASE_URL ?>channels/create"><i class="fa fa-plus fa-4x"></i></a>
							</div>
							<div class="channels-card-body">
								<div class="channels-title">
									<a href="<?= BASE_URL ?>channels/create">Create Your First Channel</a>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->