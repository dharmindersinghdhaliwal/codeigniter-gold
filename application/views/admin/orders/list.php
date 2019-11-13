<div class="block-header">
	<h2>User Payments</h2>
</div>
<div class="row clearfix">
	<div class="col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>All Orders</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="example">
						<thead>
							<tr>
								<th>Sr. No. </th>								
								<th>User Name</th>
								<th>Payer Email</th>
								<th>Payment Status</th>
								<th>TXN ID</th>
								<th>Amount</th>
								<th>Currency</th>
								<th>Date/time</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1;
							foreach($orders as $order) {
								$user = db_get_row_data('users',array('id'=>$order->user_id));
							?>
							<tr>
								<td><?= $i++; ?></td>
								<td  title="<?= $user->full_name ?>">
									<?= $user->full_name ?>
								</td>
								<td><?= $order->payer_email?></td>
								<td><?= $order->payment_status?></td>
								<td><?= $order->txn_id?></td>
								<td><?= $order->payment_gross?></td>
								<td><?= $order->currency_code?></td>
								<td><?= $order->datetime?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
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