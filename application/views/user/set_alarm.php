<div class="col-md-9">
	<div class="content-dashboard">
		<h4>SETTING</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li class="active">
				<a href="#">Setting Alarm Notification</a>
			</li>

		</ol>
		<div class="content-wrap">
			<div class="col-md-8">
				<p>Alarm meter <?php echo $main_meter; ?> now : <?php echo $alarm; ?> kwh</p>
				<br/>
				<form class="form-horizontal" role="form" action="" method="post">
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Meter ID</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" value="<?php echo $main_meter; ?>" name="id_meter" disabled />
						</div>
					</div>
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Balance Limit</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" placeholder="Balance Limit" name="alarm" >
							<?php if (form_error('alarm') != '') echo '<div class="error_label">'.form_error('alarm').'</div>'; ?>
						</div>
						<div class="col-lg-2">
							kwh
						</div>
						<div class="clearfix"></div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-5">
							<button type="submit" id="loading" class="btn btn-default">
								Save
							</button>
						</div>
					</div>

				</form>
				<?php echo $warn; ?>
			</div>
			<div class="col-md-4">
				<div class="well">
					<ul class="info-premium">
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>AMR System</strong></h5>
								<p>
									Fitur untuk melakukan pembacaan data meter secara realtime 
								</p>
							</div>
						</li>
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>Alerting System</strong></h5>
								<p>
									Fitur untuk memberikan notifikasi kepada user baik berupa sms maupun email
								</p>
							</div>
						</li>
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>Top Up Management</strong></h5>
								<p>
									Fitur untuk melakukan pengisian ulang pulsa listrik
								</p>
							</div>
						</li>
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>Price</strong></h5>
								<p>
									Fitur untuk mengetahui harga yang harus dibayar berdasarkan data meter
								</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>