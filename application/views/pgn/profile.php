<div class="col-md-9">
	<div class="content-dashboard">
		<h4>Home <?php if($act_uti == 'pln'){echo 'PLN'; } elseif($act_uti == 'pgn'){echo 'PGN';} ?></h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home <?php if($act_uti == 'pln'){echo 'PLN'; } elseif($act_uti == 'pgn'){echo 'PGN';} ?></a>
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
					<label>Meter ID <br/>ID Customer</label>
					<p>
						<?php echo $main_meter; ?><br/><?php echo $id_pel; ?>
					</p>
					
				</div>
			</div>
			<div class="content-box">
				<div class="info-amr">
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Price</label>
						<p>
							<?php echo $meter_data[0]["voltage_r"]; ?>&nbsp;450.000 Rupiah
						</p>
					</div>
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Volume</label>
						<p>
							<?php echo $meter_data[0]["balance_kwh"]; ?>&nbsp;1000 m3
						</p>
					</div>
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Pressure</label>
						<p>
							&nbsp;10 kPa
							</p>
					</div>
					<div class="col-amr">
						<img src="<?php echo base_url().'assets/img/icon/ico-elc.png'; ?>" width="18">
						<label>Temperature</label>
						<p>
							<?php echo $total_usage[0]["jum_usage"]; ?>&nbsp;25 Celcius
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
		<br>
		<div class="col-md-12 widget">
			<div class="header-box">
				Latest Billing History
			</div>
			<div class="content-box">
				<div class="wrap_table">
					<table cellpadding="0" cellspacing="0" border="0" class="tab-reg">
						<thead>
							<tr role="row">
								<th>No</th>
								<th>Billing Number</th>
								<th>No Meter</th>
								<th>Due Date</th>
								<th>Status</th>
								<th>Created By</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr class="even_gradeA odd" id="5">
								<td class="">1</td>
								<td>231424141</td>
								<td class=" ">93000000132</td>
								<td class=" ">2013-12-17 20:59:06</td>
								<td class=" ">billing</td>
								<td class=" ">PGN Admin</td>
							</tr>
							<tr class="even_gradeA odd" id="5">
								<td class="">2</td>
								<td>231424141</td>
								<td class=" ">93000000132</td>
								<td class=" ">2013-11-17 20:59:06</td>
								<td class=" ">paid</td>
								<td class=" ">PGN Admin</td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>