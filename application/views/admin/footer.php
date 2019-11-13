</div></section>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click','.updatep',function() {
			var forme =$('.pd').find('select, textarea, input').serializeArray();
			var fd = new FormData();
			$.each( forme, function( i, field ) {
				fd.append(field.name, field.value);
			});
			fd.append('profile_image', $('.profile_image')[0].files[0]);
			fd.append('userimage_name', $('input[name="userimage_name"]').val());
			for(var pair of fd.entries()) {
				console.log(pair[0]+ ', '+ pair[1]);
			}
			$(this).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');

			$.ajax({
				type: "post",
				url:  "<?= base_url() ?>Auth/updateprofile",
				cache: false,
				contentType: false,
				processData: false,
				data: fd,

				success: function(data){
					$('.updatep').html('Update');
					if(data.success){
						var pimg = data.success.profile_image;
						$('.uimage').css({"background-image":"url(<?= base_url('upload/users/'); ?>"+pimg+")"});
						$('.ufname').html(data.success.full_name);

						$('.umsg').css({"color": "#4CAF50"});
						$('.umsg').html('Data Updated successfully');
					}
					else{
						$('.umsg').css({"color": "red"});
						$('.umsg').html('Error in Updation');
					}
				},
				error: function(){
					alert('Error while request..');
				}
			});
		});
	});
</script>
</body>
</html>
