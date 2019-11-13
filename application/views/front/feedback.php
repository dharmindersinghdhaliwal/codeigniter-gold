<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid upload-details">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					<h6>Give us your feedback</h6>
				</div>
				<hr />
			</div>
		</div>
		<?= form_open('', [
			'name'			=> 'form_feedback',
			'id'			=> 'form_feedback',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="feedback">Feedback</label>
					<textarea rows="10" id="feedback" name="feedback" class="form-control" placeholder="Share your expirence and ideas ...."></textarea>
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