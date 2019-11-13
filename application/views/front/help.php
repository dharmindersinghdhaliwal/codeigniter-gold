<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Do you need help ?</h6>
				</div>
				<hr />
			</div>
		</div>
		<?= form_open('', [
			'name'			=> 'form_help',
			'id'			=> 'form_help',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" placeholder="Email Adderss" id="email" name="email" class="form-control" required="required" />
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" placeholder="Name" id="name" name="name" class="form-control" required="required" />
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="message">Your Question</label>
					<textarea rows="5" id="message" name="message" class="form-control" placeholder="Post your query..."></textarea>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<span>If you have query email us <i><?= get_option('email') ?></i></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-outline-warning"> Send </button>
			</div>
		</div>
		<?= form_close(); ?>
	</div>