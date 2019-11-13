<div class="block-header">
	<h2>CHANNEL LIST</h2>
</div>
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					ALL CHANNELS
					<a href="<?= BASE_URL ?>admin/channel/add" class="btn btn-xs btn-default waves-effect pull-right" data-toggle="tooltip" data-placement="bottom" title="Add New Channel">Add New Channel</a>
				</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<th>Sr. No. </th>
								<th>Logo</th>
								<th>Channel Name</th>
								<th>Category</th>
								<th>Created On</th>
								<th>Action</th>
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
												<img src="<?= BASE_ASSET . 'admin/images/channel.png'; ?>" style="border-radius: 50%; width: 40px;height: 40px;" />
											<?php } ?>
										<?php } else { ?>
											<img src="<?= BASE_ASSET . 'admin/images/channel.png'; ?>" style="border-radius: 50%; width: 40px;height: 40px;" />
										<?php } ?>
									</td>
									<td><?= $channel->name ?></td>
									<td><?= db_get_row_data('category',array('id'=>$channel->category_id))->name; ?></td>
									<td><?= date('jS F, Y h:i A',strtotime($channel->date_created)) ?></td>
									<td class="text-right">
										<a href="<?= BASE_URL ?>admin/channel/delete/<?= $channel->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $channel->name . ' Delete'; ?>" onclick="return confirm('Are you sure to remove the channel ?');"><i class="material-icons">delete</i></a>
										<a href="javascript:get_channel_view(<?= $channel->id ?>);" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $channel->name . ' view'; ?>"><i class="material-icons">visibility</i></a>
										<a href="<?= BASE_URL ?>admin/channel/edit/<?= $channel->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $channel->name . ' edit'; ?>"><i class="material-icons">mode_edit</i></a>
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
<div class="modal fade" id="channel_view" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div id="result"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function get_channel_view(channel_id) {
		$.get("<?= BASE_URL ?>admin/channel/view/"+channel_id, function(res) {
			$("#result").html(res);
			$('#channel_view').modal('show');
		});
	}
</script>