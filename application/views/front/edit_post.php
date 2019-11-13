<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Update Your Post</h6>
				</div>
			</div>
		</div>
		<?= form_open('', [
			'name'			=> 'form_update_post',
			'id'			=> 'form_update_post',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Write what in your mind</label>
					<textarea id="content" name="content" rows="5" placeholder="Write what in your mind.." class="form-control texteditor"><?= $post->content ?></textarea>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Post For</label>
							<select class="form-control" name="privacy" id="privacy">
								<option value="public" <?= ($post->privacy == 'public')? 'selected' : ''; ?>>Public</option>
								<option value="group" <?= ($post->privacy == 'group')? 'selected' : ''; ?>>For Group</option>
							</select>
						</div>
						<div class="col-sm-6" id="userGroups" <?= ($post->privacy == 'group')? '' : 'style="display: none;"'; ?>>
							<?php if(count($user_groups) == 0){ ?>
								<input type="hidden" name="group_id" id="group_id" value="0" />
								<h5 style="margin-top: 20px;">Sorry you did't created any group <a href="<?= BASE_URL ?>user/group_add" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" data-original-title="Create Group"><i class="fa fa-plus"></i></a></h5>
							<?php } else { ?>
								<label class="control-label">Group</label>
								<select class="form-control" name="group_id" id="group_id">
									<?php foreach ($user_groups as $user_group) { ?>
										<option value="<?= $user_group->id ?>" <?= ($post->group_id == $user_group->id)? 'selected' : ''; ?>><?= $user_group->name ?></option>
									<?php } ?>
								</select>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<div class="progress" style="display: none;">
						<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<a href="<?= BASE_URL ?>channels/view/<?= $channel_id ?>" class="btn btn-danger border-none"> Cancel </a>
					<button type="submit" class="btn btn-success border-none"> Submit </button>
				</div>
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
			tinymce.suffix = ".min";
			tinyMCE.baseURL = '<?= BASE_ASSET ?>admin/plugins/tinymce';

			$('form#form_update_post').submit(function(){
				var content = tinymce.get("content").getContent();

				$("#content").val(content);
				var form_update_post = $('#form_update_post');
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
					url: '<?= BASE_URL ?>post/update/<?= $post->id ?>',
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
				})
				.done(function(res) {
					if (res.success) {
						window.location.replace("<?= BASE_URL ?>channels/view/<?= $channel_id ?>");
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

		$(document).on('change','#privacy', function () {
			var privacy = $(this).val();

			if(privacy == 'group'){
				$('#userGroups').fadeIn();
			} else {
				$('#userGroups').fadeOut();
			}
		});
	</script>