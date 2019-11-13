<div class="block-header">
	<h2>USER'S CHANNEL LIST</h2>
</div>
<div class="row clearfix">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					ALL USER'S CHANNELS
					<a href="<?= BASE_URL ?>admin/user" class="btn btn-xs btn-default waves-effect pull-right" data-toggle="tooltip" data-placement="bottom" title="Back to Users">BACK</a>
				</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<th>Sr. No. </th>
								<th>Image</th>
								<th>Channel Name</th>
								<th>Created On</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($channels as $channel) { ?>
								<tr>
									<td><?= $i++; ?></td>
									<td>
										<?php if($channel->logo != ''){ ?>
											<?php if(file_exists(FCPATH . 'upload_data/channel/' . $channel->logo)){ ?>
												<img src="<?= BASE_URL . 'upload_data/channel/' . $channel->logo; ?>" style="border-radius: 50%;width: 40px;height: 40px;" />
											<?php } else { ?>
												<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="border-radius: 50%; width: 40px;height: 40px;" />
											<?php } ?>
										<?php } else { ?>
											<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="border-radius: 50%; width: 40px;height: 40px;" />
										<?php } ?>
									</td>
									<td><?= $channel->name ?></td>
									<td><?= date('jS F, Y h:i A',strtotime($channel->date_created)) ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>