<link rel="Stylesheet" type="text/css" href="<?= BASE_ASSET ?>croppie/croppie.css" />
<script src="<?= BASE_ASSET ?>croppie/croppie.js"></script>
<style type="text/css">
#my-image, #use {
	display: none;
}
</style>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>New Channel</h6>
				</div>
			</div>
		</div>
		<?= form_open('', [
			'name'			=> 'form_create_channel',
			'id'			=> 'form_create_channel',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div id="BannerImageModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Upload Your Channel Banner</h4>
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
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Logo Image</label><br />
					<input type="file" id="logo" name="logo" accept="image/*" /><br />
					<small class="text-danger">max-width : 300px | max-height : 300px</small>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#BannerImageModal">Banner Image</button>
					<input type="hidden" id="banner" name="banner" value="" />
					<div class="image-view" id="imageViewBanner"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Category <span class="text-danger">*</span></label>
					<select name="category_id" id="category_id" class="custom-select" required="required">
						<option value="">Select Category</option>
						<?php foreach (db_get_all_data('category') as $category) { ?>
							<option value="<?= $category->id ?>"><?= $category->name ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label">Name <span class="text-danger">*</span></label>
					<input class="form-control border-form-control" type="text" id="name" name="name" required="required" placeholder="Channel Name" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Description</label>
					<textarea id="description" name="description" rows="5" placeholder="Description.." class="form-control border-form-control"></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Website URL</label>
					<input class="form-control border-form-control" type="text" id="website" name="website" placeholder="www.yoursite.com" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-facebook-square"></i> Facebook Link</label>
					<input class="form-control border-form-control" type="text" id="facebook_url" name="facebook_url" placeholder="Facebook Link" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-instagram"></i> Instagram Link</label>
					<input class="form-control border-form-control" type="text" id="instagram_url" name="instagram_url" placeholder="Instagram Link" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-twitter-square"></i> Twitter Link</label>
					<input class="form-control border-form-control" type="text" id="twitter_url" name="twitter_url" placeholder="Twitter Link" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-google-plus-square"></i> Google plus Link</label>
					<input class="form-control border-form-control" type="text" id="google_url" name="google_url" placeholder="Google plus Link" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-linkedin-square"></i> Linkedin Link</label>
					<input class="form-control border-form-control" type="text" id="linkedin_url" name="linkedin_url" placeholder="Linkedin Link" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-pinterest-square"></i> Pinterest Link</label>
					<input class="form-control border-form-control" type="text" id="pinterest_url" name="pinterest_url" placeholder="Pinterest Link" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="control-label"><i class="fa fa-envelope"></i> Email</label>
					<input class="form-control border-form-control" type="text" id="email" name="email" placeholder="Email" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="is_default" class="control-label"><input type="checkbox" id="is_default" name="is_default" checked="checked" /> Set As your main channel</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<a href="<?= BASE_URL ?>channels" class="btn btn-danger border-none"> Cancel </a>
				<button type="submit" class="btn btn-success border-none"> Create </button>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imgInp').fadeOut();
					$('#my-image').attr('src', e.target.result);
					var resize = new Croppie($('#my-image')[0], {
						viewport: { width: 740, height: 400 },
						boundary: { width: '100%', height: 480 },
						showZoomer: false,
						enableResize: false,
						enableOrientation: true
					});
					$('#use').fadeIn();
					$('#use').on('click', function() {
						resize.result('base64').then(function(dataImg) {
							var data = [{ image: dataImg }, { name: 'myimgage.jpg' }];
							$('#imageViewBanner').html('<img src="'+dataImg+'" />');
							$('#banner').val(dataImg);
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