<div class="col-md-9">
	<div class="content-dashboard">
		<h4>Home</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li class="active">
				User Profile
			</li>
		</ol>
		<div class="col-md-6 widget">
			<div class="header-box">
				Info Summary
			</div>
			<div class="col-amr user-amr">
				<img src="<?php echo base_url() . 'assets/img/static/user_pict.png'; ?>" width="60px">
				<div style="display:inline-block; vertical-align:middle; ">
					<span id="nama_pel">
						<?php echo $firstname . ' ' . $lastname; ?>
					</span>
					<br>
					<label>Meter ID<br/>ID Customer</label>
					<p>
						<?php echo $main_meter; ?><br/><?php echo $id_pel; ?>
					</p>
					
				</div>
			</div>
			<?php if($pel_type == 1){ ?>
			<div class="content-box">
				<div class="info-amr">
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Voltage</label>
						<p>
							<?php echo $meter_data[0]["VOLTAGE_R"]; ?>&nbsp;Volt
						</p>
					</div>
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Balance</label>
						<p>
							<?php echo $meter_data[0]["BALANCE_KWH"]; ?>&nbsp;kWh
						</p>
					</div>
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Top Up total count</label>
						<p>
							<?php echo count($topup_his); ?>
						</p>
					</div>
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Total Usage</label>
						<p>
							<?php echo round($total_usage[0]["jum_usage"],3); ?>&nbsp;kWh
						</p>
					</div>
				</div>
				<br>
				<!--<div class="alert alert-warning">
					Perhatian, <strong>Balance</strong> mendekati batas pemakaian
				</div>
				<div class="alert alert-danger">
					Perhatian, <strong>Balance</strong> mencapai batas pemakaian
				</div>-->

			</div>
			<?php } ?>
		</div>
		<div class="col-md-6 widget">
			<div class="header-box">
				Latest 7 Days Usage History
			</div>
			<div class="content-box home-widget-box">
				<canvas id="canvas" height="340" width="400"></canvas>
				<script>
					var barChartData = {
						labels : ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7"],
						datasets : [{
							fillColor : "rgba(220,220,220,0.5)",
							strokeColor : "rgba(220,220,220,1)",
							data : [65, 59, 66, 70, 56, 55, 35]
						}]

					}

					var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);

				</script>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php if($pel_type == 1){ ?>
		<br>
		<div class="col-md-12 widget">
			<div class="header-box">
				Latest Top Up History
			</div>
			<div class="content-box">
				<div class="wrap_table">
					<table cellpadding="0" cellspacing="0" border="0" class="tab-reg">
						<thead>
							<tr role="row">
								<th>No</th>
								<th>Token Number</th>
								<th>Meter ID</th>
								<th>Request Date</th>
								<th>Status</th>
								<th>Top Up By</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php 
							$j=1;
							foreach($topup_his_lim as $th){ ?>
							<tr class="even_gradeA odd" id="5">
								<td class=""><?php echo $j; ?></td>
								<td><?php echo $th->TOKEN; ?></td>
								<td class=" "><?php echo $th->METER_ID; ?></td>
								<td class=" "><?php echo $th->REQUEST_TIME; ?></td>
								<td class=" "><strong><i><?php echo $th->def; ?></i></strong></td>
								<td class=" "><strong><i><?php echo $firstname; ?></i></strong></td>
								
							</tr>
							<?php $j++;} ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<?php } ?>
		<div class="clearfix"></div>
	</div>
</div>