<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
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
					url: "<?php echo site_url('user/instantaneous_exe'); ?>",
					data: dataString,
					cache: false,
					success: function(html){
						$(".overlay").hide();
						$(".content-wrap").hide().html(html).fadeIn("slow");
					},
					error: function(html){
						$(".overlay").hide();
						//alert(html);
					}
				});
			}else{
				alert('Anda belum memilih meter');
			}
		});
		
		$('#phasor').highcharts({
	            
			chart: {
				polar: true
			},

			title: {
				text: 'Diagram Phasor'
			},
			pane: {
				startAngle: 90,
				endAngle: 450
			},
			xAxis: {
				min: 0,
				max: 360,
				lineWidth: 0,
				tickInterval: 120,
				labels: {enabled: true}
			}, 
			yAxis: {
				gridLineInterpolation: 'circle',
				lineWidth: 0,
				min: 0,
				max: 265,
				tickInterval: 265,
				labels: { enabled: true }
			},
			tooltip: {
				shared: true,
				pointFormat: '<span style=\"color:{series.color}\">{series.name}: <b>{point.y:,.0f}</b><br/>'
			},
			plotOptions: {
				series: {
				   grouping: true,
					groupPadding:0,
					pointPadding:0,
					borderColor: '#000',
					borderWidth: '0',
					stacking: 'normal',
					pointPlacement: 'on',
					showInLegend: true,

				},
				line:{
					marker: {
						enabled: false,
					}
				}
			},
			
			legend: {
				layout: 'horizontal'
			},
			
			series: [{
				name: 'VR',
				type: 'line',
				color: '#ff0000',
				lineWidth: 3,
				pointStart: -1,
				data: [0, 220]
			}, {
				name: 'IR',
				type: 'line',
				color: '#ff0000',
				lineWidth: 3,
				pointStart: 20,
				data: [0, 210]
			},{
			   name: 'VS',
				type: 'line',
				color: '#3000ff',
				lineWidth: 3,
				pointStart: 119,
				data: [0, 190]
			},{
				name: 'IS',
				type: 'line',
				color: '#3000ff',
				lineWidth: 3,
				pointStart: 150,
				data: [0, 201]
			}, {
				name: 'VT',
				type: 'line',
				color: '#33b50b',
				lineWidth: 3,
				pointStart: 239,
				data: [0, 199]
			},{
				name: 'IT',
				type: 'line',
				color: '#33b50b',
				lineWidth: 3,
				pointStart: 265,
				data: [0, 208]
			}]
		
		});
	}); 
</script>

<div class="overlay" id="dd">
	<div class="icon-loading"></div>
</div>
<div class="col-md-9">
	<div class="content-dashboard">
		<h4>POST PAID MANAGEMENT</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Load Profile</a>
			</li>
			<li class="active">
				Load Profile
			</li>
		</ol>
		<div class="form-horizontal">
		<div class="form-group first-form-group">
			<label for="inputEmail1" class="col-lg-2 control-label">METER READING</label>
			<div class="col-lg-4">
				<select class="form-control col-lg-2" id="meter">
					<option value="">-- Choose Meter --</option>
					<?php foreach($all_meter as $am){ ?>
					<option value="<?php echo $am->no_meter; ?>"><?php echo $am->no_meter.' a/n '.$am->firstname.' '.$am->lastname; ?></option>
					<?php } ?>
				</select>
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
			<div class="col-md-5">
				<div id="phasor" style="width: 322px; height: 400px; margin: 10px 0 10px 0	"></div>
					<table class="table table-striped tab-det-usage">
						<tr>
							<td class="head-det-usage" colspan="4"><b>Informasi Arus Saat Ini</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Arus (Amp)</td>
							<td>Sudut Arus</td>
						</tr>
						<tr>
							<td>Phase R</td>
							<td>100</td>
							<td>20.3</td>
						</tr>
						<tr>
							<td>Phase S</td>
							<td>100</td>
							<td>20.3</td>
						</tr>
						<tr>
							<td>Phase T</td>
							<td>100</td>
							<td>20.3</td>
						</tr>
					</table>
					
					<table class="table table-striped tab-det-usage">
						<tr>
							<td class="head-det-usage" colspan="3"><b>Informasi Arus Saat Ini</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Arus (Amp)</td>
							<td>Sudut Arus</td>
						</tr>
						<tr>
							<td>Phase R</td>
							<td>100</td>
							<td>20.3</td>
						</tr>
						<tr>
							<td>Phase S</td>
							<td>100</td>
							<td>20.3</td>
						</tr>
						<tr>
							<td>Phase T</td>
							<td>100</td>
							<td>20.3</td>
						</tr>
					</table>
			</div>
			<div class="col-md-7">
				
				<table class="table table-striped tab-det-usage">
					<tr>
					  	<td class="head-det-usage" colspan="2"><b>Informasi Beban Saat Ini</b></td>
					</tr>
					<tr>
					  	<td>Beban Aktif (kW)</td>
					  	<td>R</td>
					</tr>
					<tr>
					  	<td>Beban Reaktif (kVAR)</td>
					  	<td>arus_r</td>
					</tr>
					<tr>
					 	<td>Power Faktor</td>
						<td>voltage_r</td>
					</tr>
					<tr>
					  	<td>Frekuensi (Hz)</td>
					  	<td></td>
					</tr>
				</table>
				<table class="table table-striped tab-det-usage">
					<tr>
					  	<td class="head-det-usage" colspan="4"><b>Informasi Max Demand</b></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Max kVA</td>
						<td>Max kW</td>
						<td>Max kVAR</td>
					</tr>
					<tr>
					  	<td>LWBP</td>
					  	<td>13.496</td>
						<td>12.122</td>
						<td>5.588</td>
					</tr>
					<tr>
					  	<td>Tgl & Jam</td>
					  	<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
					</tr>
					<tr>
					  	<td>WBP</td>
					  	<td>13.496</td>
						<td>12.122</td>
						<td>5.588</td>
					</tr>
					<tr>
					  	<td>Tgl & Jam</td>
					  	<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
					</tr>
					<tr>
					  	<td>Rate C</td>
					  	<td>13.496</td>
						<td>12.122</td>
						<td>5.588</td>
					</tr>
					<tr>
					  	<td>Tgl & Jam</td>
					  	<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
					</tr>
					<tr>
					  	<td>Total</td>
					  	<td>13.496</td>
						<td>12.122</td>
						<td>5.588</td>
					</tr>
					<tr>
					  	<td>Tgl & Jam</td>
					  	<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
						<td>04-Feb-2014 17:00:00</td>
					</tr>
				</table>
			</div>
			<div class="clearfix"></div>
		</div>
	  			
	</div>
</div>
