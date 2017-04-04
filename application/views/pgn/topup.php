<script>
	$(document).ready(function() {
		// hide #back-top first
		$(".overlay").hide();
		$('#sub_token').click(function() {
			var id_met = $('#meter').val();
		    var	token = $('#token_number').val();
			
			if(id_met != '' && token != '' && token.length == 20){
				var dataString = 'meter='+ id_met + '&token=' + token;
				$(".overlay").show();
				
				$.ajax
				({
					type: "POST",
					url: "<?php echo site_url('user/topup_exe'); ?>",
					data: dataString,
					cache: false,
					success: function(html){
						$(".overlay").hide();
						$(".content-wrap").hide().html(html).fadeIn("slow");
					}
				});
			}else{
				alert('token Anda tidak sesuai');
			}
		});

	}); 
</script>
<div class="overlay" id="dd">
	<div class="icon-loading"></div>
</div>
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
				New Top Up
			</li>
		</ol>
		<div class="content-wrap">
			<div class="form-horizontal">
				<div class="form-group first-form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">Meter ID</label>
					<div class="col-lg-4">
						<select class=" form-control col-lg-2" id="meter">
							<option value="">-- Pilih Meter --</option>
							<?php foreach($all_meter as $am){ ?>
							<option value="<?php echo $am->no_meter; ?>"><?php echo $am->no_meter.' a/n '.$am->firstname.' '.$am->lastname; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group first-form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">Token Number</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="token_number" placeholder="Token Number">
					</div>
				</div>
	
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button id="sub_token" class="btn btn-default">
							Submit
						</button>
					</div>
				</div>
			</div>				
		</div>
	</div>
</div>