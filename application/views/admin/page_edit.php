<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Update Page
				</h2>
			</div>
			<div class="body">
				<?= form_open('', [
					'name'    => 'form_update_page', 
					'id'      => 'form_update_page', 
					'method'  => 'POST'
				]);
				?>
				<div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Terms And Conditions Page</label>
							<textarea class="form-control texteditor" name="terms_and_conditions" id="terms_and_conditions" rows="5"><?= get_option('terms_and_conditions'); ?></textarea>
							<small class="info help-block">Terms And Conditions Page HTML Template</small>
							<hr />
						</div>
					</div>
				</div>
				<button type="submit" class="btn bg-orange" id="btn_save" data-stype='stay' title="Update (Ctrl+s)"><i class="fa fa-save" ></i> Update</button>
				<a href="<?= BASE_URL ?>admin/page" class="btn btn-default waves-effect">Back</a>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		tinymce.init({
			branding: false,
			paste_data_images: true,
			selector: "textarea.texteditor",
			theme: "modern",
			height: 400,
			plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools'
			],
			toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
			toolbar2: 'print preview media | fontsizeselect forecolor backcolor emoticons',
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
		tinymce.suffix = ".min";
		tinyMCE.baseURL = '<?= BASE_ASSET ?>admin/plugins/tinymce';

		$('form#form_update_page').submit(function(){
			var terms_and_conditions = tinymce.get("terms_and_conditions").getContent();

			$("#terms_and_conditions").val(terms_and_conditions);

			var form_update_page = $('#form_update_page');
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
				url: '<?= BASE_URL ?>admin/page/save',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
			})
			.done(function(res) {
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
</script>