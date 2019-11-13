<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>My Advertisements</h6>
						<div class="btn-group float-right right-action">
							<a href="<?= BASE_URL ?>video_advertisement" class="right-action-link text-gray">Submit New Advertisement <i class="fa fa-plus"></i>
							</a>
						</div>
					</div>
				</div>
				
				<?php foreach ($advertisements as $video) { ?>
					<div class="col-xl-3 col-sm-6 mb-3">
						<div class="video-card">
							<div class="video-card-image">
								<a href="#">
									<video style="width: 100%; height: 142px;" preload="metadata" src="<?= BASE_URL ?>upload_data/advt/<?= $video->advertisement ?>#t=0.5" controls="controls"  onclick="this.play()"></video>
								</a>
							</div>
							<div class="video-card-body">
								<div class="video-title">
									<a href="#"><?= $video->title ?></a>
								</div>
								<div class="video-view">
									<div class="float-right">
										<a href="<?= BASE_URL ?>my_advertisements/edit/<?= $video->id ?>" data-toggle="tooltip" data-placement="bottom" title="Edit advertisement">
											<i class="fa fa-pencil-square fa-2x text-warning"></i>
										</a>
										<a href="<?= BASE_URL ?>my_advertisements/delete/<?= $video->id ?>" onclick="return confirm('Are you sure to remove the advertisement ?');" data-toggle="tooltip" data-placement="bottom" title="Remove advertisement">
											<i class="fa fa-trash fa-2x text-warning"></i>
										</a>
									</div>
									<p class="mb-0">
									<i class="fas fa-eye"></i> <?= db_get_count_data('advt_impressions',array('advt_id'=>$video->id)) ?> views 
									&nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($video->date_created) ?> 
									<?php
										$records = db_get_all_data('advt_impressions',array('advt_id'=>$video->id));
										$secs = 0;

										if(!empty($records)){
											foreach($records as $record){
										   		$secs+= $record->watch_time;
											}
										}
										$hours 		= floor($secs / 3600);
										$minutes	= floor(($secs / 60) % 60);
										$seconds 	= $secs % 60;
									?>
									&nbsp;<i class="fa fa-clock-o" aria-hidden="true"></i> <?= "$hours:$minutes:$seconds" ?>
									</p>
								</div>
								<?php
								//check if admin approved
								if(db_get_row_data('advertisement',array('id'=>$video->id))->admin_approve==1){

									if(db_get_row_data('advertisement',array('id'=>$video->id))->payment_status==1){
										?>
										<a href="<?= BASE_URL ?>my_advertisements/edit/<?= $video->id ?>" class="btn btn-success btn-sm payNow" >Payment Complete</a>
										<?php
									}else{
									?>
										<a href="<?= BASE_URL ?>my_advertisements/payment/<?= $video->id ?>" class="btn btn-primary btn-sm payNow" title="Proceed to payment">Pay Now</a>
									<?php	
									}
									
								}
								if(db_get_row_data('advertisement',array('id'=>$video->id))->admin_approve==0){
									?>
									<a href="javascript:void(0)" class="btn btn-primary btn-sm payNow" title="Waiting for admin approval">Waiting for admin approval</a>
									<?php
								}
								?>

							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<style type="text/css">
		.payNow{padding: 0px 5px;display: block;clear: both;}
	</style>