<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Settings
				</h2>
			</div>
			<div class="body">
				<!-- Custom Tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#tab_general" class="tab_group" data-toggle="tab"><i class="material-icons">web</i> Site General</a></li>
					<li><a href="#tab_email_template" class="tab_group" data-toggle="tab"><i class="material-icons">email</i> Email Template</a></li>
					<li><a href="#tab_api" class="tab_group" data-toggle="tab"><i class="material-icons">vpn_key</i> API Settings</a></li>
					<li><a href="#tab_ads" class="tab_group" data-toggle="tab"><i class="material-icons">grade</i> Web Ads Settins</a></li>
					<li><a href="#tab_smtp" class="tab_group" data-toggle="tab"><i class="material-icons">contact_mail</i> SMTP Settings</a></li>
				</ul>
				<?= form_open('', [
					'name'    => 'form_setting', 
					'id'      => 'form_setting', 
					'method'  => 'POST'
				]);
				?>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="tab_general">
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="site_name" name="site_name" class="form-control" value="<?= get_option('site_name'); ?>" />
										<label class="form-label">Site Name</label>
									</div>
								</div>
								<div class="form-group form-float">
									<div class="form-line">
										<textarea id="site_description" name="site_description" class="form-control"><?= get_option('site_description'); ?></textarea>
										<label class="form-label">Site Description</label>
									</div>
									<small class="info help-block">The site meta description.</small>
								</div>
								<div class="form-group form-float">
									<div class="form-line">
										<textarea id="keywords" name="keywords" class="form-control"><?= get_option('keywords'); ?></textarea>
										<label class="form-label">Keywords</label>
									</div>
									<small class="info help-block">The site meta keywords.</small>
								</div>
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="author" name="author" class="form-control" value="<?= get_option('author'); ?>" />
										<label class="form-label">Author</label>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Site Logo</label>
									<input type="file" id="site_logo" name="site_logo" />
									<?php if(get_option('site_logo') != ''){ ?>
										<div class="image-view" style="position: absolute; margin-top: -32px; margin-left: 240px;">
											<img src="<?= BASE_ASSET . get_option('site_logo') ?>" style="width: 60%;" />
											<a href="<?= BASE_URL ?>admin/setting/remove_logo" onclick="return confirm('Are you sure to remove the logo ?');" class="remove"><i class="material-icons">delete</i></a>
										</div>
									<?php } ?>
									<small class="text-indigo">File Format : JPG | JPEG | PNG | GIF | BMP</small>
									<div class="progress" style="display: none;">
										<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
											0%
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="email" name="email" class="form-control" value="<?= get_option('email'); ?>" />
										<label class="form-label">Email</label>
									</div>
									<small class="info help-block">The email of user author.</small>
								</div>
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="cc_email" name="cc_email" class="form-control" value="<?= get_option('cc_email'); ?>" />
										<label class="form-label">CC Email</label>
									</div>
									<small class="info help-block">The CC email of user author.</small>
								</div>
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="bcc_email" name="bcc_email" class="form-control" value="<?= get_option('bcc_email'); ?>" />
										<label class="form-label">BCC Email</label>
									</div>
									<small class="info help-block">The BCC email of user author.</small>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="tab_email_template">
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label>User New Registered</label>
									<textarea class="form-control texteditor" name="email_template_user_register" id="email_template_user_register" rows="5"><?= get_option('email_template_user_register'); ?></textarea>
									<small class="info help-block">User New Registered Email HTML Template</small>
									<hr />
								</div>
								<div class="form-group">
									<label>User Forgot Password</label>
									<textarea class="form-control texteditor" name="email_template_user_forgot_password" id="email_template_user_forgot_password" rows="5"><?= get_option('email_template_user_forgot_password'); ?></textarea>
									<small class="info help-block">User Forgot Password Email HTML Template</small>
									<hr />
								</div>
								<div class="form-group">
									<label>User Welcome Message</label>
									<textarea class="form-control texteditor" name="email_template_user_welcome" id="email_template_user_welcome" rows="5"><?= get_option('email_template_user_welcome'); ?></textarea>
									<small class="info help-block">User Welcome Message Email HTML Template</small>
									<hr />
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="tab_api">
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="google_api_key" name="google_api_key" class="form-control" value="<?= get_option('google_api_key'); ?>" />
										<label class="form-label">Google Plus API Key</label>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="google_client_id" name="google_client_id" class="form-control" value="<?= get_option('google_client_id'); ?>" />
										<label class="form-label">Google Plus Client ID</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="facebook_app_id" name="facebook_app_id" class="form-control" value="<?= get_option('facebook_app_id'); ?>" />
										<label class="form-label">Facebook APP ID</label>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="facebook_app_secret" name="facebook_app_secret" class="form-control" value="<?= get_option('facebook_app_secret'); ?>" />
										<label class="form-label">Facebook APP Secret</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<h4>Paypal Gateway</h4>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="paypal_business" name="paypal_business" class="form-control" value="<?= get_option('paypal_business'); ?>" />
										<label class="form-label">Paypal Email</label>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control show-tick" name="paypal_sandbox" id="paypal_sandbox">
										<option value="TRUE" <?= (get_option('paypal_sandbox') == 'TRUE')? 'selected' : ''; ?>>sandbox</option>
										<option value="FALSE" <?= (get_option('paypal_sandbox') == 'FALSE')? 'selected' : ''; ?>>live</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control show-tick" name="paypal_lib_currency_code" id="paypal_lib_currency_code">
										<option value="AUD" <?= (get_option('paypal_lib_currency_code') == 'AUD')? 'selected' : ''; ?>>Australian dollar (AUD)</option>
										<option value="BRL" <?= (get_option('paypal_lib_currency_code') == 'BRL')? 'selected' : ''; ?>>Brazilian real (BRL)</option>
										<option value="CAD" <?= (get_option('paypal_lib_currency_code') == 'CAD')? 'selected' : ''; ?>>Canadian dollar (CAD)</option>
										<option value="CZK" <?= (get_option('paypal_lib_currency_code') == 'CZK')? 'selected' : ''; ?>>Czech koruna (CZK)</option>
										<option value="DKK" <?= (get_option('paypal_lib_currency_code') == 'DKK')? 'selected' : ''; ?>>Danish krone (DKK)</option>
										<option value="EUR" <?= (get_option('paypal_lib_currency_code') == 'EUR')? 'selected' : ''; ?>>Euro (EUR)</option>
										<option value="HKD" <?= (get_option('paypal_lib_currency_code') == 'HKD')? 'selected' : ''; ?>>Hong Kong dollar (HKD)</option>
										<option value="HUF" <?= (get_option('paypal_lib_currency_code') == 'HUF')? 'selected' : ''; ?>>Hungarian forint (HUF)</option>
										<option value="INR" <?= (get_option('paypal_lib_currency_code') == 'INR')? 'selected' : ''; ?>>Indian rupee (INR)</option>
										<option value="ILS" <?= (get_option('paypal_lib_currency_code') == 'ILS')? 'selected' : ''; ?>>Israeli new shekel (ILS)</option>
										<option value="JPY" <?= (get_option('paypal_lib_currency_code') == 'JPY')? 'selected' : ''; ?>>Japanese yen (JPY)</option>
										<option value="MYR" <?= (get_option('paypal_lib_currency_code') == 'MYR')? 'selected' : ''; ?>>Malaysian ringgit (MYR)</option>
										<option value="MXN" <?= (get_option('paypal_lib_currency_code') == 'MXN')? 'selected' : ''; ?>>Mexican peso (MXN)</option>
										<option value="TWD" <?= (get_option('paypal_lib_currency_code') == 'TWD')? 'selected' : ''; ?>>New Taiwan dollar (TWD)</option>
										<option value="NZD" <?= (get_option('paypal_lib_currency_code') == 'NZD')? 'selected' : ''; ?>>New Zealand dollar (NZD)</option>
										<option value="NOK" <?= (get_option('paypal_lib_currency_code') == 'NOK')? 'selected' : ''; ?>>Norwegian krone (NOK)</option>
										<option value="PHP" <?= (get_option('paypal_lib_currency_code') == 'PHP')? 'selected' : ''; ?>>Philippine peso (PHP)</option>
										<option value="PLN" <?= (get_option('paypal_lib_currency_code') == 'PLN')? 'selected' : ''; ?>>Polish złoty (PLN)</option>
										<option value="GBP" <?= (get_option('paypal_lib_currency_code') == 'GBP')? 'selected' : ''; ?>>Pound sterling (GBP)</option>
										<option value="RUB" <?= (get_option('paypal_lib_currency_code') == 'RUB')? 'selected' : ''; ?>>Russian ruble (RUB)</option>
										<option value="SGD" <?= (get_option('paypal_lib_currency_code') == 'SGD')? 'selected' : ''; ?>>Singapore dollar (SGD)</option>
										<option value="SEK" <?= (get_option('paypal_lib_currency_code') == 'SEK')? 'selected' : ''; ?>>Swedish krona (SEK)</option>
										<option value="CHF" <?= (get_option('paypal_lib_currency_code') == 'CHF')? 'selected' : ''; ?>>Swiss franc (CHF)</option>
										<option value="THB" <?= (get_option('paypal_lib_currency_code') == 'THB')? 'selected' : ''; ?>>Thai baht (THB)</option>
										<option value="USD" <?= (get_option('paypal_lib_currency_code') == 'USD')? 'selected' : ''; ?>>United States dollar (USD)</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="tab_ads">
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label>Ads Display in Header</label>
									<div class="form-line">
										<textarea rows="5" id="ads_header" name="ads_header" class="form-control"><?= get_option('ads_header'); ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label>Ads Display in Sidebar</label>
									<div class="form-line">
										<textarea rows="5" id="ads_sidebar" name="ads_sidebar" class="form-control"><?= get_option('ads_sidebar'); ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label>Ads Display in Footer</label>
									<div class="form-line">
										<textarea rows="5" id="ads_footer" name="ads_footer" class="form-control"><?= get_option('ads_footer'); ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="tab_smtp">
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="smtp_host" name="smtp_host" class="form-control" value="<?= get_option('smtp_host'); ?>" />
										<label class="form-label">SMTP Host</label>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="smtp_port" name="smtp_port" class="form-control" value="<?= get_option('smtp_port'); ?>" />
										<label class="form-label">SMTP Port</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="text" id="smtp_username" name="smtp_username" class="form-control" value="<?= get_option('smtp_username'); ?>" />
										<label class="form-label">SMTP Username</label>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group form-float">
									<div class="form-line">
										<input type="password" id="smtp_password" name="smtp_password" class="form-control" value="<?= get_option('smtp_password'); ?>" />
										<label class="form-label">SMTP Password</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="btn bg-orange" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save" ></i> Save</button>
				</div>
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

		$('form#form_setting').submit(function(){
			var email_template_user_register = tinymce.get("email_template_user_register").getContent();
			var email_template_user_forgot_password = tinymce.get("email_template_user_forgot_password").getContent();
			var email_template_user_welcome = tinymce.get("email_template_user_welcome").getContent();

			$("#email_template_user_register").val(email_template_user_register);
			$("#email_template_user_forgot_password").val(email_template_user_forgot_password);
			$("#email_template_user_welcome").val(email_template_user_welcome);

			var form_setting = $('#form_setting');
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
				url: '<?= BASE_URL ?>admin/setting/save',
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