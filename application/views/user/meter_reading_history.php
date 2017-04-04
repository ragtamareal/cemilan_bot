<script src="<?php echo base_url() . 'assets/js/jquery-ui.js'; ?>"></script>
<link href="<?php echo base_url() . 'assets/js/bootstrap-select/bootstrap-select.css'; ?>" rel="stylesheet" media="screen">
<script src="<?php echo base_url() . 'assets/js/bootstrap-select/bootstrap-select.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/highchart/highcharts.js'); ?>"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$( "#sdate" ).datepicker({
			dateFormat : "yy-mm-dd"
		});
		$( "#edate" ).datepicker({
			dateFormat : "yy-mm-dd"
		});
		
		$('.selectpicker').selectpicker();

		
	}); 
</script>
<!-- SCRIPT SHOW FILTER TANGGAL------------------ -->
<script>  
	 $(document).ready(function(){
		$("#btn_filter_tgl").click(function () {
			$(".toggle-chart").slideUp();
			$(".toggle-filter").slideToggle();
		});
		
		$("#btn_chart").click(function () {
			$(".toggle-filter").slideUp();
			$(".toggle-chart").slideToggle();
		});
		
		$('#tab-chart a[href="#profile"]').tab('show');
		$('#tab-chart a[href="#messages"]').tab('show');
		$('#tab-chart a[href="#settings"]').tab('show');
		$('#tab-chart a[href="#home"]').tab('show');
		
		
		//start highchart 
		// var categories = jQuery.parseJSON('<?php //echo json_encode($fakultas,JSON_NUMERIC_CHECK); ?>');
        // var	voltage_r = jQuery.parseJSON('<?php //echo json_encode($minat,JSON_NUMERIC_CHECK); ?>');
        // var	voltage_s = jQuery.parseJSON('<?php //echo json_encode($terima,JSON_NUMERIC_CHECK); ?>');
		// var	voltage_t = jQuery.parseJSON('<?php //echo json_encode($daftarulang,JSON_NUMERIC_CHECK); ?>');
		
		
		
		var categories = <?php echo $categories; ?>;
		var bal = <?php echo $bal; ?>;
		var totalU = <?php echo $total; ?>;
		var	voltage_r = <?php echo $voltage_r; ?>;
        var	voltage_s = <?php echo $voltage_s; ?>;
		var	voltage_t = <?php echo $voltage_t; ?>;
		var	arus_r = <?php echo $arus_r; ?>;
        var	arus_s = <?php echo $arus_s; ?>;
		var	arus_t = <?php echo $arus_t; ?>;
            
        $('#balance').highcharts({
            chart: {
                type: 'line',
                spacingTop: 10,
                spacingBottom: 10
            },
            title: {
                text: 'Balance'
            },
			xAxis: {
                categories: categories,
				title: {
					text: 'time'
				},
				labels:
				{
				  enabled: false
				}
            },
            yAxis: {
                title: {
                    text: 'Balance (kWh)'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: 'black',
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            series: [{
                name: 'Balance',
                data: bal
            }]
        }).highcharts(); // return chart
        
        $('#total').highcharts({
            chart: {
                type: 'line',
                spacingTop: 10,
                spacingBottom: 10
            },
            title: {
                text: 'Total Usage'
            },
			xAxis: {
                categories: categories,
				title: {
					text: 'time'
				},
				labels:
				{
				  enabled: false
				}
            },
            yAxis: {
                title: {
                    text: 'Total Usage'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: 'black',
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            series: [{
                name: 'Total Usage (kWh)',
                data: totalU
            }]
        }).highcharts(); // return chart
        
        $('#arus').highcharts({
            chart: {
                type: 'line',
                spacingTop: 10,
                spacingBottom: 10
            },
            title: {
                text: 'Arus'
            },
			xAxis: {
                categories: categories,
				title: {
					text: 'time'
				},
				labels:
				{
				  enabled: false
				}
            },
            yAxis: {
                title: {
                    text: 'Arus'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: 'black',
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            series: [{
                name: 'Arus_r',
                data: arus_r
            },{
            	name: 'Arus_s',
            	data: arus_s
            },{
            	name: 'Arus_t',
            	data: arus_t
            }]
        }).highcharts(); // return chart
        
        $('#voltage').highcharts({
            chart: {
                type: 'line',
                spacingTop: 10,
                spacingBottom: 10
            },
            title: {
                text: 'Voltage'
            },
			xAxis: {
                categories: categories,
				title: {
					text: 'time'
				},
				labels:
				{
				  enabled: false
				}
            },
            yAxis: {
                title: {
                    text: 'Voltage'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: 'black',
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            series: [{
                name: 'Voltage_r',
                data: voltage_r
            },{
            	name: 'Voltage_s',
            	data: voltage_s
            },{
            	name: 'Voltage_t',
            	data: voltage_t
            }]
        }).highcharts(); // return chart
	});	
		
		
			 
</script>
<!-- END SCRIPT SHOW FILTER TANGGAL ------------------ -->
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
				Usage History
			</li>
		</ol>
		<div class="content-wrap">
			<div class="form-horizontal">
				<form method="POST" action="">
				<div class="form-group first-form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">Meter ID</label>
					<div class="col-lg-4">
						<select class=" form-control col-lg-2" name="id_meter">
							<option value="">-- Choose Meter --</option>
							<?php foreach($all_meter as $am){ ?>
							<option value="<?php echo $am->no_meter; ?>" <?php if($am->no_meter == $met) echo "selected='selected'"; ?>><?php echo $am->no_meter.' a/n '.$am->firstname.' '.$am->lastname; ?></option>
							<?php } ?>
						</select>
					</div>
					<?php if (form_error('id_meter') != '') echo '<div class="error_label">'.form_error('id_meter').'</div>'; ?>
				</div>
				<div class="form-group first-form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">Start Date</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="sdate" name="sdate" placeholder="Choose Start Date" value="<?php echo $sdate; ?>">
					</div>
					<?php if (form_error('sdate') != '') echo '<div class="error_label">'.form_error('sdate').'</div>'; ?>
				</div>
				<div class="form-group first-form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">End Date</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="edate" name="edate" placeholder="Choose End Date" value="<?php echo $edate; ?>">
					</div>
					<?php if (form_error('edate') != '') echo '<div class="error_label">'.form_error('edate').'</div>'; ?>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button type="submit" class="btn btn-default">
							Submit
						</button>
						<?php if($v_tab){ ?>
						<button type="button" id="btn_chart"  class="btn btn-warning" href="#">Chart</button>
						<?php } ?>
						
					</div>
				</div>
				</form>
			</div>
			<?php if($v_tab){ ?>
			<br/>
			
			<div class="panel-inside toggle-chart">
				<ul class="nav nav-tabs" id="tab-chart">
				  <li class="active"><a href="#home" data-toggle="tab">Total Usage</a></li>
				  <li><a href="#profile" data-toggle="tab">Balance kWh</a></li>
				  <li><a href="#messages" data-toggle="tab">Power</a></li>
				  <li><a href="#settings" data-toggle="tab">Voltage</a></li>
				</ul>
				
				<div class="tab-content">
				  	<div class="tab-pane active" id="home">
				  		<div id="total" style="width: auto; height: 400px; margin: 10px 0 10px 0	"></div>
				  	</div>
					<div class="tab-pane" id="profile">
						<div id="balance" style="width: auto; height: 400px; margin: 10px 0 10px 0	"></div>
					</div>
					<div class="tab-pane" id="messages">
						<div id="arus" style="width: auto; height: 400px; margin: 10px 0 10px 0	"></div>
					</div>
					<div class="tab-pane" id="settings">
						<div id="voltage" style="width: auto; height: 400px; margin: 10px 0 10px 0	"></div>
					</div>
				</div>
			</div>
			<div class="wrap_table">
				<table cellpadding="0" cellspacing="0" border="0" class="display dataTable" id="example" aria-describedby="example_info">
					<thead>
						<tr role="row">
							<th style="width: 10px;">No</th>
							<th>Date</th>
							<th>Balance (kWh)</th>
							<th>Total Usage (kWh)</th>
							<th>Voltage R (Volt)</th>
							<th>Voltage S (Volt)</th>
							<th>Voltage T (Volt)</th>
							<th>Arus R (Ampere)</th>
							<th>Arus S (Ampere)</th>
							<th>Arus T (Ampere)</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php if($arr){
						$j=1;
							foreach($arr as $ar){?>	
						<tr class="even_gradeA odd">
							<td class=" "><?php echo $j; ?></td>
							<td class=" "><?php echo date("j M y H:i:s", strtotime($ar->timeStamp)); ?></td>
							<td class=" "><?php echo $ar->balanceKWH; ?></td>
							<td class=" "><?php echo $ar->totalUsage; ?></td>
							<td class=" "><?php echo $ar->voltageR; ?></td>
							<td class=" "><?php echo $ar->voltageS; ?></td>
							<td class=" "><?php echo $ar->voltageT; ?></td>
							<td class=" "><?php echo $ar->arusR; ?></td>
							<td class=" "><?php echo $ar->arusS; ?></td>
							<td class=" "><?php echo $ar->arusT; ?></td>
						</tr>
						<?php $j++;}}else echo 'Data Tidak Ada'; ?>

					</tbody>
				</table>
			</div>
			<?php } ?>
		</div>
	</div>
</div>