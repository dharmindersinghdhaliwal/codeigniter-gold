<link rel="stylesheet" href="<?= BASE_ASSET ?>icon-picker/icon-fonts/elusive-icons-2.0.0/css/elusive-icons.min.css"/>
<link rel="stylesheet" href="<?= BASE_ASSET ?>icon-picker/icon-fonts/map-icons-2.1.0/css/map-icons.min.css"/>
<link rel="stylesheet" href="<?= BASE_ASSET ?>icon-picker/dist/css/bootstrap-iconpicker.css"/>
<div class="block-header">
	<h2>UPDATE CATEGORY</h2>
</div>

<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<?= form_open('', [
			'name'			=> 'form_edit_category',
			'id'			=> 'form_edit_category',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data',
			'class'			=> 'form-horizontal'
		]);
		?>
		<div class="card">
			<div class="header bg-orange">
				<h2>
					UPDATE CATEGORY
					<small>Fill all record for update category.</small>
				</h2>
			</div>
			<div class="body">
				<div class="row clearfix">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="form-group">
							<button type="button" class="btn btn-default" data-iconset="fontawesome" data-icon="<?= $category->icon ?>" role="iconpicker" data-toggle="tooltip" title="Category Icon"></button>
							<input type="hidden" name="icon" id="icon" value="<?= $category->icon ?>" />
						</div>
						<hr />
						<div class="form-group">
							<label for="email">Category Name</label>
							<div class="form-line">
								<input type="test" id="name" name="name" class="form-control" placeholder="Category Name" required="required" value="<?= $category->name ?>" />
							</div>
						</div>
					</div>
				</div>
				<hr />
				<button type="submit" class="btn bg-orange waves-effect" id="save_data">Update</button>
				<a href="<?= BASE_URL ?>admin/category" class="btn btn-default waves-effect">Back</a>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
</div>
<script type="text/javascript" src="<?= BASE_ASSET ?>icon-picker/dist/js/bootstrap-iconpicker-iconset-all.js"></script>
<script type="text/javascript" src="<?= BASE_ASSET ?>icon-picker/dist/js/bootstrap-iconpicker.js"></script>