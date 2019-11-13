<div class="single-channel-page" id="content-wrapper">
	<div class="container-fluid pb-0">
		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-title">
							<h6>Live Stat</h6>
							<div class="pull-right">
								<select class="form-control" id="year">
									<option value="">Year</option>
									<?php for ($i=date('Y'); $i > date('Y',strtotime('-10 year')); $i--) { ?>
										<option value="<?= $i ?>"><?= $i ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<canvas id="bar_chart" height="150"></canvas>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="row">
					<div class="col-sm-12 mb-4">
						<div class="card text-white bg-success o-hidden h-100 border-none">
							<div class="card-body">
								<div class="card-body-icon">
									<i class="fas fa-fw fa-users"></i>
								</div>
								<div class="mr-5"><b><?= db_get_count_data('user_follow',array('follow_id'=>$this->session->userdata('id'))) ?></b> Followers</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 mb-4">
						<div class="card text-white bg-info o-hidden h-100 border-none">
							<div class="card-body">
								<div class="card-body-icon">
									<i class="fa fa-fw fa-user-plus"></i>
								</div>
								<div class="mr-5"><b><?= db_get_count_data('user_follow',array('user_id'=>$this->session->userdata('id'))) ?></b> Following</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 mb-4">
						<div class="card text-white bg-success o-hidden h-100 border-none">
							<div class="card-body">
								<div class="card-body-icon">
									<i class="fas fa-fw fa-list-alt"></i>
								</div>
								<div class="mr-5"><b><?= $subscribers ?></b> Subscribers</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="//chartjs.org/dist/2.7.3/Chart.js"></script>
	<script>
		var ctx = document.getElementById("bar_chart");

		var dataFirst = {
			label: "Followers",
			borderColor: 'rgba(233, 30, 99, 0.75)',
			backgroundColor: 'rgba(233, 30, 99, 0.3)',
			pointBorderColor: 'rgba(233, 30, 99, 0)',
			pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
			pointBorderWidth: 1,
			data: [],
		};

		var dataSecond = {
			label: "Subscibers",
			borderColor: 'rgba(0, 188, 212, 0.75)',
			backgroundColor: 'rgba(0, 188, 212, 0.3)',
			pointBorderColor: 'rgba(0, 188, 212, 0)',
			pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
			pointBorderWidth: 1,
			data: [],
		};

		var speedData = {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [dataFirst, dataSecond],
		};

		var chartOptions = {
			legend: {
				display: true,
				position: 'top',
				labels: {
					boxWidth: 80,
					fontColor: 'black'
				}
			}
		};

		var lineChart = new Chart(ctx, {
			type: 'line',
			data: speedData,
			options: chartOptions
		});

		$(document).on('change','#year',function (e) {
			var year = $(this).val();
			graphData(year);
		});

		$(document).ready(function() {
			graphData(<?= date('Y') ?>);
		});

		function graphData(year){
			$.ajax({
				url: '<?= BASE_URL ?>live_stat/graph_data/' + year,
				type: 'GET'
			})
			.done(function(res) {
				lineChart.data.datasets[0].data = res.followers_data;
				lineChart.data.datasets[1].data = res.subscribers_data;
				lineChart.update();
			})
			.fail(function() {
				$('.message').html('<div class="alert alert-danger">Error load data</div>');
				$('.message').fadeIn();
			})
			.always(function() {
			});
		}
	</script>