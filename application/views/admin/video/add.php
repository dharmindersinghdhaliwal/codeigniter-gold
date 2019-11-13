<link href="<?= BASE_ASSET ?>bootstrap-tagsinput/bootstrap_tagsinput.css" rel="stylesheet" />
<script src="<?= BASE_ASSET ?>bootstrap-tagsinput/bootstrap_tagsinput.js"></script>
<div class="block-header">
	<h2>ADD NEW VIDEO</h2>
</div>

<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<?= form_open('', [
			'name'			=> 'form_add_video',
			'id'			=> 'form_add_video',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data',
			'class'			=> 'form-horizontal'
		]);
		?>
		<div class="card">
			<div class="header bg-orange">
				<h2>
					ADD VIDEO
					<small>Fill all record for new video.</small>
				</h2>
			</div>
			<div class="body">
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="video">Video</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<input type="file" name="video" id="video" accept="video/mp4,video/webm,video/flv" required="required" /><br />
							<small class="text-danger">Allow file type : MP4 | WEBM | FLV</small>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="video_thumbnail">Thumbnail Image</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<input type="file" name="video_thumbnail" id="video_thumbnail" accept="image/x-png,image/jpeg" required="required" /><br />
							<small class="text-danger">max-width : 300px | max-height : 300px</small>
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
								<input type="text" id="title" name="title" class="form-control" placeholder="Video Title" required="required" />
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
								<textarea id="description" name="description" class="form-control" rows="5" placeholder="Description.."></textarea>
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
								<input type="text" id="tags" name="tags" value="" class="form-control" data-role="tagsinput" />
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
									<option value="<?= $category->id ?>"><?= $category->name ?></option>
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
								<?php foreach (db_get_all_data('channel',array('user_id'=>$this->session->userdata('id'))) as $channel) { ?>
									<option value="<?= $channel->id ?>"><?= $channel->name ?></option>
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
								<input type="radio" name="status" id="status" class="radio-col-green" checked value="1" />
								<label for="status">Active</label>
								<input type="radio" name="status" id="status_1" class="radio-col-red" value="0" />
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
				<button type="submit" class="btn bg-orange waves-effect" id="save_data">Add</button>
				<a href="<?= BASE_URL ?>admin/video" class="btn btn-default waves-effect">Back</a>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
</div>
<script>
	$('form#form_add_video').submit(function(){

		var form_add_video = $('#form_add_video');
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
			url: '<?= BASE_URL ?>admin/video/add_save',
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