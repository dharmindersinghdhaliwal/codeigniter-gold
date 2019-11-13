<style type="text/css">
.video-card-list .user-image {
	float: left;
	height: auto;
	margin: 0 12px 0 0;
	width: 122px;
}
.user-image {
	overflow: hidden;
	position: relative;
}
</style>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-8">
					<div class="single-video-right">
						<div class="row">
							<div class="col-md-12">
								<div class="main-title">
									<h6>
										My Posts
										<?php if($this->session->userdata('loggedin')) { ?>
											<div class="float-right">
												<a href="<?= BASE_URL ?>post/create" class="right-action-link text-gray">Create your post <i class="fa fa-plus"></i></a>
											</div>
										<?php } ?>
									</h6>
								</div>
							</div>
							<?php if(count($posts) != 0) { ?>
								<?php foreach ($posts as $post) { ?>
									<div class="col-md-12">
										<div class="video-card video-card-list" style="cursor: pointer;" onclick="window.location.href='<?= BASE_URL?>post/<?= $post->id ?>';">
											<div class="user-image text-center">
												<?php $usr = db_get_row_data('users',array('id'=>$post->user_id)); ?>
												<div class="channels-card-image" data-toggle="tooltip" data-placement="bottom" title="<?= $usr->full_name ?>">
													<?php if($usr->profile_image != ''){ ?>
														<?php if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){ ?>
															<img src="<?= BASE_URL . 'upload_data/user/' . $usr->profile_image; ?>" alt="<?= $usr->full_name ?>" />
														<?php } else { ?>
															<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" />
														<?php } ?>
													<?php } else { ?>
														<img src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" />
													<?php } ?>
												</div>
											</div>
											<div class="video-card-body">
												<div class="video-page">
													<?= substr(strip_tags($post->content),0,300) . '....' ?>
												</div>
												<div class="video-view">
													<?= db_get_count_data('post_comment',array('post_id'=>$post->id)) ?> comments &nbsp;<i class="fa fa-history"></i> <?= time_elapsed_string($post->date_created) ?>
													<div class="float-right">
														<a href="<?= BASE_URL ?>post/edit/<?= $post->id ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Post"><i class="fa fa-pencil-square fa-2x"></i></a>
													</div>
												</div>
											</div>
										</div>
										<hr />
									</div>
								<?php } ?>
							<?php } else { ?>
								<div class="col-xl-3 col-sm-6 mb-3">
									<div class="channels-card">
										<div class="channels-card-image">
											<a href="<?= BASE_URL ?>post/create"><i class="fa fa-plus fa-4x"></i></a>
										</div>
										<div class="channels-card-body">
											<div class="channels-title">
												<a href="<?= BASE_URL ?>post/create">Submit Your First Post</a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>