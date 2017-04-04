<div class="page-content">
	<div class="col-md-12">
		<h4> ALREADY HAVE AN ACCOUNT ? </h4>
		<p>
			Anda sudah terdaftar sebelumnya? jika sudah silahkan login di form di bawah ini untuk masuk ke dashboard anda
		</p>
		<form class="form-horizontal" role="form" action="<?php echo site_url('home/login'); ?>" method="POST">
			<div class="wrap_div_form">
				<?php echo $warn; ?>
				<div class="form-group first-form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">Username</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="username" placeholder="username" name="username" value="<?php echo $username; ?>">
						<?php if (form_error('username') != '') echo '<div class="error_label">'.form_error('username').'</div>'; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail1" class="col-lg-2 control-label">Password</label>
					<div class="col-lg-4">
						<input type="password" class="form-control" id="password" placeholder="password" name="password" value="<?php echo $password; ?>">
						<?php if (form_error('password') != '') echo '<div class="error_label">'.form_error('password').'</div>'; ?>
					</div>
				</div>
				<div class="form-group">
				    <div class="col-lg-3 col-lg-offset-2">
				    	<p style="text-align:left;">Lupa password? <a href="<?php echo site_url('home/forgot_password'); ?>">klik disini</a></p>
				    </div>
			 	</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button type="submit" class="btn btn-default">
							Sign in
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>
</div>
