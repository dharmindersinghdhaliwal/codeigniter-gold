<div class="block-header">
	<h2>ADD NEW CHANNEL</h2>
</div>

<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<?= form_open('', [
			'name'			=> 'form_add_channel',
			'id'			=> 'form_add_channel',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data',
			'class'			=> 'form-horizontal'
		]);
		?>
		<div class="card">
			<div class="header bg-orange">
				<h2>
					ADD CHANNEL
					<small>Fill all record for new channel.</small>
				</h2>
			</div>
			<div class="body">
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="logo">Channel Logo</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<input type="file" id="logo" name="logo" accept="image/*" />
							<small class="text-danger">max-width : 500px | max-height : 500px</small>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="logo">Channel Banner Image</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<input type="file" id="banner" name="banner" accept="image/*" />
							<small class="text-danger">max-width : 1040px | max-height : 300px</small>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-3 col-xs-4 form-control-label">
						<label for="name">Channel Name</label>
					</div>
					<div class="col-sm-9 col-xs-8">
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="name" name="name" class="form-control" placeholder="Channel Name" required="required" value="<?= $name ?>" />
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
								<textarea id="description" name="description" class="form-control" rows="5" placeholder="Description.."><?= $description ?></textarea>
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
									<option value="<?= $category->id ?>" <?= ($category_id == $category->id)? 'selected' : ''; ?>><?= $category->name ?></option>
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
				<hr />
				<button type="submit" class="btn bg-orange waves-effect" id="save_data">Add</button>
				<a href="<?= BASE_URL ?>admin/channel" class="btn btn-default waves-effect">Back</a>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
</div>