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
		<?php if($pel_type == 1){ ?>
		<div class="meter-count">
			<h5>your kWh now on <b><?php echo $main_meter; ?></b></h5>
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
				
			</ul>
		</div>
		<ul id="nav" >
			<li>
				<a href="<?php echo site_url('user'); ?>" <?php if($sub_content == 'user/profile') echo 'class="active"'; ?>><span class="glyphicon glyphicon-home"></span><span class="label_menu">Home</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/meter_list'); ?>" <?php if($sub_content == 'user/meter_list') echo 'class="active"'; ?>><span class="glyphicon glyphicon-barcode"></span><span class="label_menu">Add & View Metering</span></a>
			</li>
			<li>
				<a href="#" <?php if($sub_content == 'user/topup' || $sub_content == 'user/topup_history') echo 'class="active"'; ?>><span class="ico-glyph glyph-small"><img src="<?php echo base_url() . 'assets/img/icon/ico-topup.png'; ?>"></span><span class="label_menu">Topup Management</span><span class="glyphicon glyphicon-chevron-down" style="float:right;"></span></a>
				<ul class="sub_menu" <?php if($sub_content == 'user/topup' || $sub_content == 'user/topup_history') echo 'style="display:block"'; ?>>
					<li>
						<a href="<?php echo site_url('user/topup'); ?>"><span class="label_menu">Top Up</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('user/topup_history'); ?>"><span class="label_menu">Top Up History</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" <?php if($sub_content == 'user/meter_reading' || $sub_content == 'user/meter_reading_history') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Usage Management</span><span class="glyphicon glyphicon-chevron-down" style="float:right;"></span></a>
				<ul class="sub_menu" <?php if($sub_content == 'user/meter_reading' || $sub_content == 'user/meter_reading_history') echo 'style="display:block"'; ?>>

					<li>
						<a href="<?php echo site_url('user/meter_reading'); ?>">Realtime Meter Reading</a>
					</li>
					<li>
						<a href="<?php echo site_url('user/meter_usage'); ?>">Usage History </a>
					</li>

				</ul>
			</li>
			<li>
				<a href="<?php echo site_url('user/alert'); ?>" <?php if($sub_content == 'user/alert') echo 'class="active"'; ?>><span class="glyphicon glyphicon-bullhorn"></span><span class="label_menu">Notication</span></a>
			</li>
			<li>
				<a href="#" <?php if($sub_content == 'user/edit_profile' || $sub_content == 'user/set_interval' || $sub_content == 'user/set_alarm') echo 'class="active"'; ?>><span class="glyphicon glyphicon-cog"></span><span class="label_menu">Setting</span><span class="glyphicon glyphicon-chevron-down" style="float:right;"></span></a>
				<ul class="sub_menu" <?php if($sub_content == 'user/edit_profile' || $sub_content == 'user/set_interval' || $sub_content == 'user/set_alarm') echo 'style="display:block"'; ?>>

					<li>
						<a href="<?php echo site_url('user/edit_profile'); ?>">Edit Profile</a>
					</li>
					<li>
						<a href="<?php echo site_url('user/set_interval'); ?>">Set Time Interval</a>
					</li>
					<li>
						<a href="<?php echo site_url('user/set_alarm'); ?>">Set Limit Alarm</a>
					</li>
				</ul>
			</li>
		</ul>
		<?php }else{ ?>
		<div class="meter-count">
			<h5>Postpaid Menu</h5>
		</div>
		<ul id="nav" >
			<li>
				<a href="<?php echo site_url('user'); ?>" <?php if($sub_content == 'user/profile') echo 'class="active"'; ?>><span class="glyphicon glyphicon-home"></span><span class="label_menu">Home</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/meter_list'); ?>" <?php if($sub_content == 'user/meter_list') echo 'class="active"'; ?>><span class="glyphicon glyphicon-barcode"></span><span class="label_menu">Add & View Metering</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/instantaneous'); ?>" <?php if($sub_content == 'user/instantaneous') echo 'class="active"'; ?>><span class="ico-glyph glyph-small"><img src="<?php echo base_url() . 'assets/img/icon/ico-topup.png'; ?>"></span><span class="label_menu">Instantaneous</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/load_profile'); ?>" <?php if($sub_content == 'user/load_profile') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Load Profile</span></a>
			</li>
			<!--<li>
				<a href="<?php echo site_url('user/event_log'); ?>" <?php if($sub_content == 'user/event_log') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Event Log</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/billing'); ?>" <?php if($sub_content == 'user/billing') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Billing</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/alarm_post'); ?>" <?php if($sub_content == 'user/alarm_post') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Alarm</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/recall'); ?>" <?php if($sub_content == 'user/recall') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Recall Load Profile</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/time_sync'); ?>" <?php if($sub_content == 'user/time_sync') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Time Synchronizing</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/remote'); ?>" <?php if($sub_content == 'user/remote') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Remote Cut off/on</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('user/scada'); ?>" <?php if($sub_content == 'user/scada') echo 'class="active"'; ?>><span class="glyphicon glyphicon-stats"></span><span class="label_menu">Scada System</span></a>
			</li>
			<li>
				<a href="#" <?php if($sub_content == 'user/edit_profile' || $sub_content == 'user/set_interval' || $sub_content == 'user/set_alarm') echo 'class="active"'; ?>><span class="glyphicon glyphicon-cog"></span><span class="label_menu">Setting</span><span class="glyphicon glyphicon-chevron-down" style="float:right;"></span></a>
				<ul class="sub_menu" <?php if($sub_content == 'user/edit_profile' || $sub_content == 'user/set_interval' || $sub_content == 'user/set_alarm') echo 'style="display:block"'; ?>>

					<li>
						<a href="<?php echo site_url('user/edit_profile'); ?>">Edit Profile</a>
					</li>
					<li>
						<a href="<?php echo site_url('user/set_interval'); ?>">Set Time Interval</a>
					</li>
					<li>
						<a href="<?php echo site_url('user/set_alarm'); ?>">Set Limit Alarm</a>
					</li>
				</ul>
			</li>-->
		</ul>
		<?php } ?>
		<div class="promo-sidebar">
			<a href="<?php echo site_url('user/premium'); ?>"><img src="<?php echo base_url() . 'assets/img/static/promo.png'; ?>" width="100%"></a>
		</div>
	</div>
	<?php echo $this->load->view($sub_content); ?>
	

	<div class="clearfix"></div>
</div>