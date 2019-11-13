			<div class="container-fluid pb-0">
				<div class="top-category section-padding mb-4">
					<div class="row">
						<div class="col-md-12">
							<?= get_option('ads_footer') ?>
						</div>
					</div>
				</div>
			</div>
			<!-- Sticky Footer -->
			<footer class="sticky-footer ml-0" >
				<div class="container">
					<div class="row no-gutters">
						<div class="col-lg-12 col-sm-12">
							<p class="mt-1 mb-0">
								&copy; Copyright <?= date('Y') ?> <strong class="text-dark">GoldTubeTV</strong>. All Rights Reserved
								<a href="<?= BASE_URL ?>page/terms_and_conditions" class="pull-right">Terms And Conditions</a>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<!-- /.content-wrapper -->
	</div>
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>
	<!-- Custom scripts for all pages-->
	<script src="<?= BASE_ASSET ?>js/custom.js"></script>
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip(); 
			$('#notifications').tooltip(); 
			$('#messages').tooltip(); 
			
			var sidebarwidth =	jQuery( '.sidebar' ).width();
			var footerwidth = jQuery( '.sticky-footer' ).width();
			var finalWidth = parseInt(footerwidth)-parseInt( sidebarwidth );

			// $('.container-fluid').eq( 1 ).css('min-height',sidebarHeight+'px');
			
			//	jQuery( '.sticky-footer' ).css('width',finalWidth+'px');
			
		});

		$('.sub-take').click(function() {
			var subscribe_button = this.id;
			var sub_val = $(this).attr("data-sub");

			$.ajax({
				url: '<?= BASE_URL ?>subscribe/sub/'+sub_val,
				type: 'GET'
			})
			.done(function(res) {
				if (res.success) {
					if(res.type == 'subscribed'){
						$("#"+subscribe_button).removeClass("btn-outline-danger").addClass("btn-outline-secondary");
						$("#sub-text"+sub_val).text("Subscribed");
					} else {
						$("#"+subscribe_button).removeClass("btn-outline-secondary").addClass("btn-outline-danger");
						$("#sub-text"+sub_val).text("Subscribe");
					}
					$('#channel_subs_count'+sub_val).text(res.channel_subs_count);
					$('.message').html(res.message);
					$('.message').fadeIn();
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Unable to access</div>');
				$('.message').fadeIn();
			})
			.always(function() {
			});
		});

		$('.user-follow').click(function() {
			var follow_button = this.id;
			var follow_val = $(this).attr("data-follow");

			$.ajax({
				url: '<?= BASE_URL ?>follower/follow/'+follow_val,
				type: 'GET'
			})
			.done(function(res) {
				if (res.success) {
					if(res.type == 'followed'){
						$("#"+follow_button).removeClass("btn-outline-danger").addClass("btn-outline-secondary");
						$("#follow-text"+follow_val).text("Followed");
					} else {
						$("#"+follow_button).removeClass("btn-outline-secondary").addClass("btn-outline-danger");
						$("#follow-text"+follow_val).text("Follow");
					}
					$('#user_follow_count'+follow_val).text(res.user_follow_count);
					$('.message').html(res.message);
					$('.message').fadeIn();
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Unable to access</div>');
				$('.message').fadeIn();
			})
			.always(function() {
			});
		});
	</script>
</body>
</html>