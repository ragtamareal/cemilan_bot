<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.tbl_alert').dataTable({
			"bJQueryUI" : true,
			"sPaginationType" : "full_numbers",
			"iDisplayLength": 50
		});
		
		$('#tab-chart a[href="#token"]').tab('show');
	}); 
</script>
<div class="col-md-9">
	<div class="content-dashboard">
		<h4>NOTIFICATION</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Notification</a>
			</li>
			<li class="active">
				List 
			</li>
		</ol>
		
		<ul class="nav nav-tabs" id="tab-chart">
		  <li class="active"><a href="#token" data-toggle="tab">Pengisian Token</a></li>
		  <li><a href="#limit" data-toggle="tab">Limit kWh</a></li>
		  <li><a href="#power" data-toggle="tab">Power Status</a></li>
		</ul>
		<br/><br/>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="token">
				<div class="wrap_table">
					<table cellpadding="0" cellspacing="0" border="0" class="display tbl_alert" id="example" aria-describedby="example_info">
					<thead>
						<tr role="row">
							<th>No.</th>
							<th>Meter ID</th>
							<th>Status</th>
							<th>Token Number</th>
							<th>Nilai Token</th>
							<th>Balance kWh</th>
							<th>Date</th> 
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
						$j=1;
						foreach($alert_token as $am){ ?>
						<tr class="even_gradeA odd" id="5">
							<td><?php echo $j; ?></td>
							<td><?php echo $am->no_meter; ?></td>
							<td><?php echo ($am->no_token == '00000000000000000000') ? 'Token Salah' : 'Token Benar'; ?></td>
							<td><?php echo $am->no_token; ?></td>
							<td><?php echo $am->nilai_token; ?></td>
							<td><?php echo $am->balance_kwh; ?></td>
							<td><?php echo $am->input_date; ?></td>
						</tr>
						<?php $j++;} ?>
					</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane fade" id="limit">
				<div class="wrap_table">
					<table cellpadding="0" cellspacing="0" border="0" class="display tbl_alert" id="example" aria-describedby="example_info">
					<thead>
						<tr role="row">
							<th>No.</th>
							<th>Meter ID</th>
							<th>Limit kWh</th>
							<th>Date</th> 
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
						$j=1;
						foreach($alert_limit as $am){ ?>
						<tr class="even_gradeA odd" id="5">
							<td><?php echo $j; ?></td>
							<td><?php echo $am->no_meter; ?></td>
							<td><?php echo ($am->alert_limit_balance == 0) ? 'Ok' : 'Critical' ; ?></td>
							<td><?php echo $am->input_date; ?></td>
						</tr>
						<?php $j++;} ?>
					</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane fade" id="power">
				<div class="wrap_table">
					<table cellpadding="0" cellspacing="0" border="0" class="display tbl_alert" id="example" aria-describedby="example_info">
					<thead>
						<tr role="row">
							<th>No.</th>
							<th>Meter ID</th>
							<th>Power Status</th>
							<th>Date</th> 
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
						$j=1;
						foreach($alert_power as $am){ ?>
						<tr class="even_gradeA odd" id="5">
							<td><?php echo $j; ?></td>
							<td><?php echo $am->no_meter; ?></td>
							<td><?php echo ($am->power_status == 0) ? 'Mati' : 'Hidup'; ?></td>
							<td><?php echo $am->input_date; ?></td>
						</tr>
						<?php $j++;} ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
