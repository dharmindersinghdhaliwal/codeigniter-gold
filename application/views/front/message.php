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
						<h6>All Messages</h6>
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
											<th>Email</th>
											<th>Message Title</th>
											<th>Message send on</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($user_queries as $query) { ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $query->email; ?></td>
												<td><?= $query->title; ?></td>
												<td><?= date('jS M Y, h:i a',strtotime($query->date_created)); ?></td>
												<td>
													<div class="float-right">
														<a href="<?= BASE_URL ?>message/view/<?= $query->id ?>" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Message"><i class="fa fa-eye"></i></a>
													</div>
												</td>
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