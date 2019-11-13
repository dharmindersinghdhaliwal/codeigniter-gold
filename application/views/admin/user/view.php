<div class="card">
	<div class="header bg-orange">
		<h2><?= $user->full_name ?></h2>
	</div>
	<div class="body">
		<table class="table table-bordered">
			<tr>
				<td>Full Name</td>
				<td><?= $user->full_name ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?= $user->email ?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><?= $user->address ?></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><?= $user->type ?></td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><?= date('jS F, Y h:i A',strtotime($user->date_created)) ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?= ($user->status == 1)? '<span class="label bg-green">Active</span>' : '<span class="label bg-red">Inactive</span>' ?></td>
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