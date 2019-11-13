<div id="shareUrlModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Share Video</h4>
			</div>
			<div class="modal-body">
				<div class="osahan-form">
					<div class="row">youtube
						<div class="col-lg-12">
							<div class="form-group">
								<label for="share_url">Copy video link</label>
								<div class="input-group mb-3">
									<input type="text" id="share_url" class="form-control" aria-describedby="basic-addon3" value="<?= BASE_URL . 'video_play?vid=' . $video->id ?>" />
									<div class="input-group-prepend" style="cursor: pointer;">
										<span class="input-group-text" id="copy_share_url">Copy</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<p>
									<a href="https://www.facebook.com/" alt="Share On Facebook" target="_blank">
										<i class="fa fa-facebook-square fa-4x text-info"></i>
									</a>
									<a href="https://twitter.com/" alt="Share On Twitter" target="_blank">
										<i class="fa fa-twitter-square fa-4x text-info"></i>
									</a>
									<a href="https://plus.google.com/" alt="Share On Google Plus" target="_blank">
										<i class="fa fa-google-plus-square fa-4x text-danger"></i>
									</a>
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
						<div class="single-video">
						<?php
							$cover 		='';
							$advt 		='';
							$ad_time	='';
							$advt_id 	=0;
							$adData 	= db_get_row_data('advertisement',array('video_id'=> $video->id));

							if($video->video_thumbnail != ''){
								$cover = 'data-cover="'.BASE_URL.'upload_data/video/thumbnail/'.$video->video_thumbnail.'"';
							}
							if(!empty($adData )){

								if(($adData->admin_approve==1)&&($adData->payment_status==1)&&($adData->status==1)){

									$advt_id	= $adData->id;
									$advt 		= BASE_URL.'upload_data/advt/'.$adData->advertisement;
									$duration 	= isset($video->duration) ? $video->duration : '';
									$oneThird 	=  $duration / 3;

									if($adData->timing=='1'){
										$ad_time = $oneThird;
									}elseif($adData->timing=='2'){
										$ad_time = floor($oneThird*2);
									}else{
										$ad_time = $duration-1;
									}
									
								}
							}
							$logo = 'data-arg_logoimg="'.BASE_URL.'asset/img/favicon.png"'; ?>

							<div id="zoomvideoplayer" class="zoomvideoplayer auto-init" data-source="<?= BASE_URL ?>upload_data/video/<?= $video->video ?>" data-options='{autoplay: "off",settings_suggestedQuality: "hd720",downloadlink:"off",responsive_ratio: "0.565",disable_downloadbtn:"on"}' <?= $cover ?> <?= $logo ?> data-ad_array='[{"source":"<?= $advt ?>","type":"video","ad_type":"video","ad_time":"<?= $ad_time ?>","ad_skip_delay":"5"}]'>
     			 			</div>
						</div>
						<div class="single-video-title box mb-3">
							<div class="float-right">
								<span data-toggle="modal" data-target="#shareUrlModal">
									<button class="btn btn-outline-danger" data-toggle="tooltip" data-placement="bottom" title="Share Video">
										<i class="fa fa-share-alt"></i>
									</button>
								</span>
								<?php
								if($this->session->userdata('loggedin')){
									$video_watch_later = db_get_row_data('video_watch_later',array('video_id'=>$video->id,'user_id'=>$this->session->userdata('id')));
									if(count($video_watch_later) == 0){
										?>
										<button type="button" class="btn btn-outline-danger watch-later" id="watch_later" data-video-watch="<?= $video->id ?>" data-toggle="tooltip" data-placement="bottom" title="Save as watch later"><i class="fa fa-history"></i></button>
										<?php
									} else {
										?>
										<button type="button" class="btn btn-outline-secondary watch-later" id="watch_later" data-video-watch="<?= $video->id ?>" data-toggle="tooltip" data-placement="bottom" title="Saved in watch later"><i class="fa fa-floppy-o"></i></button>
										<?php
									}
								} else {
									?>
									<button type="button" class="btn btn-outline-danger watch-later" id="watch_later" data-video-watch="<?= $video->id ?>" data-toggle="tooltip" data-placement="bottom" title="Save as watch later"><i class="fa fa-history"></i></button>
									<?php
								}
								?>
							</div>
							<h2><?= $video->title ?></h2>
							<p class="mb-0"><i class="fas fa-eye"></i> <?= db_get_count_data('history',array('video_id'=>$video->id)) ?> views</p>
							<small>Published on <?= date('M d, Y',strtotime($video->date_created)) ?></small>
						</div>
						<div class="single-video-author box mb-3">
							<?php $channel = db_get_row_data('channel',array('id'=>$video->channel_id)) ?>
							<div class="float-right">
								<?php
								if($this->session->userdata('loggedin')){
									$subscribe = db_get_row_data('subscribe',array('channel_id'=>$video->channel_id,'user_id'=>$this->session->userdata('id')));
									if(count($subscribe) == 0){
										?>
										<button type="button" class="btn btn-outline-danger sub-take" id="subscribe_button<?= $video->channel_id ?>" data-sub="<?= $video->channel_id ?>"><span id="sub-text<?= $channel->id ?>">Subscribe</span></button>
										<?php
									} else {
										?>
										<button type="button" class="btn btn-outline-secondary sub-take" id="subscribe_button<?= $video->channel_id ?>" data-sub="<?= $video->channel_id ?>"><span id="sub-text<?= $channel->id ?>">Subscribed</span></button>
										<?php
									}
								} else {
									?>
									<button type="button" class="btn btn-outline-danger sub-take" id="subscribe_button<?= $video->channel_id ?>" data-sub="<?= $video->channel_id ?>"><span id="sub-text<?= $channel->id ?>">Subscribe</span></button>
									<?php
								}
								?>
								<?php $video_like_detail = db_get_row_data('video_like_detail',array('video_id'=>$video->id,'user_id'=>$this->session->userdata('id'))); ?>
								<?php if(count($video_like_detail) == 0){ ?>
									<button class="btn btn-outline-danger addr" id="like-button" data-resource="like" type="button" data-toggle="tooltip" data-placement="bottom" title="Like Video">
										<i class="fa fa-thumbs-up"></i> 
										<span id="like-text">Like</span>
										<span id="count-like-text">
											<?= db_get_count_data('video_like_detail',array('video_id'=>$video->id,'type'=>'like')) ?>
										</span>
									</button>
									<button class="btn btn-outline-danger addr" id="dislike-button" data-resource="dislike" type="button" data-toggle="tooltip" data-placement="bottom" title="Dislike Video">
										<i class="fa fa-thumbs-down"></i>
										<span id="dislike-text">Dislike</span>
										<span id="count-dislike-text">
											<?= db_get_count_data('video_like_detail',array('video_id'=>$video->id,'type'=>'dislike')) ?>
										</span>
									</button>
								<?php } else { ?>
									<?php if ($video_like_detail->type == 'like') { ?>
										<button class="btn btn-outline-secondary rmv" id="like-button" data-resource="like" type="button" data-toggle="tooltip" data-placement="bottom" title="Like Video">
											<i class="fa fa-thumbs-up"></i>
											<span id="like-text">Liked</span>
											<span id="count-like-text">
												<?= db_get_count_data('video_like_detail',array('video_id'=>$video->id,'type'=>'like')) ?>
											</span>
										</button>
										<button class="btn btn-outline-danger addr" id="dislike-button" data-resource="dislike" type="button" data-toggle="tooltip" data-placement="bottom" title="Dislike Video">
											<i class="fa fa-thumbs-down"></i>
											<span id="dislike-text">Dislike</span>
											<span id="count-dislike-text">
												<?= db_get_count_data('video_like_detail',array('video_id'=>$video->id,'type'=>'dislike')) ?>
											</span>
										</button>
									<?php } else { ?>
										<button class="btn btn-outline-danger addr" id="like-button" data-resource="like" type="button" data-toggle="tooltip" data-placement="bottom" title="Like Video">
											<i class="fa fa-thumbs-up"></i>
											<span id="like-text">Like</span>
											<span id="count-like-text"><?= db_get_count_data('video_like_detail',array('video_id'=>$video->id,'type'=>'like')) ?></span>
										</button>
										<button class="btn btn-outline-secondary rmv" id="dislike-button" data-resource="dislike" type="button" data-toggle="tooltip" data-placement="bottom" title="Dislike Video">
											<i class="fa fa-thumbs-down"></i>
											<span id="dislike-text">Disliked</span>
											<span id="count-dislike-text">
												<?= db_get_count_data('video_like_detail',array('video_id'=>$video->id,'type'=>'dislike')) ?>
											</span>
										</button>
									<?php } ?>
								<?php } ?>
							</div>
							<a href="<?php echo BASE_URL.'channels/view/'.$channel->id; ?>">
							<?php if($channel->logo != ''){ ?>
								<img class="img-fluid" src="<?= BASE_URL ?>upload_data/channel/<?= $channel->logo ?>" alt="<?= $channel->name ?>">
							<?php } else { ?>
								<img class="img-fluid" src="<?= BASE_ASSET ?>img/s1.png" alt="<?= $channel->name ?>">
							<?php } ?>
							</a>
							<p><a href="<?= BASE_URL ?>channels/view/<?= $channel->id ?>"><strong><?= $channel->name ?></strong></a></p>
							<small><span id="channel_subs_count<?= $video->channel_id ?>"><?= db_get_count_data('subscribe',array('channel_id'=>$video->channel_id)) ?></span> subscribers</small>
						</div>
						<div class="single-video-info-content box mb-3">
							<h6>Category :</h6>
							<p><?= db_get_row_data('category',array('id'=>$video->category_id))->name ?></p>
							<h6>About :</h6>
							<p><?= $video->description ?> </p>
							<h6>Tags :</h6>
							<p class="tags mb-0">
								<?php if($video->tags != ''){ ?>
									<?php foreach(explode(",", $video->tags) as $key => $val){ ?>
										<span><a href="javascript:void(0);"><?= $val ?></a></span>
									<?php } ?>
								<?php } ?>
							</p>
						</div>
						<div class="single-video-info-content box mb-3">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="control-label">Comment</label>
										<?php
											$edit_comment 	='';
											$comment_toEdit ='';
											if((isset($_GET['edit_video_comment']))&&(!empty($_GET['edit_video_comment']))){
												$commentData   = db_get_row_data('video_comment',array('id'=>$_GET['edit_video_comment']));
												$comment_toEdit= $commentData->id;
												$edit_comment  = $commentData->comment;
											}
											?>
										<textarea id="comment" name="comment" rows="5" placeholder="Comment.." class="form-control border-form-control" required="required"><?php echo $edit_comment; ?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 text-right">
									<?php
										if(!empty($edit_comment)){
										?>
											<button type="button" id="update_comment_video" data-id="<?php echo $comment_toEdit; ?> " class="btn btn-outline-danger">Update Comment</button>
										<?php
										}else{
										?>
											<button type="button" id="comment_video" class="btn btn-outline-danger">Comment</button>
									<?php } ?>
								</div>
							</div>
						</div>
						<div id="comment-list">
							<?php foreach (db_get_all_data('video_comment',array('video_id'=>$video->id),false,'datetime DESC',15) as $video_comment) {
								
								//DO not show if same comment id added into url
								if($comment_toEdit!=$video_comment->id){

									if(db_get_count_data('users',array('id'=>$video_comment->user_id)) != 0){ ?>

								<?php	$default_channel = db_get_row_data('channel',array('user_id'=>$video_comment->user_id,'is_default'=>1));	?>
										<div class="single-video-author box mb-3">

											<?php $usr = db_get_row_data('users',array('id'=>$video_comment->user_id)); ?>

											<?php //if($usr->profile_image != ''){ ?>
												<?php if(isset($default_channel->logo) && $default_channel->logo!= ''){ ?>

												<?php //if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){ ?>
												<?php if(file_exists(FCPATH . 'upload_data/channel/' . $default_channel->logo)){ ?>

													<!--<img class="img-fluid" src="<?php //echo BASE_URL . 'upload_data/user/' . $usr->profile_image; ?>" alt="<?php // $usr->full_name ?>" />-->
													<a href="<?php echo BASE_URL.'channels/view/'.$default_channel->id; ?>">
													<img class="img-fluid" src="<?= BASE_URL . 'upload_data/channel/' . $default_channel->logo; ?>" alt="<?= $usr->full_name ?>" />
													</a>
												<?php } else { ?>
													<a href="<?php echo BASE_URL.'channels/view/'.$default_channel->id; ?>">
													<img class="img-fluid" src="<?= BASE_ASSET . 'img/s1.png'; ?>" alt="<?= $usr->full_name ?>" />
													</a>	
												<?php } ?>

											<?php } else { ?>
												<a href="<?php echo BASE_URL.'channels/view/'.$video->channel_id; ?>">	
												<img class="img-fluid" src="<?= BASE_ASSET . 'img/s1.png'; ?>" alt="<?= $usr->full_name ?>" />
												</a>	
											<?php } ?>

											<strong>
												<?php 	$channel_url = isset($default_channel->id) ? $default_channel->id : $video->channel_id;	?>
												<a href="<?php echo BASE_URL.'channels/view/'.$channel_url; ?>">
												<?php	echo isset($default_channel->name) ? $default_channel->name:  $usr->full_name; ?>
												</a>
											</strong>

											<small><?= time_elapsed_string($video_comment->datetime); ?></small>
											<p><?= $video_comment->comment ?></p>
											<?php if($video_comment->user_id == $this->session->userdata('id') || $video->user_id == $this->session->userdata('id')){ ?>
												<div class="pull-right">
													<a href="<?= BASE_URL.'video_play?vid='.$video->id.'&edit_video_comment='.$video_comment->id ?>">
														<i class="fa fa-edit text-danger"></i>
													</a>
													<a href="javascript:remove_comment(<?= $video_comment->id ?>);"><i class="fa fa-trash text-danger"></i></a>
												</div>
											<?php } ?>
											
											<div class="like-dislike-panel">
												<p>&nbsp;</p>
												<?php
												$check_data = db_get_row_data('likes_and_dislikes',array('cmt_id'=>$video_comment->id,'user_id'=>$this->session->userdata('id')));
												$liked 			=	'';
												$disliked 		=	'';
												$likeComment 	=	'likeComment';
												$dislikeComment =	'dislikeComment';

												if(isset($check_data->likes)){

													$liked= $check_data->likes;
													if($liked==1){
														$likeComment = 'text-primary alreadyCliked likeComment';
													}
												}
												if(isset($check_data->dislikes)){

													$disliked= $check_data->dislikes;
													if($disliked==1){
														$dislikeComment = 'text-primary alreadyCliked';
													}
												}
												?>
												<a data-toggle="tooltip" data-placement="bottom" title="Like" href="javascript:void(0);" data-comment="<?= $video_comment->id?>" data-user="<?= $video_comment->user_id ?>" 
													class="float-left h6 <?= $likeComment ?>" style="width: 35px">
													<i class="fas fa-thumbs-up"></i>
												</a>
												<h5 class="h6 float-left" style="width: 35px" id="totalLikes">
													<?= !empty($video_comment->likes) ? $video_comment->likes : 0 ?>
													</h5>
												<a data-toggle="tooltip" data-placement="bottom" title="Dislike" href="javascript:void(0);" data-comment="<?= $video_comment->id?>" data-user="<?= $this->session->userdata('id') ?>" class="float-left h6 <?= $dislikeComment ?>" style="width: 35px">
													<i class="fas fa-thumbs-down"></i>
												</a>
												<a data-toggle="tooltip" data-placement="bottom" title="Reply" href="javascript:void(0);" class="h6 float-left replypanelToggle" comment-id="<?= $video_comment->id ?>" style="font-size: .88rem;">	REPLY</a>
												<p>&nbsp;</p>
												<div class="replyComment-panel" style="display: none" id="replyComment_<?= $video_comment->id?>">
													<div class="replyComment-body">

														<?php $default_channel_current = db_get_row_data('channel',array('user_id'=>$this->session->userdata('id'),'is_default'=>1)); ?>
														<?php if(isset($default_channel_current->id) && $default_channel_current->id != ''){ 
															$channelLogo  = $default_channel_current->logo;
															
															if( !empty( $channelLogo )){
																$channelLogo   = BASE_URL.'upload_data/channel/'.$default_channel_current->logo;
															}else{
																$channelLogo   = BASE_URL.'asset/img/s1.png';
															}
														?>
														<a href="<?php echo BASE_URL.'channels/view/'.$default_channel_current->id; ?>">
														<img class="img-fluid" src="<?= $channelLogo ?>" alt="<?= $default_channel_current->name ?>">
														</a>
														<textarea name="replyComment-text" class="replyComment-text" placeholder="Add a public reply"></textarea>
														<div class="replyComment-btns pull-right">
															<a href="javascript:void(0)" class="btn btn-danger cancelReply">Cancel</a>
															<a href="javascript:void(0)" class="btn btn-primary submitReply" comment-id="<?= $video_comment->id ?>">Reply</a>
														</div>
													<?php } else { ?>
														<div class="alert alert-danger replyError">You must login first!</div>
													<?php } ?>
														
													</div><!-- /body -->																						
												</div><!-- /replyComment-panel-->
												<div class="viewReply-panel">
													<?php $replies  = db_get_all_data('reply_comment',array('comment_id'=>$video_comment->id));	?>
													<div class="viewReplies-panel">
														<a href="javascript:void(0)" class="viewReplies">
															<strong>View <?= count($replies); ?> Replies &nbsp;<i class="fas fa-angle-down"></i></strong>
														</a>
													</div><!--/viewReplies-panel-->

													<div class="hideReplies-panel" style="display: none;">
														<a href="javascript:void(0)" class="hideReplies">
															<strong>Hide Replies &nbsp;<i class="fas fa-angle-up"></i></strong>
														</a>
														<?php
														foreach ($replies as $reply) {
														?>
														<div class="box">
															<?php
																$replyUsr = db_get_row_data('users',array('id'=>$reply->user_id));
																$defaultChnllogo = db_get_row_data('channel',array('user_id'=>$reply->user_id,'is_default'=>1));
															?>														
															<?php if(isset($defaultChnllogo->logo) && $defaultChnllogo->logo!= ''){ ?>													
															<?php if(file_exists(FCPATH . 'upload_data/channel/' . $defaultChnllogo->logo)){ ?>
																<a href="<?php echo BASE_URL.'channels/view/'.$defaultChnllogo->id; ?>">
																<img class="img-fluid" src="<?= BASE_URL . 'upload_data/channel/' . $defaultChnllogo->logo; ?>" alt="<?= $replyUsr->full_name ?>" />
																</a>
															<?php } else { ?>
																<a href="<?php echo BASE_URL.'channels/view/'.$defaultChnllogo->id; ?>">
																<img class="img-fluid" src="<?= BASE_ASSET.'img/s1.png'; ?>" alt="<?= $replyUsr->full_name ?>" />
																</a>
															<?php } ?>
															<?php } else { ?>
																<a href="<?php echo BASE_URL.'channels/view/'.$defaultChnllogo->id; ?>">
																<img class="img-fluid" src="<?= BASE_ASSET.'img/s1.png'; ?>" alt="<?= $replyUsr->full_name ?>" />
																</a>
															<?php } ?>
															<p><strong><?= $reply->reply_text ?></strong></p>
															<small><?= time_elapsed_string($reply->date_updated); ?></small>
														</div>
													<?php } ?>

													</div><!--/hideReplies-panel-->

												</div><!--/viewReply-panel-->
											</div>
										</div>
									<?php } ?>

								<?php } ?>

							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="single-video-right">
						<div class="row">
							<div class="col-md-12">
								<?= get_option('ads_sidebar') ?>
								<div class="main-title"><h6>Up Next</h6></div>
							</div>
							<div class="col-md-12">
								<?php foreach (db_get_all_data('videos',array('id !='=>$video->id),false,'date_created DESC',10) as $vid) { ?>
									<div class="video-card video-card-list">
										<div class="video-card-image">
											<a class="play-icon" href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>"><i class="fas fa-play-circle"></i></a>
											<a href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>">
												<?php if($vid->video_thumbnail != ''){ ?>
													<img class="img-fluid" src="<?= BASE_URL ?>upload_data/video/thumbnail/<?= $vid->video_thumbnail ?>" alt="<?= $vid->title ?>">
												<?php } else { ?>
													<video style="width: 100%;" preload="metadata" src="<?= BASE_URL ?>upload_data/video/<?= $vid->video ?>#t=0.5"></video>
												<?php } ?>
											</a>
										</div>
										<div class="video-card-body">
											<div class="video-title">
												<a href="<?= BASE_URL ?>video_play?vid=<?= $vid->id ?>"><?= $vid->title ?></a>
											</div>
											<div class="video-page text-success">
												<?php $category = db_get_row_data('category',array('id'=>$vid->category_id)); ?>
												<?= $category->name ?>  <a href="#"><i class="fa <?= $category->icon ?> text-success"></i></a>
											</div>
											<div class="video-view">
												<?= db_get_count_data('history',array('video_id'=>$vid->id)) ?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= time_elapsed_string($vid->date_created) ?>
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
	</div>
	
	<script>
		$(document).on("click",".rmv", function() {
			$.ajax({url: '<?= BASE_URL ?>video_play/like_remove/<?= $video->id ?>',	type: 'GET',})
			.done(function(res) {
				if (res.success) {
					$("#dislike-button").removeClass("btn-outline-secondary").addClass("btn-outline-danger");
					$("#dislike-button").removeClass("rmv").addClass("addr");
					$("#dislike-text").text("Dislike");
					$("#like-button").removeClass("btn-outline-secondary").addClass("btn-outline-danger");
					$("#like-button").removeClass("rmv").addClass("addr");
					$("#like-text").text("Like");

					$('#count-like-text').text(res.video_like_count);
					$('#count-dislike-text').text(res.video_dislike_count);
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Unable to access</div>');
				$('.message').fadeIn();
			})
		});
		$(document).on("click",".addr", function() {
			var resourceType = $(this).attr('data-resource');
			$.ajax({
				url: '<?= BASE_URL ?>video_play/like/<?= $video->id ?>',
				type: 'GET',data:{'type':resourceType}
			})
			.done(function(res) {
				if (res.success) {
					if(res.type == 'like'){
						$("#dislike-button").removeClass("btn-outline-secondary").addClass("btn-outline-danger");
						$("#dislike-button").removeClass("rmv").addClass("addr");
						$("#dislike-text").text("Dislike");
						$("#like-button").removeClass("btn-outline-danger").addClass("btn-outline-secondary");
						$("#like-button").removeClass("addr").addClass("rmv");
						$("#like-text").text("Liked");
					} else {
						$("#dislike-button").removeClass("btn-outline-danger").addClass("btn-outline-secondary");
						$("#dislike-button").removeClass("addr").addClass("rmv");
						$("#dislike-text").text("Disliked");
						$("#like-button").removeClass("btn-outline-secondary").addClass("btn-outline-danger");
						$("#like-button").removeClass("rmv").addClass("addr");
						$("#like-text").text("Like");
					}
					$('#count-like-text').text(res.video_like_count);
					$('#count-dislike-text').text(res.video_dislike_count);
					$('.message').html(res.message);
					$('.message').fadeIn();
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Unable to access</div>');
				$('.message').fadeIn();
			})
		});

		$(document).on("click",".watch-later", function() {
			var videoId = $(this).attr('data-video-watch');
			$.ajax({
				url: '<?= BASE_URL ?>video_play/watch_later',
				type: 'GET',data:{'video_id':videoId}
			})
			.done(function(res) {
				if (res.success) {
					if(res.type == 'save'){
						$("#watch_later").removeClass("btn-outline-danger").addClass("btn-outline-secondary");
						$("#watch_later").html('<i class="fa fa-floppy-o"></i>');
						$("#watch_later").attr("data-original-title","Saved in watch later");
					} else {
						$("#watch_later").removeClass("btn-outline-secondary").addClass("btn-outline-danger");
						$("#watch_later").html('<i class="fa fa-history"></i>');
						$("#watch_later").attr("data-original-title","Save as watch later");
					}
					$('.message').html(res.message);
					$('.message').fadeIn();
				} else {
					$('.message').html(res.message);
					$('.message').fadeIn();
				}
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Unable to access</div>');
				$('.message').fadeIn();
			})
		});

		$('#comment_video').click(function() {
			var comment = $('#comment').val();
			$.ajax({
				url: '<?= BASE_URL ?>video_play/comment/<?= $video->id ?>',
				type: 'POST',data: {'comment':comment}
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
		});

		$(document).on('click','#copy_share_url',function () {
			var copyText = document.getElementById("share_url");
			copyText.select();
			document.execCommand("copy");
			$('.message').html('<div class="alert alert-success">Link copied to clipboard.</div>');
			$('.message').fadeIn();
		});

		function remove_comment(video_comment_id) {
			if(confirm('Are you sure to remove the video comment ?')){
				window.location.href = "<?= BASE_URL ?>video_play/remove_comment/<?= $video->id ?>/"+video_comment_id;
			}
		}

		//Update comment
		$(document).on('click','#update_comment_video',function(){
			var comment_id 	= $(this).attr('data-id');
			var comment 	= $('#comment').val();
			$.ajax({
				url: '<?= BASE_URL ?>video_play/update_comment/'+comment_id,
				type: 'POST',data: {'comment':comment}
			})
			.done(function(res) {
				if (res.success) {
					$('#comment').val('');
					$('.message').html(res.message);
					$('.message').fadeIn();
					setTimeout(function() {window.location.href = "<?= BASE_URL ?>video_play?vid=<?= $video->id ?>";}, 1000);
				}
			}).fail(function() {
				$('.message').html('<div class="alert alert-danger">Error save data</div>');
				$('.message').fadeIn();
			})

		});
	</script>
	<script type="text/javascript">
		/**
		*Dislike comment 
		*/
		$(document).on('click','.dislikeComment',function(){
			var thumb 		= $(this);
			var comment_id 	= thumb.attr('data-comment');
			var user_id 	= thumb.attr('data-user');
			if(thumb.hasClass('alreadyCliked')){
				return false;
			}else{
				thumb.parent('.like-dislike-panel').find(".alreadyCliked").addClass('likeComment');
				thumb.parent('.like-dislike-panel').find(".alreadyCliked").removeClass('alreadyCliked');
				thumb.addClass('alreadyCliked');
				thumb.parent('.like-dislike-panel').find(".text-primary").removeClass('text-primary');
				thumb.addClass('text-primary');
				like_dislike_Comment('dislikeComment',thumb,comment_id);
			}
		});

		/**
		*Like comment 
		*/
		$(document).on('click','.likeComment',function(){
			var thumb 		= $(this);
			var comment_id 	= thumb.attr('data-comment');
			var user_id 	= thumb.attr('data-user');
			if(thumb.hasClass('alreadyCliked')){
				if(thumb.hasClass('text-primary')){
					like_dislike_Comment('dislikeComment',thumb,comment_id);
					thumb.parent('.like-dislike-panel').find(".likeComment").removeClass('text-primary');
				}else{
					thumb.addClass('text-primary');
					like_dislike_Comment('likeComment',thumb,comment_id);
				}
			}else{
				thumb.parent('.like-dislike-panel').find(".alreadyCliked").addClass('dislikeComment');
				thumb.parent('.like-dislike-panel').find(".alreadyCliked").removeClass('alreadyCliked');
				thumb.addClass('alreadyCliked');
				thumb.parent('.like-dislike-panel').find(".text-primary").removeClass('text-primary');
				thumb.addClass('text-primary');
				like_dislike_Comment('likeComment',thumb,comment_id);
			}
		});

		/**
		*Ajax function to like dislike comment
		*
		*@param data, functionName
		**/
		function like_dislike_Comment(functionName='',thumb,comment_id){
			$.ajax({
				url: '<?= BASE_URL ?>video_play/'+functionName+'/'+comment_id+'/',
				type: 'GET'
			}).done(function(res) {
				$('.message').html(res.message);
				$('.message').fadeIn();
				if(res.likes){
					thumb.parent('.like-dislike-panel').find("#totalLikes").html(res.likes);
				}
				if(!res.success){
					// if any error then remove text-primary from clicked thumb
					thumb.removeClass('text-primary');
				}

			}).fail(function() {
				$('.message').html('<div class="alert alert-danger">Error..!</div>');
				$('.message').fadeIn();
			});
		}
	</script>
	<script type="text/javascript">
		/**Toggl Reply panel**/
		$(document).on('click','.replypanelToggle',function(){
			var comment_id 	= $(this).attr('comment-id');
			$('#replyComment_'+comment_id).css( 'display','block' );
			$( '.replyError' ).css( 'display','block' )
		});
		/**Cancel**/
		$(document).on('click','.cancelReply',function(){
			$('.replyComment-panel').fadeOut();
		});
		/**Submit Reply***/
		$(document).on('click','.submitReply',function(){
			var comment_id 	= $(this).attr('comment-id');
			var reply_text = $('#replyComment_'+comment_id).find('textarea').val();
			if(reply_text==''){
				$('.message').html('<div class="alert alert-danger">Section can not be empty .</div>');
			}
			var data = {'reply_text':reply_text};
			$.ajax({
				url: '<?= BASE_URL ?>video_play/reply_comment/'+comment_id,
				type: 'POST',data: data
			}).done(function(res) {
				$('.message').html(res.message);
				$('.message').fadeIn();
				if(res.success){
					window.location.reload();
				}
			}).fail(function() {
				$('.message').html('<div class="alert alert-danger">Error..!</div>');
				$('.message').fadeIn();
			})
		});

		/** View Replies Panel toggle**/
		$(document).on('click','.hideReplies',function(){
			$(this).parent('.hideReplies-panel').hide();
			$(this).parent('.hideReplies-panel').parent('.viewReply-panel').find('.viewReplies-panel').show();
		});
		/** View Replies Panel toggle**/
		$(document).on('click','.viewReplies',function(){
			$(this).parent('.viewReplies-panel').hide();
			$(this).parent('.viewReplies-panel').parent('.viewReply-panel').find('.hideReplies-panel').show();
		});		
	</script>

	<script>
	/**	Advertisemnet impressions Tracking **/
	$(function() {

		var saveImpression = true;

		$(document).ready(function(){
		  $("video").on(
		    "timeupdate", 
		    function(event){
		    	<?php if((!empty($video->id))&&(!empty($advt_id))){ ?>

		      		onTrackedVideoFrame(this.currentTime, this.duration);

		      <?php } ?>
		    });
		});

		function onTrackedVideoFrame(currentTime, duration){

			advt_timing = '';
			var advt_timing ='<?= $ad_time ?>';
			if((advt_timing!=undefined) ||(advt_timing!='')){
				
			    if(currentTime>advt_timing){

			    	if(saveImpression==true){
			    		//make it false to work only once
			    		saveImpression=false;
			    		$.ajax({
							url: '<?= BASE_URL ?>video_play/save_advt_impression',
							type: 'POST',data: {'video_id':<?= $video->id ?>,'advt_id':<?= $advt_id ?>}
						}).done(function(res) {
							console.log(res);
						}).fail(function() {
							$('.message').html('<div class="alert alert-danger">Advertisemnet impressions saving error..!</div>');
							$('.message').fadeIn();
						});
			    	}
					
			    }

			}
		  
		}
		
	});
	</script>

<style type="text/css">
iframe{	display: block;	background: #000;border: none;width: 100% !important;}.replyComment-panel {width: 100%;}.replyComment-body {width: 100%;clear: both;}
.replyComment-body input,.replyComment-body textarea {border: none;border-bottom: 3px solid #ddd;width: 70%;padding: 0px 8px;margin-bottom: 0px;}
.viewReply-panel { width: 100%; position: relative;clear: both; padding-top: 10px;}	.viewReplies-panel, .hideReplies-panel {clear: both;}
/**Zoom Player style***/
.zoomvideoplayer{position:relative;width:100%;height:300px;line-height:1;overflow:hidden;opacity:0;background-color:#222;transition-property:opacity;transition-duration:.3s;-moz-transition-property:opacity;-moz-transition-duration:.3s;-webkit-transition-property:opacity;-webkit-transition-duration:.3s;-o-transition-property:opacity;-o-transition-duration:.3s;-ms-transition-property:opacity;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.zoomvideoplayer *{-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.zoomvideoplayer object{outline:0}.zoomvideoplayer .menu-feed-thumbnail,.zoomvideoplayer .menu-feed-html,.zoomvideoplayer .menu-feed-title,.zoomvideoplayer .menu-feed-description{display:none}.zoomvideoplayer .feed-dzszvp{display:none}.zoomvideoplayer .cover-image,.zoomvideoplayer .media-image{position:absolute;top:0;left:0;width:100%;height:100%;background-size:contain;background-position:center center;background-repeat:no-repeat;background-color:#222}.zoomvideoplayer .cover-play-btn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%);opacity:.5;transition-property:opacity;transition-duration:.5s;-moz-transition-property:opacity;-moz-transition-duration:.5s;-webkit-transition-property:opacity;-webkit-transition-duration:.5s;-o-transition-property:opacity;-o-transition-duration:.5s;-ms-transition-property:opacity;-ms-transition-duration:.5s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out;cursor:pointer}.zoomvideoplayer .cover-play-btn:hover{opacity:1}.zoomvideoplayer .video-overlay{position:absolute;cursor:pointer;top:0;left:0;width:100%;height:100%}.zoomvideoplayer .controls-con .play-btn,.zoomvideoplayer .controls-con .pause-btn,.zoomvideoplayer .controls-con .fullscreen-btn,.zoomvideoplayer .controls-con .vol-btn--icon,.zoomvideoplayer .controls-con .vol-bar-con,.zoomvideoplayer .controls-con .scrubbar,.zoomvideoplayer .controls-con .hd-btn,.zoomvideoplayer .controls-con .download-btn,.zoomvideoplayer .controls-con .social-btn,.zoomvideoplayer .controls-con .embed-btn,.zoomvideoplayer .controls-con .mute-btn,.zoomvideoplayer .controls-con .unmute-btn,.zoomvideoplayer .controls-con .btn-info{cursor:pointer}.zoomvideoplayer .controls-con > span{font-size:12px;line-height:1.7;position:absolute}.zoomvideoplayer .controls-con .play-btn,.zoomvideoplayer .controls-con .pause-btn,.zoomvideoplayer .controls-con .curr-time-holder,.zoomvideoplayer .controls-con .total-time-holder,.zoomvideoplayer .controls-con .mute-btn,.zoomvideoplayer .controls-con .unmute-btn{transition-property:opacity,visibility;transition-duration:.3s;-moz-transition-property:opacity,visibility;-moz-transition-duration:.3s;-webkit-transition-property:opacity,visibility;-webkit-transition-duration:.3s;-o-transition-property:opacity,visibility;-o-transition-duration:.3s;-ms-transition-property:opacity,visibility;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer .controls-con .play-btn,.zoomvideoplayer .controls-con .pause-btn,.zoomvideoplayer .controls-con .mute-btn.active,.zoomvideoplayer .controls-con .unmute-btn.active{visibility:visible;opacity:1}.zoomvideoplayer .controls-con .pause-btn,.zoomvideoplayer .controls-con .unmute-btn,.zoomvideoplayer .controls-con .mute-btn{visibility:hidden;opacity:0}.zoomvideoplayer .controls-con .curr-time-holder,.zoomvideoplayer .controls-con .total-time-holder{visibility:hidden;opacity:0;pointer-events:none}.zoomvideoplayer .controls-con .curr-time-holder.ready,.zoomvideoplayer .controls-con .total-time-holder.ready{visibility:visible;opacity:1}.zoomvideoplayer .controls-con .total-time-holder.ready{visibility:visible;opacity:.5}.zoomvideoplayer .scrubbar-box,.zoomvideoplayer .scrubbar-box-prog{visibility:hidden}.zoomvideoplayer .the-media-con > video{width:100%;height:100%}.zoomvideoplayer div.zoomvideoplayer-hd,.zoomvideoplayer div.zoomvideoplayer-is-ad{position:absolute;top:0;left:0;width:100%;height:100%;visibility:hidden;opacity:0;pointer-events:none;transition-property:visibility,opacity;transition-duration:.5s;-moz-transition-property:visibility,opacity;-moz-transition-duration:.5s;-webkit-transition-property:visibility,opacity;-webkit-transition-duration:.5s;-o-transition-property:visibility,opacity;-o-transition-duration:.5s;-ms-transition-property:visibility,opacity;-ms-transition-duration:.5s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer div.zoomvideoplayer-hd object,.zoomvideoplayer div.zoomvideoplayer-is-ad object{display:none}.zoomvideoplayer .social-container{position:absolute;top:0;left:0;width:100%;height:100%;visibility:hidden;opacity:0;overflow:hidden;transition-property:visibility,opacity;transition-duration:1s;-moz-transition-property:visibility,opacity;-moz-transition-duration:1s;-webkit-transition-property:visibility,opacity;-webkit-transition-duration:1s;-o-transition-property:visibility,opacity;-o-transition-duration:1s;-ms-transition-property:visibility,opacity;-ms-transition-duration:1s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer .social-container .social-container--bg{position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(50,50,50,0.8)}.zoomvideoplayer .social-container .social-container--separator{position:absolute;height:1px;width:120%;left:-10%;background-color:rgba(255,255,255,0.2);-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg);transition-property:all;transition-duration:1s;-moz-transition-property:all;-moz-transition-duration:1s;-webkit-transition-property:all;-webkit-transition-duration:1s;-o-transition-property:all;-o-transition-duration:1s;-ms-transition-property:all;-ms-transition-duration:1s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer .social-container .social-container--room{position:relative}.zoomvideoplayer .social-container .social-container--room > span{position:absolute;left:50%;top:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.zoomvideoplayer .social-container.active{visibility:visible;opacity:1}.zoomvideoplayer .social-container.active .social-container--separator{-webkit-transform:rotate(2.5deg);-ms-transform:rotate(2.5deg);transform:rotate(2.5deg)}.zoomvideoplayer .play-btn-for-skin-pro .play-btn-fig{transition-property:all;transition-duration:.3s;-moz-transition-property:all;-moz-transition-duration:.3s;-webkit-transition-property:all;-webkit-transition-duration:.3s;-o-transition-property:all;-o-transition-duration:.3s;-ms-transition-property:all;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer .play-btn-for-skin-avanti path,.zoomvideoplayer .pause-btn-for-skin-avanti path,.zoomvideoplayer .mute-btn-for-skin-avanti path,.zoomvideoplayer .unmute-btn-for-skin-avanti path{transition-property:all;transition-duration:.7s;-moz-transition-property:all;-moz-transition-duration:.7s;-webkit-transition-property:all;-webkit-transition-duration:.7s;-o-transition-property:all;-o-transition-duration:.7s;-ms-transition-property:all;-ms-transition-duration:.7s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer .dzstag-tobe{display:none}.zoomvideoplayer .dzstag{position:absolute;top:0;left:0;opacity:0;visibility:hidden;transition-property:all;transition-duration:.7s;-moz-transition-property:all;-moz-transition-duration:.7s;-webkit-transition-property:all;-webkit-transition-duration:.7s;-o-transition-property:all;-o-transition-duration:.7s;-ms-transition-property:all;-ms-transition-duration:.7s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer .dzstag .tag-box{border:1px dashed #555;width:50px;height:50px}.zoomvideoplayer .dzstag .tag-box a{width:100%;height:100%;content:",";display:block}.zoomvideoplayer .dzstag .tag-content{position:absolute;right:0;background:#555;color:#eee;display:inline-block;padding:1px 5px}.zoomvideoplayer .dzstag.active{opacity:1;visibility:visible}.zoomvideoplayer .dzstag.full-tag{width:100%;height:100%}.zoomvideoplayer .info-window{position:absolute;top:0;left:0;width:100%;height:100%;display:none}.zoomvideoplayer .info-window .canvas-bg{width:100%;height:100%;filter:blur(20px);-webkit-filter:blur(20px)}.zoomvideoplayer .info-window .center-it{width:100%;position:absolute;top:50%;left:0;transform:translate(0%,-50%)}.zoomvideoplayer .dzszvp-hero-text{text-align:center;font-size:30px;line-height:1.5;color:#eee}.zoomvideoplayer .dzszvp-hero-button-con{margin-top:25px;text-align:center}.zoomvideoplayer .dzszvp-hero-button{display:inline-block;padding:15px 30px;font-size:30px;text-align:center;background-color:#00529B;color:#fff;border-radius:10px}.zoomvideoplayer .info-window.active{display:block}.zoomvideoplayer.disable-fullscreen .fullscreen-btn{display:none!important}.zoomvideoplayer.disable-volume .vol-btn{display:none!important}.zoomvideoplayer.disable-hd .hd-btn{display:none!important}.zoomvideoplayer.disable-download .download-btn{display:none!important}.zoomvideoplayer.disable-social .social-btn{display:none!important}.zoomvideoplayer.disable-embed .embed-btn{display:none!important}.zoomvideoplayer.disable-scrubbar .scrubbar{display:none!important}.dzszvp-subhero-text{text-align:center;font-size:20px;line-height:1.5;color:#eee;margin-bottom:20px}.dzszvp-hero-button-con{margin-top:25px;text-align:center}form.email-form > *{vertical-align:top}.zoomvideoplayer[data-ad_link]{cursor:pointer}.bg-element-translucent-dark{position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.65)}.css-center-it{width:100%;position:absolute;top:50%;left:0;transform:translate(0%,-50%)}.info-window--back-btn{position:absolute;bottom:15px;left:15px;cursor:pointer;padding:10px 12px;line-height:1;background-color:#555;color:#ccc}.blur-it{filter:blur(20px);-webkit-filter:blur(20px)}.zoomvideoplayer.animate-height{transition-property:opacity,height;transition-duration:.3s;-moz-transition-property:opacity,height;-moz-transition-duration:.3s;-webkit-transition-property:opacity,height;-webkit-transition-duration:.3s;-o-transition-property:opacity,height;-o-transition-duration:.3s;-ms-transition-property:opacity,height;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideoplayer-con-laptop{background-image:url(img/mb-body.png);background-size:contain;background-position:center center}.zoomvideoplayer-con-laptop .zoomvideoplayer{width:61%;height:71%;left:19.5%;top:10.9%}.dzszvp-email-input{display:inline-block;width:250px;margin-right:15px;padding:20px;line-height:1;vertical-align:top;font-size:21px;border-radius:10px;border:0}.zoomvideoplayer.is-fullscreen{width:100%!important;height:100%!important;top:0!important;left:0!important}.zoomvideoplayer.is-ie8 div.zoomvideoplayer-hd,.zoomvideoplayer.is-ie8 div.zoomvideoplayer-is-ad,.zoomvideoplayer.is-ie9 div.zoomvideoplayer-hd,.zoomvideoplayer.is-ie9 div.zoomvideoplayer-is-ad{display:none}.zoomvideoplayer.is-ie8 div.zoomvideoplayer-hd.active,.zoomvideoplayer.is-ie8 div.zoomvideoplayer-is-ad.active,.zoomvideoplayer.is-ie9 div.zoomvideoplayer-hd.active,.zoomvideoplayer.is-ie9 div.zoomvideoplayer-is-ad.active{display:block}body div.zoomvideoplayer-hd.active,body div.zoomvideoplayer-is-ad.active{visibility:visible;opacity:1;pointer-events:auto}body div.zoomvideoplayer-hd.active object,body div.zoomvideoplayer-is-ad.active object{display:block}.skipad-con{position:absolute;bottom:35px;right:25px;padding:10px;line-height:1;color:#fff;background-color:rgba(50,50,50,0.9)}.skipad-con.skipable{background-color:rgba(255,255,255,0.9)}.skipad-con .skipad{color:#222;cursor:pointer;opacity:.7;text-transform:uppercase}.zoomvideoplayer.zoomvideoplayer-is-ad .play-btn,.zoomvideoplayer.zoomvideoplayer-is-ad span.pause-btn,.zoomvideoplayer.zoomvideoplayer-is-ad .scrubbar,.zoomvideoplayer.zoomvideoplayer-is-ad .embed-btn,.zoomvideoplayer.zoomvideoplayer-is-ad .download-btn,.zoomvideoplayer.zoomvideoplayer-is-ad .fullscreen-btn,.zoomvideoplayer.zoomvideoplayer-is-ad .video-overlay{opacity:.5}.zoomvideoplayer.zoomvideoplayer-is-ad.enable-play-btn-temporary-for-mobile .play-btn,.zoomvideoplayer.zoomvideoplayer-is-ad.enable-play-btn-temporary-for-mobile span.pause-btn{opacity:1;pointer-events:auto}.zoomvideoplayer.under-480 .hide-under-480{display:none}.zoomvideoplayer.under-320 .hide-under-320{display:none}.zoomvideoplayer.is-pseudo-fullscreen{position:fixed;top:0;left:0;width:100%;height:100%;z-index:9500}.zoomvideoplayer.dzszvp-inited{opacity:1}.zoomvideoplayer.dzszvp-readyall{opacity:1}.zoomvideoplayer.dzszvp-readyall .scrubbar-box,.zoomvideoplayer.dzszvp-readyall .scrubbar-box-prog{visibility:visible}.zoomvideoplayer.playing .play-btn{visibility:hidden;opacity:0}.zoomvideoplayer.playing .pause-btn{visibility:visible;opacity:1}.zoomvideoplayer.skin-default{font-family:"Open Sans",arial,sans-serif;font-size:12px;line-height:1.1}.zoomvideoplayer.skin-default .controls-con .play-btn path,.zoomvideoplayer.skin-default .controls-con .pause-btn rect,.zoomvideoplayer.skin-default .controls-con .vol-btn--icon polygon,.zoomvideoplayer.skin-default .controls-con .hd-btn--icon path,.zoomvideoplayer.skin-default .controls-con .download-btn--icon rect,.zoomvideoplayer.skin-default .controls-con .social-btn--icon path,.zoomvideoplayer.skin-default .controls-con .embed-btn--icon path,.zoomvideoplayer.skin-default .controls-con .btn-info path{transition-property:fill;transition-duration:.3s;-moz-transition-property:fill;-moz-transition-duration:.3s;-webkit-transition-property:fill;-webkit-transition-duration:.3s;-o-transition-property:fill;-o-transition-duration:.3s;-ms-transition-property:fill;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideoplayer.skin-default .controls-con .play-btn:hover path,.zoomvideoplayer.skin-default .controls-con .pause-btn:hover rect,.zoomvideoplayer.skin-default .controls-con .vol-btn--icon:hover polygon,.zoomvideoplayer.skin-default .controls-con .hd-btn:hover .hd-btn--icon path,.zoomvideoplayer.skin-default .controls-con .download-btn:hover .download-btn--icon rect,.zoomvideoplayer.skin-default .controls-con .social-btn:hover .social-btn--icon path,.zoomvideoplayer.skin-default .controls-con .embed-btn:hover .embed-btn--icon path,.zoomvideoplayer.skin-default .controls-con .btn-info:hover path{fill:#e4c000}.zoomvideoplayer.skin-default .controls-con .controls-bg{width:100%;height:30px;position:absolute;bottom:0;left:0;background-color:rgba(50,50,50,0.5)}.zoomvideoplayer.skin-default .controls-con .fullscreen-btn rect{transition-property:fill;transition-duration:.3s;-moz-transition-property:fill;-moz-transition-duration:.3s;-webkit-transition-property:fill;-webkit-transition-duration:.3s;-o-transition-property:fill;-o-transition-duration:.3s;-ms-transition-property:fill;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideoplayer.skin-default .controls-con .fullscreen-btn:hover rect{fill:#e4c000}.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .play-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .pause-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .fullscreen-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .vol-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .hd-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .download-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .social-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .embed-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .scrubbar,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .controls-bg{transition-property:all;transition-duration:.7s;-moz-transition-property:all;-moz-transition-duration:.7s;-webkit-transition-property:all;-webkit-transition-duration:.7s;-o-transition-property:all;-o-transition-duration:.7s;-ms-transition-property:all;-ms-transition-duration:.7s;-ms-transition-timing-function:ease-out-quart;-webkit-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-moz-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);-o-transition-timing-function:cubic-bezier(0.165,0.84,0.44,1);transition-timing-function:cubic-bezier(0.165,0.84,0.44,1)}.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .scrubbar-box-prog{transition-property:opacity;transition-duration:.75s;-moz-transition-property:opacity;-moz-transition-duration:.75s;-webkit-transition-property:opacity;-webkit-transition-duration:.75s;-o-transition-property:opacity;-o-transition-duration:.75s;-ms-transition-property:opacity;-ms-transition-duration:.75s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideoplayer.skin-default .controls-con.enable-auto-hide .controls-bg{transition-property:all;transition-duration:.5s;-moz-transition-property:all;-moz-transition-duration:.5s;-webkit-transition-property:all;-webkit-transition-duration:.5s;-o-transition-property:all;-o-transition-duration:.5s;-ms-transition-property:all;-ms-transition-duration:.5s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .play-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .pause-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .fullscreen-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .vol-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .hd-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .download-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .social-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .embed-btn,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .scrubbar,.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .controls-bg{transform:translateY(30px)}.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .scrubbar-box-prog{opacity:0}.zoomvideoplayer.skin-default .controls-con.enable-auto-hide.mouse-is-out .controls-bg{opacity:0}.zoomvideoplayer.skin-default .btn-info{background-color:transparent}.zoomvideoplayer.skin-default .controls-con .cover-play-btn{cursor:pointer;box-shadow:0 0 3px 0 rgba(0,0,0,0.5);border-radius:50%;opacity:.5;visibility:visible;transition-property:opacity,visibility;transition-duration:.5s;-moz-transition-property:opacity,visibility;-moz-transition-duration:.5s;-webkit-transition-property:opacity,visibility;-webkit-transition-duration:.5s;-o-transition-property:opacity,visibility;-o-transition-duration:.5s;-ms-transition-property:opacity,visibility;-ms-transition-duration:.5s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.cover-play-btn{cursor:pointer}.zoomvideoplayer.skin-default.playing .controls-con .cover-play-btn{opacity:0;visibility:hidden}.btn-info.btn-info-for-skin-default{background-color:transparent}.play-btn.play-btn-for-skin-default{position:absolute;left:14px;bottom:4px}.pause-btn.pause-btn-for-skin-default{position:absolute;left:14px;bottom:4px}.fullscreen-btn.fullscreen-btn-for-skin-default{position:absolute;right:14px;bottom:4px}.vol-btn.vol-btn-for-skin-default{width:60px;height:12px;position:absolute;right:40px;bottom:4px}.vol-btn.vol-btn-for-skin-default .vol-bar-con .vol-bar-bg{width:100%;height:100%;background-color:rgba(50,50,50,0.7);position:absolute;top:0;left:0}.vol-btn.vol-btn-for-skin-default .vol-bar-con .vol-bar-active{width:30%;height:100%;background-color:#E4C000;position:absolute;top:0;left:0}.scrubbar.scrubbar-for-skin-default,.scrubbar.scrubbar-for-skin-pro{margin-right:10px}.scrubbar.scrubbar-for-skin-default .scrubbar-bg,.scrubbar.scrubbar-for-skin-pro .scrubbar-bg{background-color:rgba(50,50,50,0.7)}.scrubbar.scrubbar-for-skin-default .scrubbar-buffered,.scrubbar.scrubbar-for-skin-pro .scrubbar-buffered{background-color:rgba(228,228,228,0.3)}.scrubbar.scrubbar-for-skin-default .scrubbar-prog,.scrubbar.scrubbar-for-skin-default .scrubbar-admark,.scrubbar.scrubbar-for-skin-pro .scrubbar-prog,.scrubbar.scrubbar-for-skin-pro .scrubbar-admark{background-color:#E4C000}.scrubbar.scrubbar-for-skin-default .scrubbar-admark,.scrubbar.scrubbar-for-skin-pro .scrubbar-admark{opacity:.5}.scrubbar.scrubbar-for-skin-default .scrubbar-box,.scrubbar.scrubbar-for-skin-pro .scrubbar-box{position:absolute}.scrubbar.scrubbar-for-skin-default .scrubbar-box-prog,.scrubbar.scrubbar-for-skin-default .scrubbar-box,.scrubbar.scrubbar-for-skin-pro .scrubbar-box-prog,.scrubbar.scrubbar-for-skin-pro .scrubbar-box{font-family:"Open Sans",arial,sans-serif;font-weight:300;font-size:10px;position:absolute;left:-25px;line-height:1.5;background:#fafafa;color:#66645f;border:1px solid rgba(0,0,0,0.2);width:50px;bottom:19px;height:auto;opacity:.9;text-align:center;pointer-events:none}.scrubbar.scrubbar-for-skin-default .scrubbar-box:empty,.scrubbar.scrubbar-for-skin-default .scrubbar-box-prog:empty,.scrubbar.scrubbar-for-skin-pro .scrubbar-box:empty,.scrubbar.scrubbar-for-skin-pro .scrubbar-box-prog:empty{display:none}.scrubbar.scrubbar-for-skin-default .scrubbar-box-prog:before,.scrubbar.scrubbar-for-skin-pro .scrubbar-box-prog:before{content:"";width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-top:6px solid #fafafa;position:absolute;left:50%;top:100%;margin-left:-6px}.scrubbar.scrubbar-for-skin-default .scrubbar-box,.scrubbar.scrubbar-for-skin-pro .scrubbar-box{margin-left:-20px;width:40px;line-height:1.6;font-size:9px;background:#444;color:#898680;border:1px solid rgba(0,0,0,0.2)}.scrubbar.scrubbar-for-skin-default .scrubbar-box.has-image,.scrubbar.scrubbar-for-skin-pro .scrubbar-box.has-image{width:64px;margin-left:-32px}.scrubbar.scrubbar-for-skin-default .scrubbar-box.has-image img.instant-preview-img,.scrubbar.scrubbar-for-skin-pro .scrubbar-box.has-image img.instant-preview-img{max-width:100%}.scrubbar.scrubbar-for-skin-default .scrubbar-box:before,.scrubbar.scrubbar-for-skin-pro .scrubbar-box:before{content:"";width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #444;position:absolute;left:50%;top:100%;margin-left:-6px}.scrubbar.scrubbar-for-skin-pro .scrubbar-prog,.scrubbar.scrubbar-for-skin-pro .scrubbar-admark{background-color:#965b5b}.hd-btn.hd-btn-for-skin-default .hd-btn--options{width:60px;height:auto;background-color:#444;position:absolute;left:50%;margin-left:-30px;bottom:20px;transition-property:all;transition-duration:.3s;-moz-transition-property:all;-moz-transition-duration:.3s;-webkit-transition-property:all;-webkit-transition-duration:.3s;-o-transition-property:all;-o-transition-duration:.3s;-ms-transition-property:all;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out;transform:scale(0);-webkit-transform:scale(0);-ms-transform:scale(0)}.hd-btn.hd-btn-for-skin-default .hd-btn--options:before{content:"";position:absolute;width:100%;height:10px;top:100%;left:0}.hd-btn.hd-btn-for-skin-default .hd-btn--options:after{content:"";position:absolute;top:100%;left:50%;margin-left:-7px;width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-top:6px solid #444}.hd-btn.hd-btn-for-skin-default ul.hd-options{list-style:none;margin:5px 0;padding:0}.hd-btn.hd-btn-for-skin-default ul.hd-options li{display:block;text-align:center;color:#999}.hd-btn.hd-btn-for-skin-default ul.hd-options li.active{color:#e4c000}.hd-btn.hd-btn-for-skin-default.ready:hover .hd-btn--options{transform:scale(1);-webkit-transform:scale(1);-ms-transform:scale(1)}a.download-btn{line-height:1.7}.download-btn.download-btn-for-skin-default{display:inline-block}.download-btn.download-btn-for-skin-default .download-btn--sidenote{width:160px;height:auto;background-color:#444;position:absolute;left:50%;margin-left:-80px;bottom:20px;padding:10px;color:#999;text-align:center;font-size:12px;transition-property:all;transition-duration:.3s;-moz-transition-property:all;-moz-transition-duration:.3s;-webkit-transition-property:all;-webkit-transition-duration:.3s;-o-transition-property:all;-o-transition-duration:.3s;-ms-transition-property:all;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out;transform:scale(0);-webkit-transform:scale(0);-ms-transform:scale(0)}.download-btn.download-btn-for-skin-default .download-btn--sidenote:before{content:"";position:absolute;width:100%;height:10px;top:100%;left:0}.download-btn.download-btn-for-skin-default .download-btn--sidenote:after{content:"";position:absolute;top:100%;left:50%;margin-left:-7px;width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-top:6px solid #444}.download-btn.download-btn-for-skin-default:hover .download-btn--sidenote{transform:scale(1);-webkit-transform:scale(1);-ms-transform:scale(1)}.embed-btn.embed-btn-for-skin-default .embed-btn--sidenote{width:160px;height:auto;background-color:#444;position:absolute;left:50%;margin-left:-80px;bottom:20px;padding:10px;color:#999;text-align:center;font-size:12px;transition-property:all;transition-duration:.3s;-moz-transition-property:all;-moz-transition-duration:.3s;-webkit-transition-property:all;-webkit-transition-duration:.3s;-o-transition-property:all;-o-transition-duration:.3s;-ms-transition-property:all;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out;transform:scale(0);-webkit-transform:scale(0);-ms-transform:scale(0)}.embed-btn.embed-btn-for-skin-default .embed-btn--sidenote textarea{width:100%;resize:none;background:transparent;border:1px solid rgba(255,255,255,0.1);color:#999;padding:10px}.embed-btn.embed-btn-for-skin-default .embed-btn--sidenote:before{content:"";position:absolute;width:100%;height:10px;top:100%;left:0}.embed-btn.embed-btn-for-skin-default .embed-btn--sidenote:after{content:"";position:absolute;top:100%;left:50%;margin-left:-7px;width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-top:6px solid #444}.embed-btn.embed-btn-for-skin-default:hover .embed-btn--sidenote{transform:scale(1);-webkit-transform:scale(1);-ms-transform:scale(1)}.social-btn.social-btn-for-skin-default ul.social-btn--options{display:none}.zoomvideoplayer.skin-pro .controls-bg{background-color:rgba(50,50,50,0.8)}.zoomvideoplayer.skin-pro .play-btn.play-btn-for-skin-pro .play-btn-fig{border-left-color:#eee!important}.zoomvideoplayer.skin-pro .play-btn.play-btn-for-skin-pro:hover .play-btn-fig{border-left-color:#965b5b!important}.zoomvideoplayer.skin-pro .curr-time-holder.curr-time-holder-for-skin-pro{color:#eee!important}.zoomvideoplayer.skin-pro .total-time-holder.total-time-holder-for-skin-pro{color:#eee!important}.zoomvideoplayer.skin-pro .pause-btn.pause-btn-for-skin-pro [class^="pause-btn-fig-"]{background-color:#eee!important}.zoomvideoplayer.skin-pro .pause-btn.pause-btn-for-skin-pro:hover [class^="pause-btn-fig-"]{background-color:#965b5b!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro .fullscreen-btn-fig-1,.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro .fullscreen-btn-fig-3{border-left-color:#eee!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro .fullscreen-btn-fig-2{border-right-color:#eee!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro .fullscreen-btn-fig-4{border-bottom-color:#eee!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro .fullscreen-btn-fig-circ{background-color:#eee!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro:hover .fullscreen-btn-fig-1,.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro:hover .fullscreen-btn-fig-3{border-left-color:#965b5b!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro:hover .fullscreen-btn-fig-2{border-right-color:#965b5b!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro:hover .fullscreen-btn-fig-4{border-bottom-color:#965b5b!important}.zoomvideoplayer.skin-pro .fullscreen-btn.fullscreen-btn-for-skin-pro:hover .fullscreen-btn-fig-circ{background-color:#965b5b!important}.zoomvideoplayer.skin-avanti .controls-bg{background-color:rgba(50,50,50,0.7)}.zoomvideoplayer.skin-avanti .play-btn.play-btn-for-skin-avanti path{fill:#D2D6DB}.zoomvideoplayer.skin-avanti .play-btn.play-btn-for-skin-avanti:hover path{fill:#59c8ef}.zoomvideoplayer.skin-avanti .pause-btn.pause-btn-for-skin-avanti:hover path{fill:#59c8ef}.zoomvideoplayer.skin-avanti .mute-btn.mute-btn-for-skin-avanti.active:hover path{fill:#59c8ef}.zoomvideoplayer.skin-avanti .unmute-btn.unmute-btn-for-skin-avanti:hover path{fill:#59c8ef}.zoomvideoplayer.skin-avanti .scrubbar.scrubbar-for-skin-pro .scrubbar-prog{background-color:#59c8ef}.zoomvideogallery{position:relative;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.zoomvideogallery *{-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.zoomvideogallery .media-con-clip{height:300px;overflow:hidden;position:relative}.zoomvideogallery .media-con-clip .media-con{position:absolute;left:0;top:0;width:100%;height:100%}.zoomvideogallery .media-con-clip .media-con .zoomvideoplayer{position:absolute;top:100%;left:0;opacity:0;visibility:hidden;transition-property:visibility,opacity;transition-duration:.3s;-moz-transition-property:visibility,opacity;-moz-transition-duration:.3s;-webkit-transition-property:visibility,opacity;-webkit-transition-duration:.3s;-o-transition-property:visibility,opacity;-o-transition-duration:.3s;-ms-transition-property:visibility,opacity;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideogallery .media-con-clip .media-con .zoomvideoplayer.active{opacity:1;visibility:visible;top:0}.zoomvideogallery .menu-con-clip{overflow:hidden}.zoomvideogallery .menu-con-clip .menu-con{position:relative}.zoomvideogallery .menu-con-clip .menu-con .gallery-menu-item{cursor:pointer}.zoomvideogallery .menu-con-clip .menu-con .gallery-menu-item:after{content:"";display:block;clear:both}.zoomvideogallery:after{content:"";display:block;clear:both}.zoomvideogallery.menu-right .menu-con-clip{max-height:100%;float:right}.zoomvideogallery.skin-default .gallery-menu-item{background-color:#332f2f;color:#EEE;padding:15px;transition-property:background;transition-duration:.3s;-moz-transition-property:background;-moz-transition-duration:.3s;-webkit-transition-property:background;-webkit-transition-duration:.3s;-o-transition-property:background;-o-transition-duration:.3s;-ms-transition-property:background;-ms-transition-duration:.3s;-ms-transition-timing-function:ease-out;-webkit-transition-timing-function:ease-out;-moz-transition-timing-function:ease-out;-o-transition-timing-function:ease-out;transition-timing-function:ease-out}.zoomvideogallery.skin-default .gallery-menu-item .menu-item-thumb{float:left;width:70px;height:70px;backround-size:cover;background-position:center center;margin-right:10px}.zoomvideogallery.skin-default .gallery-menu-item .menu-item-desc{overflow:hidden}.zoomvideogallery.skin-default .gallery-menu-item.active,.zoomvideogallery.skin-default .gallery-menu-item:hover{background-color:#443f3f}
/*# sourceMappingURL=zoomplayer.css.map */
</style>
