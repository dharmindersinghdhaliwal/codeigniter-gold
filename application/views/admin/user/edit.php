<div class="block-header">
	<h2>UPDATE USER</h2>
</div>

<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<?= form_open('', [
			'name'			=> 'form_edit_user',
			'id'			=> 'form_edit_user',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data',
			'class'			=> 'form-horizontal'
		]);
		?>
		<div class="card">
			<div class="header bg-orange">
				<h2>
					UPDATE USER
					<small>Fill all record for update User.</small>
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
							<?php if($user->profile_image != ''){ ?>
							<div class="image-view">
								<img src="<?= BASE_URL ?>upload_data/user/<?= $user->profile_image ?>" />
								<a href="<?= BASE_URL ?>admin/user/remove_user_image/<?= $user->id ?>" onclick="return confirm('Are you sure to remove the image ?');" class="remove"><i class="material-icons">delete</i></a>
							</div>
							<?php } ?>
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
								<input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required" value="<?= $user->email ?>" />
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
								<input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full Name" required="required" value="<?= $user->full_name ?>" />
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
								<input type="password" id="password" name="password" class="form-control" placeholder="Password" />
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
								<input type="password" id="passconf" name="passconf" class="form-control" placeholder="Confirm Password" />
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
								<textarea id="address" name="address" class="form-control" rows="5" placeholder="Address.."><?= $user->address ?></textarea>
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
									<option value="<?= $cntry->id ?>" <?= ($user->country == $cntry->id)? 'selected' : ''; ?>><?= $cntry->name ?></option>
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
								<input type="text" id="city" name="city" class="form-control" placeholder="City Name" value="<?= $user->city ?>" />
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
								<input type="radio" name="type" id="type" class="radio-col-green" <?= ($user->type == 'user')? 'checked' : ''; ?> value="user" />
								<label for="type">User</label>
								<input type="radio" name="type" id="type_1" class="radio-col-orange" <?= ($user->type == 'admin')? 'checked' : ''; ?> value="admin" />
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
								<input type="radio" name="status" id="status" class="radio-col-green" <?= ($user->status == 1)? 'checked' : ''; ?> value="1" />
								<label for="status">Active</label>
								<input type="radio" name="status" id="status_1" class="radio-col-red" <?= ($user->status == 0)? 'checked' : ''; ?> value="0" />
								<label for="status_1">Inactive</label>
							</div>
						</div>
					</div>
				</div>
				<hr />
				<button type="submit" class="btn bg-orange waves-effect" id="save_data">Update</button>
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
		<?php if (!empty($user->country)) { ?>
			get_states(<?= $user->state ?>);
		<?php } ?>
	});
</script>