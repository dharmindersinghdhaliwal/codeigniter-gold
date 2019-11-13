<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2">
		<div class="card">
			<div class="header">
				<h2>
					Profile
				</h2>
			</div>
			<div class="body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#tab_general" class="tab_group" data-toggle="tab"><i class="material-icons">person_pin</i> My Profile</a></li>
					<li><a href="#tab_password" class="tab_group" data-toggle="tab"><i class="material-icons">lock_outline</i> Change Password</a></li>
				</ul>
				<?= form_open('', [
					'name'    => 'form_profile', 
					'id'      => 'form_profile', 
					'method'  => 'POST'
				]);
				?>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="tab_general">
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="form-label">Profile Image</label>
									<input type="file" id="profile_image" name="profile_image" />
									<?php if($profile->profile_image != ''){ ?>
									<div class="image-view" style="position: absolute; margin-top: -60px; margin-left: 200px;">
										<img src="<?= BASE_URL . 'upload_data/admin/' . $profile->profile_image ?>" style="width: 25%;" />
										<a href="<?= BASE_URL ?>admin/dashboard/remove_profile_image" onclick="return confirm('Are you sure to remove the Profile Image ?');" class="remove"><i class="material-icons">delete</i></a>
									</div>
									<?php } ?>
									<small class="text-indigo">File Format : JPG | JPEG | PNG</small>
									<div class="progress" style="display: none;">
										<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
											0%
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="full_name" name="full_name" class="form-control" value="<?= $profile->full_name; ?>" />
										<label class="form-label">Full Name</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="email" id="email" name="email" class="form-control" value="<?= $profile->email; ?>" />
										<label class="form-label">Email Address</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<div class="form-line">
										<textarea id="address" name="address" class="form-control"><?= $profile->address; ?></textarea>
										<label class="form-label">Address</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="tab_password">
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="password" id="opassword" name="opassword" class="form-control" />
										<label class="form-label">Old Password</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="password" id="password" name="password" class="form-control" />
										<label class="form-label">New Password</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="password" id="cpassword" name="cpassword" class="form-control" />
										<label class="form-label">Confirm Password</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-block btn-lg bg-orange waves-effect" id="btn_save">Update</button>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('form#form_profile').submit(function(){
			var form_profile = $('#form_profile');
			var formData = new FormData(this);
			$('.progress-bar').css('width',0+"%");
			$('.progress').show();


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
				url: '<?= BASE_URL ?>admin/dashboard/profile_save',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
			})
			.done(function(res) {
				console.log(res);
				if (res.success) {
					$('.message').html(res.message);
					$('.message').fadeIn();
					$('.btn_undo').hide();

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
	});

	$(document).on('keydown','#username',function() {
		var str = $(this).val();
		if(/^[a-zA-Z0-9]*$/.test(str) == false) {
			this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
			$('.message').html('<div class="alert alert-danger">Username not allow space and any special character.</div>');
			$('.message').fadeIn();

			return false;
		} else {
			$('#subdomain_url').text(str);
		}
	});
</script>