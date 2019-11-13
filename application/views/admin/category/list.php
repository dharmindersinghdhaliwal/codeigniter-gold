<div class="block-header">
	<h2>CATEGORY LIST</h2>
</div>
<div class="row clearfix">
	<div class="col-sm-10 col-sm-offset-1 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					ALL CATEGORIES
					<a href="<?= BASE_URL ?>admin/category/add" class="btn btn-xs btn-default waves-effect pull-right" data-toggle="tooltip" data-placement="bottom" title="Add New Category">Add New Category</a>
				</h2>
			</div>
			<div class="body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<th>Sr. No. </th>
								<th>Category Icon</th>
								<th>Category Name</th>
								<th>Created On</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($categories as $category) { ?>
								<tr>
									<td><?= $i++; ?></td>
									<td><i class="fa <?= $category->icon ?>"></i></td>
									<td><?= $category->name ?></td>
									<td><?= date('jS F, Y h:i A',strtotime($category->date_created)) ?></td>
									<td class="text-right">
										<a href="javascript:get_category_view(<?= $category->id ?>);" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $category->name . ' view'; ?>"><i class="material-icons">visibility</i></a>
										<a href="<?= BASE_URL ?>admin/category/edit/<?= $category->id ?>" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip" data-placement="bottom" title="<?= $category->name . ' edit'; ?>"><i class="material-icons">mode_edit</i></a>
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
<div class="modal fade" id="category_view" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div id="result"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function get_category_view(category_id) {
		$.get("<?= BASE_URL ?>admin/category/view/"+category_id, function(res) {
			$("#result").html(res);
			$('#category_view').modal('show');
		});
	}
</script>