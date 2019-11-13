<div class="card">
	<div class="header bg-orange">
		<h2><?= $video->title ?></h2>
	</div>
	<div class="body">
		<table class="table table-bordered">
			<tr>
				<td>Title</td>
				<td><?= $video->title ?></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><?= $video->description ?></td>
			</tr>
			<tr>
				<td>Category</td>
				<td><?= ($video->category_id != 0)? db_get_row_data('category',array('id'=>$video->category_id))->name : ''; ?></td>
			</tr>
			<tr>
				<td>Channel</td>
				<td><?= ($video->channel_id != 0)? db_get_row_data('channel',array('id'=>$video->channel_id))->name : ''; ?></td>
			</tr>
			<tr>
				<td>Uploaded On</td>
				<td><?= date('jS F, Y h:i A',strtotime($video->date_created)) ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?= ($video->status == 1)? '<span class="label bg-green">Active</span>' : '<span class="label bg-red">Inactive</span>' ?></td>
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