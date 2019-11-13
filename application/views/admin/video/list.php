<div class="block-header">
	<h2>VIDEO LIST</h2>
</div>
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					ALL VIDEOS
					<a href="<?= BASE_URL ?>admin/video/add" class="btn btn-xs btn-default waves-effect pull-right" data-toggle="tooltip" data-placement="bottom" title="Add New Video">Add New Video</a>
				</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<th>Sr. No. </th>
								<th>Title</th>
								<th>Category</th>
								<th>Channel</th>
								<th>Uploaded On</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($videos as $video) { ?>
								<tr>
									<td><?= $i++; ?></td>
									<td><?= $video->title ?></td>
									<td><?= ($video->category_id != 0)? db_get_row_data('category',array('id'=>$video->category_id))->name : ''; ?></td>
									<td><?= ($video->channel_id != 0)? db_get_row_data('channel',array('id'=>$video->channel_id))->name : ''; ?></td>
									<td><?= date('jS F, Y h:i A',strtotime($video->date_created)) ?></td>
									<td class="text-right">
										<a href="<?= BASE_URL ?>admin/video/delete/<?= $video->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $video->title . ' Delete'; ?>" onclick="return confirm('Are you sure to remove the video ?');"><i class="material-icons">delete</i></a>
										<a href="javascript:get_video_view(<?= $video->id ?>);" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $video->title . ' view'; ?>"><i class="material-icons">visibility</i></a>
										<a href="<?= BASE_URL ?>admin/video/edit/<?= $video->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $video->title . ' edit'; ?>"><i class="material-icons">mode_edit</i></a>
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
<div class="modal fade" id="video_view" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div id="result"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function get_video_view(video_id) {
		$.get("<?= BASE_URL ?>admin/video/view/"+video_id, function(res) {
			$("#result").html(res);
			$('#video_view').modal('show');
		});
	}
</script>