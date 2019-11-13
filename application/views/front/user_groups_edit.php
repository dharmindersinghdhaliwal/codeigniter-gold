<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<?= form_open('', [
			'name'			=> 'form_user_group',
			'id'			=> 'form_user_group',
			'method'		=> 'POST',
			'enctype'		=> 'multipart/form-data'
		]);
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-title">
							<h6>Update New Group</h6>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label class="control-label">Group Name <span class="required">*</span></label>
							<input class="form-control border-form-control" id="name" name="name" placeholder="Group Name" type="text" value="<?= $user_group->name ?>" />
						</div>
						<div class="form-group">
							<label class="control-label">Type <span class="required">*</span></label>
							<select class="form-control" name="type" id="type">
								<option value="fun" <?= ($user_group->type == 'fun')? 'selected' : ''; ?>>fun</option>
								<option value="work" <?= ($user_group->type == 'work')? 'selected' : ''; ?>>work</option>
								<option value="friends" <?= ($user_group->type == 'friends')? 'selected' : ''; ?>>friends</option>
								<option value="dating" <?= ($user_group->type == 'dating')? 'selected' : ''; ?>>dating</option>
								<option value="private" <?= ($user_group->type == 'private')? 'selected' : ''; ?>>private</option>
								<option value="others" <?= ($user_group->type == 'others')? 'selected' : ''; ?>>others</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Members : </label> 
							<input type="checkbox" id="members" class="filled-in chk-col-blue" />
							<label for="members">All Members</label>
							<hr />
							<div class="row">
								<?php foreach ($user_follows as $user_follow) { ?>
									<?php $user = db_get_row_data('users',array('id'=>$user_follow->user_id)); ?>
									<?php $user_group_detail = db_get_count_data('user_group_detail',array('group_id'=>$user_group->id,'user_id' => $user->id)) ?>
									<div class="col-sm-3">
										<label><input type="checkbox" name="user_ids[]" id="user_id<?= $user->id ?>" <?= ($user_group_detail == 1)? 'checked' : ''; ?> class="member" value="<?= $user->id ?>" /> <?= $user->full_name ?></label>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?= BASE_URL ?>user/group" class="btn btn-danger border-none"> Cancel </a>
						<button type="submit" class="btn btn-success border-none"> Update Group </button>
					</div>
				</div>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
	<script>
		$(document).on('change','#members',function(){
			var members = $(this);

			if(members.is(':checked')){
				$('.member').prop('checked',true);
			} else {
				$('.member').prop('checked',false);
			}
		});
	</script>