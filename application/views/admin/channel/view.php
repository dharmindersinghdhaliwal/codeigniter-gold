<div class="card">
	<div class="header bg-orange">
		<h2><?= $channel->name ?></h2>
	</div>
	<div class="body">
		<table class="table table-bordered">
			<tr>
				<td>Channel Name</td>
				<td><?= $channel->name ?></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><?= $channel->description ?></td>
			</tr>
			<tr>
				<td>Category</td>
				<td><?= db_get_row_data('category',array('id'=>$channel->category_id))->name; ?></td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><?= date('jS F, Y h:i A',strtotime($channel->date_created)) ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?= ($channel->status == 1)? '<span class="label bg-green">Active</span>' : '<span class="label bg-red">Inactive</span>' ?></td>
			</tr>
		</table>
		<div class="row clearfix">
			<hr />
			<div class="text-right">
				<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>