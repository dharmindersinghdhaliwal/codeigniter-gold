<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Submmit your promotion ad</h6>
				</div>
				<hr />
			</div>
		</div>
		<?= form_open(BASE_URL . 'advertisement/buy', ['name'=> 'form_ad','id'=> 'form_ad','method'	=> 'POST','enctype'	=> 'multipart/form-data']);	?>
		<div class="row">
			<div class="col-lg-8">
				<div class="form-group">
					<label for="advertise">Your Advertise</label>
					<textarea rows="5" id="advertise" name="advertise" class="form-control texteditor"><?= $user->advertise ?></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<button type="submit" class="btn btn-outline-warning"> Buy </button>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
	<script src="<?= BASE_ASSET ?>admin/plugins/tinymce/tinymce.min.js"></script>
	<script>
		$(document).ready(function() {
			tinymce.init({
				relative_urls : false,
				remove_script_host : false,
				convert_urls : true,
				branding: false,
				paste_data_images: true,
				selector: "textarea.texteditor",
				theme: "modern",
				height: 300,
				menubar: false,
				plugins: [
				'advlist autolink lists link image charmap print preview anchor textcolor',
				'searchreplace visualblocks code fullscreen',
				'emoticons insertdatetime media table contextmenu paste code wordcount'
				],
				toolbar: 'insert | formatselect fontsizeselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat emoticons',
				fontsize_formats: "4pt 6pt 8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 28pt 32pt 36pt 40pt",
				image_advtab: true,
				image_title: true, 
				automatic_uploads: true,
				media_live_embeds: true,
				file_picker_types: 'image',
				file_picker_callback: function(cb, value, meta) {
					var input = document.createElement('input');
					input.setAttribute('type', 'file');
					input.setAttribute('accept', 'image/*');
					input.onchange = function() {
						var file = this.files[0];

						var reader = new FileReader();
						reader.onload = function () {
							var id = 'blobid' + (new Date()).getTime();
							var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
							var base64 = reader.result.split(',')[1];
							var blobInfo = blobCache.create(id, file, base64);
							blobCache.add(blobInfo);
							cb(blobInfo.blobUri(), { title: file.name });
						};
						reader.readAsDataURL(file);
					};

					input.click();
				}
			});
			tinymce.suffix 	= ".min";
			tinyMCE.baseURL = '<?= BASE_ASSET ?>admin/plugins/tinymce';

			$('form#form_ad').submit(function(){
				var advertise = tinymce.get("advertise").getContent();
				$("#advertise").val(advertise);
				$(this).submit();
				return false;
			});
		});
	</script>