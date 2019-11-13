<div class="block-header">
	<h2>ADVERTISEMENT LIST</h2>
</div>
<div class="row clearfix">
	<div class="col-sm-10 col-sm-offset-1 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>ALL ADVERTISEMENTS</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="example">
						<thead>
							<tr>
								<th>Sr. </th>
								<th>Title</th>
								<th>User Name</th>
								<th>Timing</th>
								<th>Price</th>
								<th>Payment Status</th>
								<th>Status</th>
								<th>Views</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach($advertisements as $advertisement) {
								$user = db_get_row_data('users',array('id'=>$advertisement->user_id));
							?>
								<tr>
									<td><?= $i++; ?></td>
									<td>
										<a href="<?= BASE_URL ?>admin/advertisements/review/<?= $advertisement->id?>">
											<?= $advertisement->title ?>
										</a>
									</td>
									<td title="<?= $user->full_name ?>"><?= $user->full_name ?></td>									
									<td>
									<?php
										$timing ='';
										if($advertisement->timing==1){$timing='Starting';}
										elseif($advertisement->timing==2){$timing='In middle';}
										else{$timing='At the end';}
										echo $timing;
									 ?></td>
									 <td><?= $advertisement->price ?></td>
									 <td><?= $advertisement->payment_status? 'Paid':'Pending' ?></td>
										<td>
										<?php
											$status='Accepted';
											if($advertisement->admin_approve==0){$status='Declined';}
											echo $status;
										?>
										</td>
										<td>
											<i class="fas fa-eye"></i> <?= db_get_count_data('advt_impressions',array('advt_id'=>$advertisement->id)) ?>
										</td>
									<td>
										<?php
										if($advertisement->admin_approve==0){
										?>
										<a href="javascript:change_status(<?= $advertisement->id ?>,<?= $advertisement->admin_approve ?>);" class="btn btn-xs btn-success waves-effect" data-toggle="tooltip" data-placement="bottom" title="Accept">
											<i class="fas fa-check"></i>
										</a>
										<?php
										}else{
										?>
										<a href="javascript:change_status(<?= $advertisement->id ?>,<?= $advertisement->admin_approve ?>);" class="btn btn-xs btn-danger waves-effect" data-toggle="tooltip" data-placement="bottom" title="Decline">
											<i class="fas fa-ban"></i>
										</a>
									<?php } ?>
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
<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			responsive: true
		});
	});

	function change_status(advtID,admin_approve){
		$.ajax({
			url: '<?= BASE_URL ?>admin/advertisements/admin_approve_disapprove',
			type: 'POST',
			data: {"advt_id":advtID,"admin_approve":admin_approve},
			dataType : "json",
		})
		.done(function(res) {
			if(res.success){
				setTimeout(function() {
				    location.reload();
				}, 1000);
			}
			$('.message').html(res.message);
			$('.message').fadeIn();
		})
		.fail(function() {
			$('.message').html('<div class="alert alert-danger">Error..!</div>');
			$('.message').fadeIn();
		})
	}
</script>