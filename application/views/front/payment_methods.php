<script src="https://www.paypal.com/sdk/js?client-id=AavmpVMHyaAyaTau3a1nfYqBHTML2R9F8iCRO3sztSIMr48w_aXoxTE1mfmnPpcAjd8dXZ6ZUzc1AFq8"></script>
<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid">
		<div class="video-block section-padding">
			<div class="row">
				<div class="col-md-12">
					<div class="main-title">
						<!--<h6>Payment For <strong><?= db_get_row_data('advertisement',array('id'=>$advt_id))->title ?></strong> </h6>-->
						<h6>Payment Methods</h6>
					</div>
					<hr>
				</div>
				<div class="col-md-4">
					<div id="paypal-button-container"></div>
				</div>
			</div>
		</div>
	</div>
<?php
$advt = db_get_row_data('advertisement',array('id'=>$advt_id));
if((isset($advt->price))&&!empty(isset($advt->price))){
	$price = $advt->price;
}else{
	$price = 0;
}
?>
	<script type="text/javascript">
		paypal.Buttons({
	  		createOrder: function(data, actions) {
	  			// Set up the transaction
	  			return actions.order.create({
	  				purchase_units: [{
	  					amount: {
	  						value: <?=  $price ?>
	  					}
	  				}]
	  			});
	  		},
	  		onApprove: function(data, actions) {
	  			// Capture the funds from the transaction
	  			return actions.order.capture().then(function(details) {
	  				// Show a success message to your buyer

	  				var txn_id 			=	details.id;
				    var payer_email 	=	details.payer.email_address;
				    var amountDetail 	=	details.purchase_units[0].amount;
				    var payment_status	=	details.status;
				    var data = {'txn_id':txn_id,'payer_email':payer_email,'amountDetail':amountDetail,'payment_status':payment_status};
				  
				    $.ajax({
				    	url: '<?= BASE_URL ?>orders/make_payment/<?= $advt_id ?>',
				    	type: 'GET',
				    	data: data
				    })
				    .done(function(res) {
				    	if (res.success) {
				    		$('.message').html(res.message);
				    		$('.message').fadeIn();
				    		window.location.replace(res.redirect);
				    	} else {
				    		$('.message').html(res.message);
				    		$('.message').fadeIn();
				    	}
				    })
				    .fail(function() {
				    	$('.message').html('<div class="alert alert-danger">Payment Success! But unable to update advertisement Status</div>');
				    	$('.message').fadeIn();
				    })
			        /*return fetch('/paypal-transaction-complete', {
			        	method: 'post',
			        	body: JSON.stringify({
			        		orderID: data.orderID
			        	})
			        });*/
			    });
			}

		}).render('#paypal-button-container');
	</script>