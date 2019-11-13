<div class="block-header">
	<h2>USER LIST</h2>
</div>
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					ALL USERS
					<a href="<?= BASE_URL ?>admin/user/add" class="btn btn-xs btn-default waves-effect pull-right" data-toggle="tooltip" data-placement="bottom" title="Add New User">Add New User</a>
				</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<th>Sr. No. </th>
								<th>Image</th>
								<th>Name</th>
								<th>Email</th>
								<th>Type</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($users as $user) { ?>
								<tr>
									<td><?= $i++; ?></td>
									<td>
										<?php if($user->profile_image != ''){ ?>
											<?php if(file_exists(FCPATH . 'upload_data/user/' . $user->profile_image)){ ?>
												<img src="<?= BASE_URL . 'upload_data/user/' . $user->profile_image; ?>" style="border-radius: 50%;width: 40px;height: 40px;" />
											<?php } else { ?>
												<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="border-radius: 50%; width: 40px;height: 40px;" />
											<?php } ?>
										<?php } else { ?>
											<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" style="border-radius: 50%; width: 40px;height: 40px;" />
										<?php } ?>
									</td>
									<td><?= $user->full_name ?></td>
									<td><?= $user->email; ?></td>
									<td><?= $user->type ?></td>
									<td class="text-right">
										<a href="<?= BASE_URL ?>admin/user/channel/<?= $user->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $user->full_name . ' channel'; ?>"><i class="material-icons">voice_chat</i></a>
										<a href="javascript:get_user_view(<?= $user->id ?>);" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $user->full_name . ' view'; ?>"><i class="material-icons">visibility</i></a>
										<a href="<?= BASE_URL ?>admin/user/edit/<?= $user->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $user->full_name . ' edit'; ?>"><i class="material-icons">mode_edit</i></a>
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
<div class="modal fade" id="user_view" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div id="result"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function get_user_view(user_id) {
		$.get("<?= BASE_URL ?>admin/user/view/"+user_id, function(res) {
			$("#result").html(res);
			$('#user_view').modal('show');
		});
	}
</script>