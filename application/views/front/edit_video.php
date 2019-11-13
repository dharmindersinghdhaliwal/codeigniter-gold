<link rel="Stylesheet" type="text/css" href="<?= BASE_ASSET ?>croppie/croppie.css" />
<script src="<?= BASE_ASSET ?>croppie/croppie.js"></script>
<style type="text/css">
#my-image, #use {
	display: none;
}
</style>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<?= form_open('', [
			'name'			=> 'form_upload', 
			'id'			=> 'form_upload', 
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Update Video Content</h6>
				</div>
			</div>
		</div>
		<hr>
		<div id="thumbImageModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Make Your Video Thumbnail Image</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<input type='file' id="imgInp" accept="image/x-png,image/gif,image/jpeg" />
						<img id="my-image" src="#" />
					</div>
					<div class="modal-footer">
						<button type="button" id="use" class="btn btn-primary btn-sm" data-dismiss="modal">Done</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="osahan-form">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="video">Select Video File</label><br />
								<input type="file" name="video" id="video" accept="video/mp4,video/webm,video/flv" /><br />
								<small class="text-danger">Allow file type : MP4 | WEBM | FLV</small>
								<?php if($video->video != ''){ ?>
									<div class="image-view">
										<video width="100" height="100" preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $video->video ?>#t=0.5"></video>
										<a href="<?= BASE_URL ?>my_videos/remove_video/<?= $video->id ?>" onclick="return confirm('Are you sure to remove the video file ?');" class="remove"><i class="fa fa-trash"></i></a>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#thumbImageModal">Select Video Thnumbnail</button>
								<input type="hidden" id="video_thumbnail" name="video_thumbnail" value="" />
								<div class="image-view" id="imageViewVideoThumbnail">
									<?php if($video->video_thumbnail != ''){ ?>
										<img src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $video->video_thumbnail ?>" />
										<a href="<?= BASE_URL ?>my_videos/remove_video_thumbnail/<?= $video->id ?>" onclick="return confirm('Are you sure to remove the Video Thnumbnail image ?');" class="remove"><i class="fa fa-trash"></i></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="title">Video Title</label>
								<input type="text" placeholder="Video Title" id="title" name="title" class="form-control" required="required" value="<?= $video->title ?>" />
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">About</label>
								<textarea rows="3" id="description" name="description" class="form-control" placeholder="Description"><?= $video->description ?></textarea>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="tags">Tags</label>
								<input type="text" id="tags" name="tags" class="form-control" value="<?= $video->tags ?>" data-role="tagsinput" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group">
								<label for="channel_id">Channel</label>
								<select id="channel_id" name="channel_id" class="custom-select" required="required">
									<option value="">-- Select Channel --</option>
									<?php foreach (db_get_all_data('channel',array('user_id'=>$this->session->userdata('id'))) as $channel) { ?>
										<option value="<?= $channel->id ?>" <?= ($video->channel_id == $channel->id)? 'selected' : ''; ?>><?= $channel->name ?></option>
									<?php } ?>
								</select>
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
					<a href="<?= BASE_URL ?>my_videos" class="btn btn-danger border-none"> Cancel </a>
					<button class="btn btn-success border-none" name="save">Update</button>
				</div>
			</div>
		</div>
			<input type="hidden" name="duration" id="duration" value="<?= isset($video->duration)?$video->duration:'' ?>">
			<audio id='audio'></audio> 
		<?= form_close(); ?>
	</div>

	<script>
		/**get file Duration and add into hideen field***/
		var f_duration =0; //store duration 
			document.getElementById('audio').addEventListener('canplaythrough', function(e){		 	
		 	f_duration = Math.round(e.currentTarget.duration);
			 document.getElementById('duration').value = f_duration; 
		 	URL.revokeObjectURL(obUrl);
		});
		//when select a file, create an ObjectURL with the file and add it in the #audio element 
		var obUrl; 
		document.getElementById('video').addEventListener('change', function(e){ 
		 	var file = e.currentTarget.files[0]; 
		 	//check file extension for audio/video type 
		 	if(file.name.match(/\.(avi|mp3|mp4|mpeg|ogg)$/i)){ 
			 	obUrl = URL.createObjectURL(file); 
			 	document.getElementById('audio').setAttribute('src', obUrl); 
			 }
		});
		/***Ends**/
		$('#video').bind('change', function() {
			var fileName = this.files[0].name;
			var fileSize = this.files[0].size;
			var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
			i=0;
			while(fileSize>900)
			{
				fileSize/=1024;
				i++;
			}
			var exactSize = (Math.round(fileSize*100)/100)+' '+fSExt[i];

			$('.osahan-title').text(fileName);
			$('.osahan-size').text(exactSize);
		});
		$('form#form_upload').submit(function(){

			var form_upload = $('#form_upload');
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
				url: '<?= BASE_URL ?>upload/upload_update/<?= $video->id ?>',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
			})
			.done(function(res) {
				if (res.success) {
					window.location.replace("<?= BASE_URL ?>my_videos");
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

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imgInp').fadeOut();
					$('#my-image').attr('src', e.target.result);
					var resize = new Croppie($('#my-image')[0], {
						viewport: { width: 300, height: 300 },
						boundary: { width: 400, height: 400 },
						showZoomer: false,
						enableResize: false,
						enableOrientation: true
					});
					$('#use').fadeIn();
					$('#use').on('click', function() {
						resize.result('base64').then(function(dataImg) {
							var data = [{ image: dataImg }, { name: 'myimgage.jpg' }];
							$('#imageViewVideoThumbnail').html('<img src="'+dataImg+'" />');
							$('#video_thumbnail').val(dataImg);
						})
					})
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		$("#imgInp").change(function() {
			readURL(this);
		});
	</script>