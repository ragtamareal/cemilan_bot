<link href="http://localhost/contact/assets/css/style.css" rel="stylesheet" media="screen">
<style>
	span.informasi {
		display: none;
	}
	input:focus + span.informasi, textarea:focus + span.informasi {
		display: block;
	}
</style>

<!-- accordion -->
<script>
	$(function() {
		$(".accordion").accordion({
			heightStyle : "content",
			collapsible : true,
			active : false
		});
	}); 
</script>
<div class="page-content">
	<div class="row">
		<div class="col-md-8">
			<h3>FAQ</h3>
			<br>
			<p>
				Berikut pertanyaan yang sering ditanyakan dalam sistem Integrated Smart Metering. Bila ada pertanyaan lebih lanjut silahkan isi form di samping kanan.
			</p>
			<hr/>
			<h4>Tanya Jawab Umum</h4>
			<div class="accordion">
				<h3>Apakah yang dimaksud dengan Integrated Smart Metering (ISM)?</h3>
				<div>
					<p>
						Integrated Smart Metering (ISM) adalah layanan yang dikembangkan untuk memonitor dan mengontrol fasilitas meter publik utility (PLN, PGN, PDAM,  dll) secara terintegrasi yang dilakukan secara remote dari mana saja dan kapan saja dengan mempergunakan media/perangkat komunikasi agar proses monitoring dan controling tersebut berjalan secara efektif dan efisien.
					</p>
				</div>
				<h3>Fitur-fitur apa sajakah yang terdapat dalam layanan ISM?</h3>
				<div>
					<p>
						Fitur-fitur yang tertanam pada aplikasi Integrated Smart Metering (ISM) dikategorikan sebagi berikut :
					</p>
					<ol type="a">
						<li>
							Informing
							<ul>
								<li>
									Informasi pembacaan KWH meter.
								</li>
								<li>
									Informasi status dan notifikasi pengisian token.
								</li>
								<li>
									Informasi status tamper (bagi PLN).
								</li>
							</ul>
						</li>
						<li>
							Monitoring
							<ul>
								<li>
									Monitoring status konsumsi listrik.
								</li>
								<li>
									View usage characteristic.
								</li>
								<li>
									Monitoring distribusi token dan KWH Meter.
								</li>
							</ul>
						</li>
						<li>
							Controlling
							<ul>
								<li>
									Pengaturan threshold (batas bawah) kuota pemakaian listrik.
								</li>
								<li>
									Pengisian token secara online
								</li>
							</ul>
						</li>
					</ol>
					</p>
					<p>
						Kesemua fitur diatas dapat ditemukan pada aplikasi berbasis Web yang dapat diakses  oleh beberapa browser yang umum dipergunakan oleh pengguna seperti : Internet Explorer, Mozilla Firefox, Avant Browser dan lain-lain.
					</p>
					<img src="<?php echo base_url().'assets/img/static/faq1.png'; ?>" width="500px" style="margin:'auto auto'; display:'block'; ">
				</div>
				<h3>Apa manfaat yang didapat dengan mengimplementasikan ISM?</h3>
				<div>
					Melalui inovasi teknologi dan bisnis aplikasi ISM, manfaat yang akan didapat sebagai berikut :
					<ol type="a">
						<li>
							Revenue Assurance Management
							<ul>
								<li>
									mengendalikan pendapatan
								</li>
								<li>
									menambah pendapatan melalui  implementasi dynamic pricing
								</li>
								<li>
									mengurangi potensi fraud
								</li>
							</ul>
						</li>
						<li>
							Loss Monitoring
							<ul>
								<li>
									menghitung loss energy
								</li>
								<li>
									mendeteksi loss karena fraud
								</li>
								<li>
									Penggunaan abnormal
								</li>
							</ul>
						</li>
						<li>
							Asset Management System
						</li>
						<ul>
							<li>
								Management Meter
							</li>
							<li>
								Management Gardu
							</li>
							<li>
								Management Pelanggan
							</li>
						</ul>
						<li>
							Geographical Information System
						</li>
						<ul>
							<li>
								Mapping perangkat
							</li>
							<li>
								Mapping pelanggan
							</li>
							<li>
								Konfigurasi network
							</li>
						</ul>
						<li>
							Customer Relationship Management
						</li>
						<ul>
							<li>
								Profiling pelanggan
							</li>
							<li>
								Meningkatkan kemudahan dan kenyamanan pelanggan.
							</li>
							<li>
								Membantu fokus ke pelayanan
							</li>
						</ul>
						<li>
							Command Center
						</li>
						<ul>
							<li>
								Membantu penanganan gangguan
							</li>
							<li>
								Administrasi pasang baru
							</li>
							<li>
								Tindakan koreksi dan pencegahan
							</li>
						</ul>
						<li>
							Menyediakan integrasi layanan smart metering untuk keperluan monitoring dan controlling perangkat meter pelanggan melalui media komunikasi dalam single platform & multi device.
						</li>
						<li>
							Menciptakan fleksibilitas dalam pengelolaan infrastruktur public utility dan menciptakan operasional yang mudah dan hemat biaya bagi siapa saja, di mana saja, dengan menggunakan perangkat dimana saja, kapan saja.
						</li>
					</ol>
				</div>
				<h3>Ada kelas layanan?</h3>
				<div>
					<p>
						Jenis kelas layanan ISM adalah seperti dibawah ini:
					</p>
					<!-- tambahan CSS untuk table -->
					<style>
						td, th {
							text-align: center;
						}
						.alignleft {
							text-align: left;
						}
					</style>
					<h4>Basic</h4>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Feature</th>
								<th>450 Watt</th>
								<th>900 Watt</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>AMR</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Top Up</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Limit Kredit</td>
								<td></td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Alert</td>
								<td></td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Token History</td>
								<td></td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Billing History</td>
								<td></td>
								<td>&#10003;</td>
							</tr>
						</tbody>
					</table>

					<h4>Premium</h4>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Feature</th>
								<th>450 Watt</th>
								<th>900 Watt</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>AMR</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Top Up</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Limit Kredit</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Alert</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Token History</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Billing History</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>SMS</td>
								<td>&#10003;</td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>Email</td>
								<td></td>
								<td>&#10003;</td>
							</tr>
							<tr>
								<td>GIS</td>
								<td></td>
								<td>&#10003;</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h3>Bagaimana Skema Bisnisnya?</h3>
				<div>
					<p>
						Ada skema bisnis ISM, yaitu:
					</p>
					<ol>
						<li>
							<h4>Basic</h4>
						</li>
						<p>
							Layanan ISM dengan Skema Basic diperuntukkan bagi pelanggan PLN berbasis 450 Watt dan 900 Watt dengan mekanisme pembayaran secara prepaid. Untuk pembayaran prepaid dilakukan dengan via SMS atau melalui PPOB. Kelas layanan Basic yang dijual berlaku bagi semua kelas pelanggan PLN.
						</p>
						<li>
							<h4>Premium</h4>
						</li>
						<p>
							Layanan ISM dengan Skema Premium diperuntukkan bagi pelanggan PLN berbasis 1300 Watt dan 2200 Watt dengan mekanisme pembayaran secara prepaid. Untuk pembayaran prepaid dilakukan dengan via SMS atau melalui PPOB. Kelas layanan Premium yang dijual berlaku bagi semua kelas pelanggan PLN 450 Watt dan 900 Watt.
						</p>
						<li>
							<h4>Bundling Solution</h4>
						</li>
						<p>
							Layanan ISM dengan skema Bundling Solution diperuntukkan bagi Building Management yang menyediakan layanan solusi layanan metering dengan menggunakan ISM. Pada Bundling Solution, Kelas ISM yang dijual adalah kelas Basic dan Premium.
						</p>
				</div>

				<h3>Berapa harganya dan bagaimana sistem pembayarannya?</h3>
				<div>
					<p>
						Kerjasama layanan aplikasi ISM dengan detail sebagai berikut :
					</p>
					<ol>
						<li>
							Jenis paketisasi layanan yang disepakati para pihak adalah 2 paket utama yang dapat berkembang menyesuaikan kebutuhan pasar.
						</li>
						<li>
							Diferensiasi antar paket berdasarkan fitur dan kategori pelanggan PLN.
						</li>
						<li>
							Harga aplikasi kerjasama aplikasi ISM adalah sbb :
						</li>
						<table  class="table table-bordered table-hover">
							<thead>
								<th>No.</th>
								<th>Paket</th>
								<th>Tarif per User</th>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td class="alignleft">Basic</td>
									<td class="alignleft"></td>
								</tr>
								<tr>
									<td></td>
									<td class="alignleft">- Pelanggan 450 Watt</td>
									<td class="alignleft"></td>
								</tr>
								<tr>
									<td></td>
									<td class="alignleft">- Pelanggan 900 Watt</td>
									<td class="alignleft"></td>
								</tr>
								<tr>
									<td>2</td>
									<td class="alignleft">Premium</td>
									<td class="alignleft"></td>
								</tr>
								<tr>
									<td></td>
									<td class="alignleft">- Pelanggan 450 Watt</td>
									<td class="alignleft"></td>
								</tr>
								<tr>
									<td></td>
									<td class="alignleft">- Pelanggan 450 Watt</td>
									<td class="alignleft"></td>
								</tr>
							</tbody>
						</table>
				</div>

				<h3>Keunggulan dibandingkan dengan layanan sejenis?</h3>
				<div>
					<p>
						Keunggulan layanan ISM dibandingkan dengan layanan sejenis :
					</p>
					<ol type='a'>
						<li>
							Segment Enterprise
							<ul>
								<li>
									SCADA hanya untuk membaca meter saja (AMR)
								</li>
							</ul>
						</li>
						<li>
							Segment Consumer
							<ul>
								<li>
									belum tersedia
								</li>
							</ul>
						</li>
					</ol>
				</div>

				<h3>Proses Fullfillment?</h3>
				<div>
					<ol type='a'>
						<li>
							Cara Berlangganan
							<p>
								Calon pelanggan  menghubungi call center 123 PLN atau 147 TELKOM atau AM terkait untuk melakukan permintaan berlangganan atau registrasi.
							</p>
						</li>
						<li>
							Cara Trial
							<p>
								Untuk mendapatkan trial layanan, calon pelanggan dapat mengakses website <a href='http://180.250.80.173'>180.250.80.173</a> serta melakukan loggin dengan user name : ID Meter (default) dan Password yang diemal atau di SMS ke calon pengguna.
							</p>
						</li>
						<li>
							Contact Center
							<p>
								Dapat menghubungi Contact Center 147 atau email ke <a href="mailto:c4@telkom.co.id">c4@telkom.co.id</a>
							</p>
						</li>
						<li>
							Menghentikan Layanan
							<p>
								Dapat menghubungi call center 123 PLN atau 147 TELKOM atau AM terkait untuk melakukan permintaan penghentian berlangganan.
							</p>
						</li>
					</ol>
				</div>

			</div>
			<!-- accordion -->

			<br>
			<h4>Tanya Jawab mengenai Sistem</h4>
			<div class="accordion">
				<h3>Sistem seperti apa yang saya butuhkan untuk menjalankan ISM?</h3>
				<div>
					<ul>
						<li>
							OS : Windows 98, Windows ME, Windows 2000 atau Windows XP
						</li>
						<li>
							CPU : Pentium 4 2.0+ GHz
						</li>
						<li>
							RAM : 512 MB
						</li>
						<li>
							Hard disk : 20 MB
						</li>
						<li>
							Internet : 128 kbps
						</li>
						<li>
							Web browser : Internet Explorer, Mozilla Firefox, Avant Browser serta browser smartphone
						</li>
					</ul>
				</div>

				<h3>Perangkat seperti apa yang mampu dikoneksikan ISM?</h3>
				<div>
					<p>
						KWH Meter yang dilengkapi SIM Card GSM, yang terhubung dengan USSD Gateway Telkomsel.
						Note : SIM Card GSM yang terpasang di KWH Meter harus dipairing terlebih dahulu dengan KWH Meter dan SIM Card GSM harus dalam kondisi aktif agar layanan ISM tetap berjalan.
					</p>
				</div>

				<h3>Bagaimana jika saya mengganti SIM yang telah dipairing dengan SIM card yang lain?</h3>
				<div>
					<p>
						KWH Meter tidak bisa terhubung dengan ISM, SIM card harus dipairing dulu dengan KWH meter, agar layanan dapat berfungsi.
					</p>
				</div>

				<h3>Apakah akan ada masalah dengan layanan ISM jika mempergunakan SIM card selain dari Telkomsel?</h3>
				<div>
					KWH Meter tidak bisa terhubung dengan ISM, KWH Meter didisain khusus untuk SIM card keluaran Telkomsel, untuk itu SIM card dengan operator lain tidak dapat berfungsi.
				</div>

				<h3>Mengapa ISM tidak dapat diaktifkan?</h3>
				<div>
					<p>
						Masuk ke task manager dan pastikan hanya satu proses ISM yang berjalan.
						Jika tidak, segera tutup semua proses ISM yang berjalan lalu restart (aktifkan
						kembali) ISM Anda.
					</p>
				</div>
			</div><!-- accordion -->

			<br>
			<h4>Tanya Jawab mengenai <em>User Account</em></h4>
			<div class="accordion">
				<h3>Bagaimana jika saya lupa kata sandi saya?</h3>
				<div>
					<p>
						Klik link "Forgot Password" lalu masukkan alamat email Anda dan verification code, setelah kata sandi yang baru akan dikirimkan ke email Anda. Atau, kirimkan pesan melalui menu "Hubungi Kami".
					</p>
				</div>

				<h3>Bagaimana jika saya tidak dapat melakukan login?</h3>
				<div>
					<p>
						Cek kembali user ID dan kata sandi Anda. Kata sandi menggunakan case sensitive. Jika keduanya sudah benar dan masih belum dapat login, silahkan kirimkan pesan pada kami melalui menu "Hubungi Kami".
					</p>
				</div>

				<h3>Apakan saya dapat melakukan login dengan ISM ID berbeda di PC yang sama?</h3>
				<div>
					<p>
						Ya, selama ISM ID yang Anda gunakan telah terdaftar.
					</p>
				</div>
			</div>
			<!-- accordion -->
		</div>
		<!-- col-md-5 -->

		<div class="col-md-4">
			<h3>HUBUNGI KAMI</h3>
			<br>
			<p>
				Anda mempunyai pertanyaan lebih lanjut mengenai layanan kami? Silakan mengisi formulir di bawah ini.
			</p>
			<hr/>
			<?php if($warn != ''){ ?>
				<div class="alert alert-success"><?php echo $warn; ?></div>	
			<?php } ?>
			<form class="form-horizontal" role="form" method="post">
				<div class="wrap_div_form">
					<div class="form-group first-form-group">
						<label for="nama" class="col-lg-3 control-label">Nama</label>
						<div class="col-lg-9">
							<input type="text" class="form-control" id="nama" name="nama" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-lg-3 control-label">Email</label>
						<div class="col-lg-9">
							<input type="text" class="form-control" id="email" name="email" placeholder="">
							<span class="help-block informasi">pesan akan dibalas melalui alamat email yang Anda berikan</span>
						</div>
					</div>
					<div class="form-group">
						<label for="pesan" class="col-lg-3 control-label">Pesan</label>
						<div class="col-lg-9">
							<textarea class="form-control" id="pesan" name="pesan"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-4">
							<button type="submit" class="btn btn-default">
								Kirim
							</button>
						</div>
					</div>
				</div>
				<!-- wrap_div_form -->
			</form>
		</div>
		<!-- col-mod-4 -->

		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>
<!-- formulir berakhir di sini. -->