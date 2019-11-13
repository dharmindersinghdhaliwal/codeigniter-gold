<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>Watch History</h6>
					</div>
				</div>
				<?php foreach ($histories as $history) { ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="video-card history-video">
							<div class="video-card-image">
								<a class="video-close" href="<?= BASE_URL ?>history/remove/<?= $history->id ?>" onclick="return confirm('Are you sure to remove the history record ?');"><i class="fas fa-times-circle"></i></a>
								<a class="play-icon" href="<?= BASE_URL ?>video_play?vid=<?= $history->video_id ?>"><i class="fas fa-play-circle"></i></a>
								<a href="<?= BASE_URL ?>video_play?vid=<?= $history->video_id ?>">
									<?php if($history->video_thumbnail != ''){ ?>
										<img class="img-fluid" style="height: 142px;" src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $history->video_thumbnail ?>" alt="<?= $history->title ?>">
									<?php } else { ?>
										<video style="width: 100%; height: 142px;" preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $history->video ?>#t=0.5"></video>
									<?php } ?>
								</a>
							</div>
							<div class="video-card-body">
								<div class="video-title">
									<a href="<?= BASE_URL ?>video_play?vid=<?= $history->video_id ?>"><?= $history->title ?></a>
								</div>
								<div class="video-page text-success">
									<?= $history->name ?>  <a href="#"><i class="fa <?= $history->icon ?> text-success"></i></a>
								</div>
								<div class="video-view">
									<?= db_get_count_data('history',array('video_id'=>$history->video_id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($history->datetime) ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>