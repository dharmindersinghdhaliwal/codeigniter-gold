<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-6 mx-auto">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-title">
							<h6>Settings</h6>
						</div>
					</div>
				</div>
				<?= form_open('', [
					'name'			=> 'form_settings',
					'id'			=> 'form_settings',
					'method'		=> 'POST',
					'enctype'		=> 'multipart/form-data'
				]);
				?>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Full Name <span class="required">*</span></label>
							<input class="form-control border-form-control" value="<?= $user->full_name ?>" id="full_name" name="full_name" placeholder="Full Name" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Email Address <span class="required">*</span></label>
							<input class="form-control border-form-control" value="<?= $user->email ?>" id="email" name="email" readonly placeholder="Email Address" type="email" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group demo-masked-input">
							<label class="control-label">Date Of Birth</label>
							<input class="form-control border-form-control date" type="text" id="dob" name="dob" placeholder="Ex: 1990-01-01" value="<?= $user->dob ?>" />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Gender</label>
							<select name="gender" id="gender" class="custom-select">
								<option value="Male" <?= ($user->gender == 'Male')? 'selected' : ''; ?>>Male</option>
								<option value="Female" <?= ($user->gender == 'Female')? 'selected' : ''; ?>>Female</option>
								<option value="Other" <?= ($user->gender == 'Other')? 'selected' : ''; ?>>Other</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Address <span class="required">*</span></label>
							<textarea id="address" name="address" rows="5" placeholder="Address.." class="form-control border-form-control"><?= $user->address ?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Country</label>
							<select name="country" id="country" onchange="get_states();" class="custom-select">
								<option value="">Select Country</option>
								<?php foreach (db_get_all_data('countries') as $cntry) { ?>
									<option value="<?= $cntry->id ?>" <?= ($user->country == $cntry->id)? 'selected' : ''; ?>><?= $cntry->name ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">State</label>
							<select name="state" id="state" class="custom-select">
								<option value="">Select State</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">City</label>
							<input class="form-control border-form-control" type="text" id="city" name="city" placeholder="City Name" value="<?= $user->city ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h6>Reset Your Passwaord </h6>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Old Password</label>
							<input class="form-control border-form-control" id="opassword" name="opassword" placeholder="Password" type="password" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Password</label>
							<input class="form-control border-form-control" id="password" name="password" placeholder="Password" type="password" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Confirm Password</label>
							<input class="form-control border-form-control" id="cpassword" name="cpassword" placeholder="Confirm-Password" type="password" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?= BASE_URL ?>" class="btn btn-danger border-none"> Cancel </a>
						<button type="submit" class="btn btn-success border-none"> Save Changes </button>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function get_states(state_id) {
			var countryId = $('#country').val();

			$.ajax({
				type:"GET",
				url:"<?= BASE_URL ?>index/fetch_state",
				data:{'country_id': countryId,'state_id':state_id},
				success:function(res){
					$("#state").html(res);
				}
			});
		}

		$(document).ready(function() {
			<?php if (!empty($user->country)) { ?>
				get_states(<?= $user->state ?>);
			<?php } ?>
		});
		$(function () {
			var $demoMaskedInput = $('.demo-masked-input');

			$demoMaskedInput.find('.date').inputmask('yyyy-mm-dd', { placeholder: '____-__-__' });
		});
	</script>