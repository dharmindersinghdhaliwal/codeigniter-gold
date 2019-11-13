<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<?php if($this->session->userdata('loggedin')) { ?>
			<div class="video-block section-padding">
				<div class="row">
					<div class="col-md-12">
						<div class="main-title">
							<div class="btn-group float-right right-action">
								<a href="<?= BASE_URL ?>channels/create" class="right-action-link text-gray">Create New Channel <i class="fa fa-plus"></i></a>
							</div>
							<h6>My Channels</h6>
						</div>
					</div>
					<?php if (count($my_channels) != 0) { ?>
						<?php foreach ($my_channels as $my_channel) { ?>
							<div class="col-xl-3 col-sm-6 mb-3">
								<div class="channels-card">
									<div class="channels-card-image">
										<a href="<?= BASE_URL ?>channels/view/<?= $my_channel->id ?>">
											<?php if($my_channel->logo != ''){ ?>
												<img class="img-fluid" src="<?= BASE_URL ?>upload_data/channel/<?= $my_channel->logo ?>" alt="<?= $my_channel->name ?>" />
											<?php } else { ?>
												<img class="img-fluid" src="<?= BASE_ASSET ?>img/s1.png" alt="<?= $my_channel->name ?>" />
											<?php } ?>
										</a>
									</div>
									<div class="channels-card-body">
										<div class="channels-title">
											<a href="<?= BASE_URL ?>channels/view/<?= $my_channel->id ?>">
												<?= $my_channel->name ?> 
												<?php if($my_channel->verified == 1){ ?>
													<span data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle"></i></span>
												<?php } ?>
											</a>
										</div>
										<div class="channels-view">
											<?= db_get_count_data('subscribe',array('channel_id'=>$my_channel->id)) ?> subscribers
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
			<hr>
		<?php } ?>
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>All Channels</h6>
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