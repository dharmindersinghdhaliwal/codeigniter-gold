<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<?= form_open('', ['name'=> 'update_advt', 'id'	=> 'update_advt', 'method'=> 'POST','enctype'=> 'multipart/form-data']);?>
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Update Advertisement Content</h6>
				</div>
			</div>
		</div>
		<?php
		if($advertisement->payment_status==1){
		?>
		<div class=" alert-info" style="position: relative;padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">
		  <strong>Info!</strong> Once Payment is completed you only can edit the show/hide option. 
		</div>
		<?php
		}
		?>
		<hr>
		<div class="row">
			<div class="col-lg-12">
				<div class="osahan-form">
					<div class="row">
						<div class="col-lg-6">
							<?php
							$disabled='';
							$readonly='';
							// Once payment is completed user can not chnage advertisement video
							if($advertisement->payment_status==0){
							?>
							<div class="form-group">
								<label for="video">Select Advertisement File</label><br />
								<input type="file" name="advtVideo" id="advtVideo" accept="video/mp4,video/webm,video/flv" /><br />
								<small class="text-danger">Allow file type : MP4 | WEBM | FLV</small>
								<?php if($advertisement->advertisement != ''){ ?>
									<div class="image-view">
										<video width="100" height="100" preload="metadata" src="<?= BASE_URL ?>upload_data/advt/<?= $advertisement->advertisement ?>#t=0.5"></video>
										<a href="<?= BASE_URL ?>my_advertisements/remove_advt_video/<?= $advertisement->id ?>" onclick="return confirm('Are you sure to remove the video file ?');" class="remove"><i class="fa fa-trash"></i></a>
									</div>
								<?php } ?>
							</div>
							<?php
							}else{
								$disabled = 'disabled="true"';
								$readonly ='readonly';
								if($advertisement->advertisement != ''){
									?>
							<div class="image-view">
								<div class="single-video">
									<video id="player1" preload="auto" width="640" height="360"	style="max-width:100%;"	controls playsinline webkit-playsinline src="<?= BASE_URL ?>upload_data/advt/<?= $advertisement->advertisement ?>#t=0.5" onClick="this.play()"></video>
								</div>
							</div>
							<?php
								}
							}
							?>
							<p>
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
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" placeholder="Video Title" id="title" name="title" class="form-control" required="required" value="<?= $advertisement->title ?>" <?= $readonly ?>/>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">My Videos</label>
								<select class="custom-select" id="myVideo" name="myVideo" required="required" <?= $disabled ?>>
									<?php foreach ( db_get_all_data('videos',array('user_id' => $this->session->userdata('id'))) as $video) { ?>
										<option value="<?= $video->id ?>" <?=  $video->id==$advertisement->video_id ? 'selected': '' ;?> ><?= $video->title ?></option><?php } ?>
							  	</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="tags">Timing</label>
								<select class="custom-select" id="selectTiming" name="selectTiming" required="required" <?= $disabled ?>>
									<option value="1" <?= 1==$advertisement->timing ? 'selected': '' ; ?>>Starting </option>
								    <option value="2" <?= 2==$advertisement->timing ? 'selected': '' ; ?>>In middle</option>
								    <option value="3" <?= 3==$advertisement->timing ? 'selected': '' ; ?>>At the end</option>
							 	</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="tags">Show Advertisement</label>
								<p><input type="checkbox" name="status" <?= $advertisement->status==1 ? 'checked': '' ; ?> value="1"></p>
							</div>
						</div>
					</div>
					<div class="row" id="uploading_status" style="display: none;">
						<div class="col-lg-12">
							<div class="osahan-title"></div>
							<div class="osahan-size"></div>
							<div class="osahan-progress">
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
								</div>
							</div>
							<div class="osahan-desc">Your Video is still uploading, please keep this page open until it's done.</div>
						</div>
					</div>
				</div>
				<div class="osahan-area mt-3">
					<a href="<?= BASE_URL ?>my_advertisements" class="btn btn-danger border-none"> Cancel </a>
					<button class="btn btn-success border-none" name="save">Update</button>
				</div>
			</div>
		</div>	
		
		<?= form_close(); ?>
	</div>
	<script>	
		$('#advtVideo').bind('change', function() {
			var fileName = this.files[0].name;
			var fileSize = this.files[0].size;
			var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
			i=0;
			while(fileSize>900){
				fileSize/=1024;
				i++;
			}
			var exactSize = (Math.round(fileSize*100)/100)+' '+fSExt[i];
			$('.osahan-title').text(fileName);
			$('.osahan-size').text(exactSize);
		});
		
		$('form#update_advt').submit(function(){

			var formData = new FormData(this);

			$('.progress-bar').css('width',0+"%");
			$('.progress').fadeIn("slow");
			$('#uploading_status').fadeIn();

			$.ajax({
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							percentComplete = parseInt(percentComplete * 100);
							$('.progress-bar').css('width',percentComplete+"%");
							$('.progress-bar').attr('aria-valuenow',percentComplete);
							$('.progress-bar').html(percentComplete+"%");
							if(percentComplete === 100) {
								$('.progress').fadeOut("slow");
								$('.progress-bar').html("Upload Complete");
								$('#uploading_status').fadeOut();
							}
						}
					}, false);
					return xhr;
				},
				url: '<?= BASE_URL ?>my_advertisements/update_advt/<?= $advertisement->id ?>',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
			})
			.done(function(res) {
				if (res.success) {
					window.location.replace("<?= BASE_URL ?>my_advertisements");
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Error save data</div>');
				$('.message').fadeIn();
			})
			.always(function() {
			});
			return false;
		});		
	</script>