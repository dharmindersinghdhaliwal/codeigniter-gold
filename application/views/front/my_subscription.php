<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>My Subscriptions</h6>
					</div>
				</div>
				<?php foreach ($subscribes as $subscribe) { ?>
					<?php $channel = db_get_row_data('channel',array('id'=>$subscribe->channel_id)); ?>
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