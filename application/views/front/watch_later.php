<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>Watch Later Video Saved</h6>
					</div>
				</div>
				<?php foreach ($video_watch_laters as $video_watch_later) { ?>
					<?php $vid = db_get_row_data('videos',array('id'=>$video_watch_later->video_id)) ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="video-card">
							<div class="video-card-image">
								<a class="video-close" href="<?= BASE_URL ?>watch_later/remove/<?= $video_watch_later->id ?>" onclick="return confirm('Are you sure to remove the watch later record ?');"><i class="fas fa-times-circle"></i></a>
								<a class="play-icon" href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>"><i class="fas fa-play-circle"></i></a>
								<a href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>">
									<?php if($vid->video_thumbnail != ''){ ?>
										<img class="img-fluid" style="height: 142px;" src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $vid->video_thumbnail ?>" alt="<?= $vid->title ?>">
									<?php } else { ?>
										<video style="width: 100%; height: 142px;" preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $vid->video ?>#t=0.5"></video>
									<?php } ?>
								</a>
							</div>
							<div class="video-card-body">
								<div class="video-title">
									<a href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>"><?= $vid->title ?></a>
								</div>
								<div class="video-page text-success">
									<?php $category = db_get_row_data('category',array('id'=>$vid->category_id)); ?>
									<?= $category->name ?>  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas <?= $category->icon ?> text-success"></i></a>
								</div>
								<div class="video-view">
									<?= db_get_count_data('history',array('video_id'=>$vid->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($vid->date_created) ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>