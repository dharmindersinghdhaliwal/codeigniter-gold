<div class="card">
	<div class="header bg-orange">
		<h2><?= $category->name ?></h2>
	</div>
	<div class="body">
		<table class="table table-bordered">
			<tr>
				<td>Category Icon</td>
				<td><i class="fa <?= $category->icon ?>"></i></td>
			</tr>
			<tr>
				<td>Category Name</td>
				<td><?= $category->name ?></td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><?= date('jS F, Y h:i A',strtotime($category->date_created)) ?></td>
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