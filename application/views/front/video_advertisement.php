<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Submit Video Advertisement </h6>
				</div>
				<hr />
			</div>
		</div>
		<?= form_open('', [
			'name'			=> 'upload_advertisement', 
			'id'			=> 'upload_advertisement', 
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div class="row">

			<div class="col-lg-8">
				<div class="form-group">
					<label for="advertise">Advertisment Title</label>
					<div class="input-group">
						<input type="text" placeholder="Advertisement Title" id="title" name="title" class="form-control" required="required">
				 	</div>
				</div>
				<div class="form-group">
					<label for="advertise">My Videos</label>
					<div class="input-group">
						<select class="custom-select" id="myVideo" name="myVideo" required="required">
							<option value="">---Select Your Video---</option>						   
							<?php foreach ( db_get_all_data('videos',array('user_id' => $this->session->userdata('id'))) as $video) { ?>
								<option value="<?= $video->id ?>"><?= $video->title ?></option>
							<?php } ?>
					  	</select>
				  </div>
				</div>
				<div class="form-group">
					<label for="advertise">Advertisment Timing</label>
					<div class="input-group">
						<select class="custom-select" id="selectTiming" name="selectTiming" required="required">
							<option value="1">Starting </option>
						    <option value="2">In middle</option>
						    <option value="3">At the end</option>
					 	</select>
				 	</div>
				</div>
				<div class="form-group">
					<label for="advertise">Upload Your Advertisement</label>
					<div class="input-group">
					  <div class="custom-file">
					    <input type="file" class="custom-file-input" id="advtVideo" name="advtVideo" aria-describedby="advtVideo" required="required">
					    <label class="custom-file-label" for="advtVideo">Choose file</label>
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
		</div> <!--/row-->

		<div class="row">
			<div class="col-sm-8">
				<button type="submit" class="btn btn-primary btn-sm"> Submit for review </button>
			</div>
		</div>		
		<?= form_close(); ?>
	</div>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<script type="text/javascript">
		$('form#upload_advertisement').submit(function(){
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
				url: '<?= BASE_URL ?>video_advertisement/submit_advt',
				type: 'POST',data: formData,cache: false,contentType: false,processData: false,
			})
			.done(function(res) {
				$('.message').html(res.message);
				$('.message').fadeIn();
				
				/**Make form clear**/
				$(':input','#upload_advertisement')
				  .not(':button, :submit, :reset, :hidden')
				  .val('')
				  .prop('checked', false)
				  .prop('selected', false);
				})

			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Error save data</div>');
				$('.message').fadeIn();
			});
			return false;
		});
	</script>