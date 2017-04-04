<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.dataTable').dataTable({
			"bJQueryUI" : true,
			"sPaginationType" : "full_numbers"
		});
	}); 
</script>

<div class="page-content-b">
	<div class="col-md-3">
		<div class="meter-count">
			<h5>Volume Saat ini</h5>
			<ul class="counter">
				<li>
					<span><?php echo $balance_now[0]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[1]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[2]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[3]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[4]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[5]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[6]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[7]; ?></span>
				</li>
				<li>
					<span><?php echo $balance_now[8]; ?></span>
				</li>
			</ul>
		</div>
		<ul id="nav" >
			<li>
				<a href="<?php echo site_url('pgn'); ?>" <?php if($sub_content == 'pgn/profile') echo 'class="active"'; ?>><span class="glyphicon glyphicon-home"></span><span class="label_menu">Home</span></a>
			</li>
			<li>
				<a href="#" <?php if($sub_content == 'pgn/meter_reading' || $sub_content == 'pgn/meter_reading_history') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Usage Management</span><span class="glyphicon glyphicon-chevron-down" style="float:right;"></span></a>
				<ul class="sub_menu" <?php if($sub_content == 'pgn/meter_reading' || $sub_content == 'pgn/meter_reading_history') echo 'style="display:block"'; ?>>

					<li>
						<a href="<?php echo site_url('pgn/meter_reading'); ?>">Realtime Meter Reading</a>
					</li>
					<li>
						<a href="<?php echo site_url('pgn/meter_usage'); ?>">Usage History </a>
					</li>

				</ul>
			</li>
			<li>
				<a href="#" <?php if($sub_content == 'pgn/edit_profile' || $sub_content == 'pgn/set_interval' || $sub_content == 'pgn/set_alarm') echo 'class="active"'; ?>><span class="glyphicon glyphicon-cog"></span><span class="label_menu">Setting</span><span class="glyphicon glyphicon-chevron-down" style="float:right;"></span></a>
				<ul class="sub_menu" <?php if($sub_content == 'pgn/edit_profile' || $sub_content == 'pgn/set_interval' || $sub_content == 'pgn/set_alarm') echo 'style="display:block"'; ?>>

					<li>
						<a href="<?php echo site_url('pgn/edit_profile'); ?>">Edit Profile</a>
					</li>
					<li>
						<a href="<?php echo site_url('pgn/set_interval'); ?>">Set Time Interval</a>
					</li>
					<li>
						<a href="<?php echo site_url('pgn/set_alarm'); ?>">Set Limit Alarm</a>
					</li>
				</ul>
			</li>
		</ul>
		<div class="promo-sidebar">
			<a href="<?php echo site_url('pgn/premium'); ?>"><img src="<?php echo base_url() . 'assets/img/static/promo.png'; ?>"></a>
		</div>
	</div>
	<?php echo $this->load->view($sub_content); ?>
	

	<div class="clearfix"></div>
</div>