<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" />
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<h6>All Notifications</h6>
					</div>
				</div>
			</div>
		</div>
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-xl-12 col-sm-12 mb-12">
					<div class="osahan-form">
						<div class="row">
							<div class="col-sm-12">
								<table id="example" class="table table-striped table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Notification</th>
											<th>At</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($notifications as $notification) { ?>											
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $notification->message; ?></td>
												<td><?= date('jS M Y, h:i a',strtotime($notification->datetime)); ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#example').DataTable({
				responsive: true
			});
		});
	</script>