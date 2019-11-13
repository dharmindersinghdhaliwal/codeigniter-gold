<link href="<?= BASE_ASSET ?>bootstrap-tagsinput/bootstrap_tagsinput.css" rel="stylesheet" />
<script src="<?= BASE_ASSET ?>bootstrap-tagsinput/bootstrap_tagsinput.js"></script>
<div class="block-header">
	<h2>UPDATE VIDEO</h2>
</div>

<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<?= form_open('', [
			'name'			=> 'form_edit_video',
			'id'			=> 'form_edit_video',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data',
			'class'			=> 'form-horizontal'
		]);
		?>
		<div class="card">
			<div class="header bg-orange">
				<h2>
					UPDATE VIDEO
					<small>Fill all record for update video.</small>
				</h2>
			</div>
			<div class="body">
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="video">Video</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
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
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="video_thumbnail">Thumbnail Image</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<input type="file" name="video_thumbnail" id="video_thumbnail" accept="image/x-png,image/jpeg" /><br />
							<small class="text-danger">max-width : 300px | max-height : 300px</small>
							<?php if($video->video_thumbnail != ''){ ?>
								<div class="image-view">
									<img src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $video->video_thumbnail ?>" />
									<a href="<?= BASE_URL ?>my_videos/remove_video_thumbnail/<?= $video->id ?>" onclick="return confirm('Are you sure to remove the Video Thnumbnail image ?');" class="remove"><i class="fa fa-trash"></i></a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="title">Video Title</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="title" name="title" class="form-control" placeholder="Video Title" required="required" value="<?= $video->title ?>" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="description">Description</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<textarea id="description" name="description" class="form-control" rows="5" placeholder="Description.."><?= $video->description ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="tags">Tags</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="tags" name="tags" value="<?= $video->tags ?>" class="form-control" data-role="tagsinput" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="category_id">Category</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<select name="category_id" id="category_id" class="form-control show-tick" onchange="get_states();" data-live-search="true">
								<option value="">--Select Category--</option>
								<?php foreach (db_get_all_data('category') as $category) { ?>
									<option value="<?= $category->id ?>" <?= ($video->category_id == $category->id)? 'selected' : ''; ?>><?= $category->name ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="channel_id">Channel</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<select name="channel_id" id="channel_id" class="form-control show-tick" onchange="get_states();" data-live-search="true">
								<option value="">--Select Channel--</option>
								<?php foreach (db_get_all_data('channel') as $channel) { ?>
									<option value="<?= $channel->id ?>" <?= ($video->channel_id == $channel->id)? 'selected' : ''; ?>><?= $channel->name ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label>Status</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="demo-radio-button">
								<input type="radio" name="status" id="status" class="radio-col-green" <?= ($video->status == 1)? 'checked' : ''; ?> value="1" />
								<label for="status">Active</label>
								<input type="radio" name="status" id="status_1" class="radio-col-red" <?= ($video->status == 0)? 'checked' : ''; ?> value="0" />
								<label for="status_1">Inactive</label>
							</div>
						</div>
					</div>
				</div>
				<div class="progress" style="display: none;">
					<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						0%
					</div>
				</div>
				<hr />
				<button type="submit" class="btn bg-orange waves-effect" id="save_data">Update</button>
				<a href="<?= BASE_URL ?>admin/video" class="btn btn-default waves-effect">Back</a>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
</div>
<script>
	$('form#form_edit_video').submit(function(){

		var form_edit_video = $('#form_edit_video');
		var formData = new FormData(this);

		$('.progress-bar').css('width',0+"%");
		$('.progress').fadeIn("slow");

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
						}
					}
				}, false);
				return xhr;
			},
			url: '<?= BASE_URL ?>admin/video/edit_save/<?= $video->id ?>',
			type: 'POST',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
		})
		.done(function(res) {
			if (res.success) {
				window.location.replace("<?= BASE_URL ?>admin/video");
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