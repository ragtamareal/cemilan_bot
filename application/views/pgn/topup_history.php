<link href="<?php echo base_url() . 'assets/js/bootstrap-select/bootstrap-select.css'; ?>" rel="stylesheet" media="screen">
<script src="<?php echo base_url() . 'assets/js/bootstrap-select/bootstrap-select.js'; ?>"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.selectpicker').selectpicker();

		$('.dataTable').dataTable({
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
					$("#top_his").hide().html(restop.res).fadeIn("slow");
					$("#jum_top").hide().html(restop.jum).fadeIn("slow");
					$("#paging").hide().html(restop.paging).fadeIn("slow");
				},
				 error:function(xhr, status, errorThrown) {
		            alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
		        }, 
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
		<div class="content-wrap">
			<div class="wrap_table">
				<div class="tab-reg-head">

					<select class="selectpicker margin-zero" id="met_list">
						<?php foreach($all_meter as $am){ ?>
						<option value="<?php echo $am->no_meter; ?>"><?php echo $am->no_meter.' a/n '.$am->firstname.' '.$am->lastname; ?></option>
						<?php } ?>
					</select>
					TOTAL TOPUP = <span id="jum_top"><?php echo $jumlah; ?></span> topup
					<input type="search" placeholder="Search here" class="navbar-right" >
					<div class="clearfix"></div>
				</div>
				<table cellpadding="0" cellspacing="0" border="0" class="tab-reg">
					<thead>
						<tr role="row">
							<th>No Token</th>
							<th>Request Time</th>
							<th>Response Time</th>
							<th>Status</th>
							<th>Top Up By</th>
							<th>Tipe Top Up</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="top_his">
						<?php 
						if($jumlah != 0){
						foreach($topup_hist as $th){ ?>
						<tr class="even_gradeA odd" id="5">
							<td><?php echo $th->no_token; ?></td>
							<td><?php echo $th->reqtime; ?></td>
							<td><?php echo $th->restime; ?></td>
							<td>
								<?php 
								if($th->status == 1){
									echo 'Topup Sukses'; 
								}elseif($th->status == 2){
									echo 'Token Terpakai'; 
								}elseif($th->status == 3){
									echo 'Salah Token'; 
								}elseif($th->status == 4){
									echo 'Token Usang'; 
								}elseif($th->status == 5){
									echo 'Komunikasi Error'; 
								}elseif($th->status == 0){
									$now = strtotime(Date('Y-m-d H:i:s')); 
									$req = strtotime($th->reqtime);
									$diff = $now - $req;
									if($diff/3600 < 24) echo 'Pending'; else echo 'Topup Gagal';//echo 'Topup Gagal';
								}
								?>
							</td>
							<td><?php echo $th->firstname; ?></td>
							<td>
								<?php if($th->tipe == 0) echo 'Sistem'; ?>
							</td>
						</tr>
						<?php }
						}else{ ?>
							<tr class="even_gradeA odd" id="5">
								<td colspan="5">Data Tidak Tersedia</td>
							</tr>
						<?php }
						?>
					</tbody>
					
				</table>
				<div id="paging">
				<?php echo $link; ?>
				</div>
			</div>
		</div>
	</div>
</div>