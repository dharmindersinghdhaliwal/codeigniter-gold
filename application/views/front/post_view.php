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
<div id="shareUrlModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Share Post</h4>
			</div>
			<div class="modal-body">
				<div class="osahan-form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="share_url">Copy post link</label>
								<div class="input-group mb-3">
									<input type="text" id="share_url" class="form-control" aria-describedby="basic-addon3" value="<?= BASE_URL . 'post/view/' . $post->id ?>" />
									<div class="input-group-prepend" style="cursor: pointer;">
										<span class="input-group-text" id="copy_share_url">Copy</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<p>
									<a href="https://www.facebook.com/" alt="Share On Facebook" target="_blank"><i class="fa fa-facebook-square fa-4x text-info"></i></a>
									<a href="https://twitter.com/" alt="Share On Twitter" target="_blank"><i class="fa fa-twitter-square fa-4x text-info"></i></a>
									<a href="https://plus.google.com/" alt="Share On Google Plus" target="_blank"><i class="fa fa-google-plus-square fa-4x text-danger"></i></a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-8">
					<div class="single-video-left">
						<div class="single-video-info-content box mb-3">
							<?= $post->content ?>
						</div>
						<div class="single-video-title box mb-3">
							<div class="float-right">
								<?php
								if($this->session->userdata('loggedin')){
									$user_follow = db_get_row_data('user_follow',array('follow_id'=>$post->user_id,'user_id'=>$this->session->userdata('id')));
									if(count($user_follow) == 0){
										?>
										<button type="button" class="btn btn-outline-danger user-follow" id="follow_button<?= $post->user_id ?>" data-follow="<?= $post->user_id ?>">
											<span id="user_follow_count<?= $post->user_id ?>"><?= db_get_count_data('user_follow',array('follow_id'=>$post->user_id)) ?></span>
											<span id="follow-text<?= $post->user_id ?>">Follow</span>
										</button>
										<?php
									} else {
										?>
										<button type="button" class="btn btn-outline-secondary user-follow" id="follow_button<?= $post->user_id ?>" data-follow="<?= $post->user_id ?>">
											<span id="user_follow_count<?= $post->user_id ?>"><?= db_get_count_data('user_follow',array('follow_id'=>$post->user_id)) ?></span>
											<span id="follow-text<?= $post->user_id ?>">Followed</span>
										</button>
										<?php
									}
								} else {
									?>
									<button type="button" class="btn btn-outline-danger user-follow" id="follow_button<?= $post->user_id ?>" data-follow="<?= $post->user_id ?>">
										<span id="user_follow_count<?= $post->user_id ?>"><?= db_get_count_data('user_follow',array('follow_id'=>$post->user_id)) ?></span>
										<span id="follow-text<?= $post->user_id ?>">Follow</span>
									</button>
									<?php
								}
								?>
								<span data-toggle="modal" data-target="#shareUrlModal">
									<button class="btn btn-outline-danger" data-toggle="tooltip" data-placement="bottom" title="Share Post"><i class="fa fa-share-alt"></i></button>
								</span>
							</div>
							<?php $user = db_get_row_data('users',array('id'=>$post->user_id)); ?>
							<h2><?= $user->full_name ?></h2>
							<small>Published on <?= date('M d, Y',strtotime($post->date_created)) ?></small>
						</div>
						<div class="single-video-info-content box mb-3">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="control-label">Comment</label>
										<textarea id="comment" name="comment" rows="5" placeholder="Comment.." class="form-control border-form-control" required="required"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 text-right">
									<button type="button" id="comment_post" class="btn btn-outline-danger">Comment</button>
								</div>
							</div>
						</div>
						<div id="comment-list">
							<?php foreach (db_get_all_data('post_comment',array('post_id'=>$post->id),false,'datetime DESC',15) as $post_comment) { ?>
								<?php if(db_get_count_data('users',array('id'=>$post_comment->user_id)) != 0){ ?>
									<?php $usr = db_get_row_data('users',array('id'=>$post_comment->user_id)); ?>
									<div class="single-video-author box mb-3">
										<?php if($usr->profile_image != ''){ ?>
											<?php if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){ ?>
												<img class="img-fluid" src="<?= BASE_URL . 'upload_data/user/' . $usr->profile_image; ?>" alt="<?= $usr->full_name ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $usr->full_name ?>" />
											<?php } else { ?>
												<img class="img-fluid" src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $usr->full_name ?>" />
											<?php } ?>
										<?php } else { ?>
											<img class="img-fluid" src="<?= BASE_ASSET . 'admin/images/user.png'; ?>" alt="<?= $usr->full_name ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $usr->full_name ?>" />
										<?php } ?>
										<p><?= $post_comment->comment ?></p>
										<small><?= time_elapsed_string($post_comment->datetime); ?></small>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="single-video-right">
						<div class="row">
							<div class="col-md-12">
								<div class="main-title">
									<h6>New Posts</h6>
								</div>
							</div>
							<div class="col-md-12">
								<?php foreach ($posts as $pst) { ?>
									<div class="video-card video-card-list" style="cursor: pointer;" onclick="window.location.href='<?= BASE_URL?>post/view/<?= $channel_id ?>/<?= $pst->id ?>';">
										<div class="user-image text-center">
											<?php $usr = db_get_row_data('users',array('id'=>$pst->user_id)); ?>
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
												<?= substr(strip_tags($pst->content),0,100) . '....' ?>
											</div>
											<div class="video-view">
												<?= db_get_count_data('post_comment',array('post_id'=>$pst->id)) ?> comments &nbsp;<i class="fa fa-history"></i> <?= time_elapsed_string($post->date_created) ?>
											</div>
										</div>
									</div>
									<hr />
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#comment_post').click(function() {
			var comment = $('#comment').val();
			$.ajax({
				url: '<?= BASE_URL ?>post/comment/<?= $post->id ?>',
				type: 'POST',
				data: {'comment':comment}
			})
			.done(function(res) {
				if (res.success) {
					$('#comment').val('');
					$('#comment-list').prepend(res.html);
					$('.message').html(res.message);
					$('.message').fadeIn();
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Error save data</div>');
				$('.message').fadeIn();
			})
			.always(function() {
			});
		});

		$(document).on('click','#copy_share_url',function () {
			var copyText = document.getElementById("share_url");
			copyText.select();
			document.execCommand("copy");

			$('.message').html('<div class="alert alert-success">Link copied to clipboard.</div>');
			$('.message').fadeIn();
		});
	</script>