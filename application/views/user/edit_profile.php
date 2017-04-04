<div class="col-md-9">
	<div class="content-dashboard">
		<h4>SETTING</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Setting</a>
			</li>
			<li class="active">
				User Profile
			</li>
		</ol>
		<form class="form-horizontal" role="form" method="POST" action="">
			<h5><img src="<?php echo base_url() . 'assets/img/static/logo-simbol.png'; ?>">PROFILE INFO</h5>
			<br>
			<div class="form-group first-form-group">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">Username</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $uname	; ?>">
					<?php if (form_error('username') != '') echo '<div class="error_label">'.form_error('username').'</div>'; ?>
				</div>
				
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">Nama</label>
				<div class="col-lg-3">
					<input type="text" class="form-control" name="nama_dpn" placeholder="Nama Depan" value="<?php echo $firstname; ?>">
				</div>
				<div class="col-lg-3">
					<input type="text" class="form-control" name="nama_blk" placeholder="Nama Belakang" value="<?php echo $lastname; ?>">
				</div>
				<?php if (form_error('nama_dpn') != '') echo '<div class="error_label">'.form_error('nama_dpn').'</div>'; ?>
			</div>
			<div class="form-group ">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">Email</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>">
					<?php if (form_error('email') != '') echo '<div class="error_label">'.form_error('email').'</div>'; ?>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">Alamat</label>
				<div class="col-lg-6">
					<textarea class="form-control" rows="3" name="alamat"><?php echo $address; ?></textarea>
					<?php if (form_error('alamat') != '') echo '<div class="error_label">'.form_error('alamat').'</div>'; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-10">
					<input type="submit" class="btn btn-default" name="set_prof" value="Submit">
					
				</div>
			</div>
			<br>
			<h5><img src="<?php echo base_url() . 'assets/img/static/logo-simbol.png'; ?>">ACCOUNT PASSWORD</h5>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">Old Password</label>
				<div class="col-lg-4">
					<input type="password" class="form-control" id="inputEmail1" name="old_p" placeholder="Old Password">
					<?php if (form_error('old_p') != '') echo '<div class="error_label">'.form_error('old_p').'</div>'; ?>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">New Password</label>
				<div class="col-lg-4">
					<input type="password" class="form-control" id="inputEmail1" name="new_p" placeholder="New Password">
					<?php if (form_error('new_p') != '') echo '<div class="error_label">'.form_error('new_p').'</div>'; ?>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-lg-offset-1 control-label">Repeat Password</label>
				<div class="col-lg-4">
					<input type="password" class="form-control" id="inputEmail1" name="rep_p" placeholder="Repeat Password">
					<?php if (form_error('rep_p') != '') echo '<div class="error_label">'.form_error('rep_p').'</div>'; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-10">
					<input type="submit" class="btn btn-default" name="set_acc" value="Submit">
				</div>
			</div>
		</form>

	</div>
</div>