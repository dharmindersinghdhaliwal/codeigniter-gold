<div class="block-header">
	<h2>Review Advertisement</h2>
</div>
<div class="row clearfix">
	<div class="col-sm-10 col-sm-offset-1 col-xs-12">
		<div class="card">
			<div class="body">
				<div class="table-responsive">
					<?= form_open(BASE_URL . 'admin/advertisements/add_price/'.$advertisement->id, ['name'=> 'form_ad','id'=> 'form_ad','method'	=> 'POST','enctype'	=> 'multipart/form-data']);	?>
					<div class="col-xs-10 col-sm-10 col-sm-offset-1">
						<h3 class="h3"><?= $advertisement->title ?></h3>
					<?php if($advertisement->advertisement != ''){ ?>
						<video style="width: 100%; height: 400px;" preload="metadata"  src="<?= BASE_URL ?>upload_data/advt/<?= $advertisement->advertisement ?>#t=0.5" controls="controls"  onclick="this.play()"></video>
					<?php } ?>
					<p>
						<br>
						<i class="fas fa-eye"></i> <?= db_get_count_data('advt_impressions',array('advt_id'=>$advertisement->id)) ?> views 
						&nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($advertisement->date_created) ?> 
						<?php 
							$records = db_get_all_data('advt_impressions',array('advt_id'=>$advertisement->id));
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

					<div class="col-xs-10 col-sm-10 col-sm-offset-1">
						<label>Video used for this advertisement </label>
						<h4 class="h4"><?=	db_get_row_data('videos',array('id' => $advertisement->video_id))->title; ?></h4>
					</div>
					<div class="col-xs-10 col-sm-10 col-sm-offset-1">
						<label>Advertisement Timing </label>
						<?php
						  if($advertisement->timing==1){
						  	echo '<h5 class="h5">Starting</h5>';
						  }elseif($advertisement->timing==2){
						  	echo '<h5 class="h5">In middle</h5>';
						  }
						  elseif($advertisement->timing==3){
						  	echo '<h5 class="h5">At the end</h5>';
						  }
						 ?>
					</div>
					
					<div class="col-xs-10 col-sm-10 col-sm-offset-1">
						<label>Price for this advertisement</label>
						<?php
						 if(empty($advertisement->price)){
							?>
							<p><input type="text" name="price" placeholder="add price" class="form-control" style="width:50%"></p>
							<?php 	
						 }else{
						 	?>
						 	<p><strong>$ <?= $advertisement->price ?></strong> USD </p>
						 	<?php
						 }
						?>
					</div>
					
					<?php
					 if(empty($advertisement->price)){
					?>
					<div class="col-xs-10 col-sm-10 col-sm-offset-1">
						<div class="osahan-area mt-3">
							<a href="<?= BASE_URL ?>admin/advertisements" class="btn btn-danger border-none"> Cancel </a>
							<button type="submit" class="btn btn-success border-none" name="save">Update</button>
						</div>
					</div>
					<?php
					}else{
						?>
						<div class="col-xs-10 col-sm-10 col-sm-offset-1">
						<div class="osahan-area mt-3">
							<a href="<?= BASE_URL ?>admin/advertisements" class="btn btn-danger border-none"> << Back to listing </a>
						</div>
					</div>
						<?php
					}
					?>
						<?= form_close(); ?>
				</div><!--/table-responsive-->
			</div><!--/body-->
		</div><!--/card-->
	</div><!--/col-sm-10 col-sm-offset-1 col-xs-12-->
</div><!--/row clearfix-->
