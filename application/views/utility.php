<div class="container">
	<div class="page-content">
		<div class="col-md-12 center-wrap">
			<h4>CHOOSE YOUR UTILITY</h4>
			<p>
				Pilih Jenis layanan smart meter berdasarkan layanan yang anda gunakan
			</p>

			<div class="box-layanan">
				<img src="<?php echo base_url() . 'assets/img/static/layanan-pln.png'; ?>" width="180px">
				<h4>PLN</h4>
				<p>
					Pilih ini untuk Manage Meter, Topup, Topup History, AMR
				</p>
				<a class="btn btn-default" href="<?php echo site_url('utility?access=pln'); ?>">Sign In as PLN Customer</a>
			</div>
			<div class="box-layanan">
				<img src="<?php echo base_url() . 'assets/img/static/layanan-pgn.png'; ?>" width="180px">
				<h4>PGN</h4>
				<p>
					Pilih ini untuk Cek Status Meter dan Cek Penggunaan Meter PGN Anda
				</p>
				<a class="btn btn-default" href="<?php echo site_url('utility?access=pgn'); ?>">Sign In as PGN Customer</a>
			</div>
		</div>

		<div class="clearfix"></div>
	</div>
</div>