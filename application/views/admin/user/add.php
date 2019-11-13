<div class="block-header">
	<h2>ADD NEW USER</h2>
</div>

<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<?= form_open('', [
			'name'			=> 'form_add_user',
			'id'			=> 'form_add_user',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data',
			'class'			=> 'form-horizontal'
		]);
		?>
		<div class="card">
			<div class="header bg-orange">
				<h2>
					ADD USER
					<small>Fill all record for new User.</small>
				</h2>
			</div>
			<div class="body">
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="profile_image">Profile image</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<input type="file" id="profile_image" name="profile_image" />
							<small class="text-danger">max-width : 1024px | max-height : 720px</small>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="email">Email</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required" value="<?= $email ?>" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="full_name">Full Name</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full Name" required="required" value="<?= $full_name ?>" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="password">Password</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="passconf">Confirm Password</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="password" id="passconf" name="passconf" class="form-control" placeholder="Confirm Password" required="required" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="address">Address</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<textarea id="address" name="address" class="form-control" rows="5" placeholder="Address.."><?= $address ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="country">Country</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<select name="country" id="country" class="form-control show-tick" onchange="get_states();" data-live-search="true">
								<option value="">--Select Country--</option>
								<?php foreach (db_get_all_data('countries') as $cntry) { ?>
									<option value="<?= $cntry->id ?>" <?= ($country == $cntry->id)? 'selected' : ''; ?>><?= $cntry->name ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="state">State</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<select name="state" id="state" class="form-control show-tick" data-live-search="true">
								<option value="">--Select State--</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="city">City</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="city" name="city" class="form-control" placeholder="City Name" value="<?= $city ?>" />
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label>Type</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="demo-radio-button">
								<input type="radio" name="type" id="type" class="radio-col-green" checked value="user" />
								<label for="type">User</label>
								<input type="radio" name="type" id="type_1" class="radio-col-orange" value="admin" />
								<label for="type_1">Admin</label>
							</div>
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
				<hr />
				<button type="submit" class="btn bg-orange waves-effect" id="save_data">Add</button>
				<a href="<?= BASE_URL ?>admin/user" class="btn btn-default waves-effect">Back</a>
			</div>
		</div>
		<?= form_close(); ?>
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
				$("#state").selectpicker('refresh');
			}
		});
	}

	$(document).ready(function() {
		<?php if (!empty($country)) { ?>
			get_states(<?= $state ?>);
		<?php } ?>
	});
</script>