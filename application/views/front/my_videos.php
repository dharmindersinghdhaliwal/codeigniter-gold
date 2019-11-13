<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
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
									<div class="float-right">
										<a href="<?= BASE_URL ?>my_videos/edit/<?= $video->id ?>" data-toggle="tooltip" data-placement="bottom" title="Update Video"><i class="fa fa-pencil-square fa-2x text-warning"></i></a>
										<a href="<?= BASE_URL ?>my_videos/delete/<?= $video->id ?>" onclick="return confirm('Are you sure to remove the video ?');" data-toggle="tooltip" data-placement="bottom" title="Remove Video"><i class="fa fa-trash fa-2x text-warning"></i></a>
									</div>
									<?= db_get_count_data('history',array('video_id'=>$video->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($video->date_created) ?>
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