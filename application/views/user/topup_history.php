<link href="<?php echo base_url() . 'assets/js/bootstrap-select/bootstrap-select.css'; ?>" rel="stylesheet" media="screen">
<script src="<?php echo base_url() . 'assets/js/bootstrap-select/bootstrap-select.js'; ?>"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.selectpicker').selectpicker();

		$('.tbl_tophist').dataTable({
			"bJQueryUI" : true,
			"sPaginationType" : "full_numbers"
		});
		
		$("#met_list").change(function(){
			var id_met = $(this).val();
			var dataString = 'meter='+ id_met;
			//alert(dataString);
			
			$.ajax
			({
				type: "POST",
				url: "<?php echo site_url('user/tophistory_exe'); ?>",
				data: dataString,
				dataType: 'json',
				cache: false,
				success: function(restop){
					$("#top_his").html(restop.res);
					$("#jum_top").hide().html(restop.jum).fadeIn("slow");
					$("#paging").hide().html(restop.paging).fadeIn("slow");
				} 
			});
			
			 return false; 
		});
	}); 
</script>

<div class="col-md-9">
	<div class="content-dashboard">
		<h4>TOP UP MANAGEMENT</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Top Up Management</a>
			</li>
			<li class="active">
				History
			</li>
		</ol>
		<form class="form-horizontal" role="form" action="" method="get">
			<div class="form-group first-form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">SELECT METER</label>
				<div class="col-lg-4">
					<select class="form-control" name="id_meter">
						<?php foreach($all_meter as $am){ ?>
						<option value="<?php echo $am->no_meter; ?>" <?php if($am->no_meter == $meter_act) echo "selected='selected'"; ?>><?php echo $am->no_meter.' a/n '.$am->firstname.' '.$am->lastname; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-default">
						Submit
					</button>
				</div>
			</div>
		</form>
		<div class="content-wrap">
		<?php //date_default_timezone_set('America/Los_Angeles'); echo date_default_timezone_get().'------'.date('m/d/Y h:i:s a', time());; ?>
			<div class="wrap_table">
				<b>TOTAL TOPUP = <?php echo count($topup_hist); ?> topup</b>
				<br/>
				<br/>
				<table cellpadding="0" cellspacing="0" border="0" class="display tbl_tophist">
					<thead>
						<tr role="row">
							<th>Token Number</th>
							<th>Request Time</th>
							<th>Response Time</th>
							<th>Status</th>
							<th>Top Up By</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="top_his">
						<?php 
						if($topup_hist != 0){
						foreach($topup_hist as $th){ ?>
						<tr class="even_gradeA odd" id="5">
							<td><?php echo $th->TOKEN; ?></td>
							<td><?php echo $th->REQUEST_TIME; ?></td>
							<td><?php echo $th->RESPONSE_TIME; ?></td>
							<td>
								<?php 
								if($th->STATUS == 1){
									echo 'Topup Sukses'; 
								}elseif($th->STATUS == 2){
									echo 'Token Terpakai'; 
								}elseif($th->STATUS == 3){
									echo 'Salah Token'; 
								}elseif($th->STATUS == 4){
									echo 'Token Usang'; 
								}elseif($th->STATUS == 5){
									echo 'Komunikasi Error'; 
								}elseif($th->STATUS == 0){
									$now = strtotime(Date('Y-m-d H:i:s')); 
									$req = strtotime($th->REQUEST_TIME);
									$diff = $now - $req;
									if($diff/3600 < 24) echo 'Pending'; else echo 'Topup Gagal';//echo 'Topup Gagal';
								}
								?>
							</td>
							<td>sistem</td>
						</tr>
						<?php }
						}else{ ?>
							<tr class="even_gradeA odd" id="5">
								<td colspan="5">There is no data recorded</td>
							</tr>
						<?php }
						?>
					</tbody>
					
				</table>
				
			</div>
		</div>
	</div>
</div>