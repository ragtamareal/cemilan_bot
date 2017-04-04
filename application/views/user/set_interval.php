<div class="col-md-9">
	<div class="content-dashboard">
		<h4>SETTING</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li class="active">
				<a href="#">Set Interval</a>
			</li>

		</ol>
		<div class="content-wrap">
			<div class="col-md-8">
				<p>Interval meter <?php echo $main_meter; ?> now : <?php if($interval/3600000 >= 1) echo $interval/3600000 . ' hour'; else echo $interval/60000 . ' minutes'; ?> </p>
				<br/>
				<form class="form-horizontal" role="form" action="" method="post">
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Meter ID</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" value="<?php echo $main_meter; ?>" name="id_meter" disabled />
						</div>
					</div>
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Interval</label>
						<div class="col-lg-6">
							<select class=" form-control col-lg-4" name="interval">
								<option value="" >-- Choose Interval --</option>
								<option value="600" <?php if($interval/1000 == 600) echo "selected='selected'"; ?>>10 minutes</option>
								<option value="1200" <?php if($interval/1000 == 1200) echo "selected='selected'"; ?>>20 minutes</option>
								<option value="1800" <?php if($interval/1000 == 1800) echo "selected='selected'"; ?>>30 minutes</option>
								<option value="3600" <?php if($interval/1000 == 3600) echo "selected='selected'"; ?>>1 hour</option>
								<option value="10800" <?php if($interval/1000 == 10800) echo "selected='selected'"; ?>>3 hour</option>
								<option value="21600" <?php if($interval/1000 == 21600) echo "selected='selected'"; ?>>6 hour</option>
								<option value="43200" <?php if($interval/1000 == 43200) echo "selected='selected'"; ?>>12 hour</option>
								<option value="86400" <?php if($interval/1000 == 86400) echo "selected='selected'"; ?>>24 hour</option>
							</select>
							<?php if (form_error('interval') != '') echo '<div class="error_label">'.form_error('interval').'</div>'; ?>
						</div>
						
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