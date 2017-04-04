<script>
	$(document).ready(function() {
		// hide #back-top first
		$(".overlay").hide();
		$('#sub_meter').click(function() {

			var id_met = $('#meter').val();
		    
			if(id_met != ''){
				var dataString = 'meter='+ id_met;
				$(".overlay").show();
				
				$.ajax
				({
					type: "POST",
					url: "<?php echo site_url('user/reading_exe'); ?>",
					data: dataString,
					cache: false,
					success: function(html){
						$(".overlay").hide();
						$(".content-wrap").hide().html(html).fadeIn("slow");
					}
				});
			}else{
				alert('Anda belum memilih meter');
			}
		});

	}); 
</script>
<div class="overlay" id="dd">
	<div class="icon-loading"></div>
</div>
<div class="col-md-9">
	<div class="content-dashboard">
		<h4>USAGE MANAGEMENT</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Usage Management</a>
			</li>
			<li class="active">
				Realtime Meter Reading
			</li>
		</ol>
		<div class="form-horizontal">
		<div class="form-group first-form-group">
			<label for="inputEmail1" class="col-lg-2 control-label">METER READING</label>
			<div class="col-lg-4">
				<div class="col-lg-6">
					<input type="text" class="form-control" value="<?php echo $main_meter; ?>" name="id_meter" disabled />
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<button id="sub_meter" class="btn btn-default">
					Submit
				</button>
			</div>
		</div>
		</div>
		<br/>
		<div class="content-wrap">
			<!--<div class="col-md-8">
				<div class="col-md-6">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="2"><b>Stand Meter (+)</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>Kwh LWBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh WBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh LWBP 2</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>kVarh</td>
					  	<td>saa</td>
					  </tr>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="2"><b>Stand Meter (-)</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>Kwh LWBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh WBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh LWBP 2</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>kVarh</td>
					  	<td>saa</td>
					  </tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="2"><b>Daya Sesaat (-)</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>Kwh LWBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh WBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh LWBP 2</td>
					  	<td>saa</td>
					  </tr>
					 
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="2"><b>Daya Sesaat (+)</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>Kwh LWBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh WBP</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Kwh LWBP 2</td>
					  	<td>saa</td>
					  </tr>
					 
					</table>
				</div>
			</div>
			<div class="col-md-4">
				<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="2"><b>Meter Info</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>Meterseri</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Firmware</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>VT Rasio</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>CT Rasio</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Cosphi</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Frekuensi</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Tanggal Meter</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Jam Meter</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Durasi Operasi</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Durasi Baterai</td>
					  	<td>saa</td>
					  </tr>
					 
					</table>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="2"><b>Daya Sesaat (+)</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>kVa Max 1</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>kVa Max 2</td>
					  	<td>saa</td>
					  </tr>
					  <tr>
					  	<td>Terakhir Meter di program</td>
					  	<td>saa</td>
					  </tr>
					 
					</table>
			</div>
			<div class="clearfix"></div>-->
		</div>
	  				
	</div>
</div>
