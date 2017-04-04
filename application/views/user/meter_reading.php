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
		<div class="content-wrap"></div>
	  			
	</div>
</div>
