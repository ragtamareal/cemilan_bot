<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $title . ' | Integrated Smart Metering'; ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- Bootstrap -->
	    <link href="<?php echo base_url() . 'assets/css/bootstrap.css'; ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url() . 'assets/css/style.css'; ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url() . 'assets/js/dataTables/demo_table_jui.css'; ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url() . 'assets/css/jquery-ui-1.10.3.custom.css'; ?>" rel="stylesheet" media="screen">
	    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="<?php echo base_url() . 'assets/js/html5shiv.js'; ?>"></script>
	      <script src="<?php echo base_url() . 'assets/js/respond.min.js'; ?>"></script>
	    <![endif]-->
	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="<?php echo base_url() . 'assets/js/jquery-1.10.2.js'; ?>"></script>
		<script src="<?php echo base_url() . 'assets/js/jquery-ui.js'; ?>"></script>
	    <script src="<?php echo base_url() . 'assets/js/dataTables/jquery.dataTables.js'; ?>"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="<?php echo base_url() . 'assets/js/bootstrap.min.js'; ?>"></script>
	    <script src="<?php echo base_url() . 'assets/js/chartjs/Chart.js'; ?>"></script>
	    <script src="<?php echo base_url() . 'assets/js/carousel.js'; ?>"></script>
	    <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('.carousel').carousel();
				
				$('.close-alert').click(function() {
					$(this).parent().fadeOut("slow");
				});
			});
		</script>
		<script>
			$(document).ready(function() {
				// hide #back-top first
				$('#back-top a').click(function() {
					$('body,html').animate({
						scrollTop : 0
					}, 800);
					return false;
				});

				// hide #back-top first
				$("#back-top").hide();

				// fade in #back-top
				$(function() {
					$(window).scroll(function() {
						if ($(this).scrollTop() > 100) {
							$('#back-top').fadeIn();
						} else {
							$('#back-top').fadeOut();
						}
					});

					// scroll body to 0px on click
					$('#back-top a').click(function() {
						$('body,html').animate({
							scrollTop : 0
						}, 800);
						return false;
					});
				});

			});
		</script>
	</head>
	<body id="top">
		<div class="bg_grey">
		  	<!-- NAV  ------------------------------------- -->
			<nav class="navbar navbar-default" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="container">
					<div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				    </button>
			    	<a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo base_url() . 'assets/img/static/ISM_BLACK.png'; ?>" width="140px"></a>
			  		</div>
					
					<div class="collapse navbar-collapse navbar-ex1-collapse">
			  		    <ul class="nav navbar-nav navbar-left">
					      <li <?php if ($content == 'index') echo 'class="active"'; ?>><a href="#">HOME</a></li>
					      <li><a href="#">OUR SERVICES</a></li>
					      <li><a href="#">ABOUT US</a></li>
					      <li><a href="<?php echo site_url('contact'); ?>">CONTACT US</a></li>
					      
					    </ul>
					    <ul class="nav navbar-nav navbar-right">
					    	<?php if(!$sess_act){ ?>
					      		<li <?php if ($content == 'login') echo 'class="active"'; ?>><a href="<?php echo site_url('home/login'); ?>">SIGN IN</a></li>
					      	<?php } else { ?>
								<?php if($service == 3){ ?>
									<li><a href="<?php echo site_url('utility'); ?>">CHOOSE SERVICES</a></li>
								<?php } ?>
								<?php if($act_uti == 'pln'){ ?>
									<li><a href="<?php echo site_url('user'); ?>">WELCOME, <?php echo $firstname . ' ' . $lastname; ?></a></li>
								<?php }elseif($act_uti == 'pgn'){ ?>
									<li><a href="<?php echo site_url('pgn'); ?>">WELCOME, <?php echo $firstname . ' ' . $lastname; ?></a></li>
								<?php } ?>
								<li><a href="<?php echo site_url('home/logout'); ?>">LOG OUT</a></li>
							<?php } ?>
					    </ul>
			    	</div><!-- /.navbar-collapse -->
			  	</div>
			</nav>
			<!-- END NAV  ------------------------------- -->

			<!-- SLIDER ------------------------------------- -->
			<?php if($content == 'index'){ ?>
			<div class="row">
				<div class="container">
					<div class="slider_banner">
				  		<div id="carousel-example-generic" class="carousel slide">
				  
				
				  <!-- Wrapper for slides -->
						  <div class="carousel-inner">
						    <div class="item active">
						      <img src="<?php echo base_url() . 'assets/img/static/ISM_03.png'; ?>" alt="sa">
						      
						    </div>
						     <div class="item">
						      <img src="<?php echo base_url() . 'assets/img/static/terios.jpg'; ?>" alt="sa">
						      
						    </div>
						  </div>
				
						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						    <span class="icon-prev"></span>
						  </a>
						  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						    <span class="icon-next"></span>
						  </a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	  	<!-- CONTENTTTT ------------------------------- -->
		<div class="container">
			<?php echo $this -> load -> view($content); ?>
		</div>
		<div class="red-bg">
	  		<div class="container red-register">
				<div class="col-lg-8 col-lg-offset-4 box-register-now">
					<h3>INTEGRATED SMART METERING</h3>
					<p>Integrated Smart Metering (ISM) adalah aplikasi yang dikembangkan untuk memonitor dan mengontrol fasilitas meter publik utility secara efektif dan efisien. ISM Menghadirkan berbagai layanan fitur yang bisa anda gunakan untuk mulai dari Automatic Meter Reading, Top up pulsa, Management pemakaian meter, Notifikasi, sampai dengan 
monitoring history penggunaan meter dari waktu ke waktu. Semua dalam satu portal online.</p>
					<br>  
				</div>
	  		</div>
	  	</div>
	  	<p id="back-top">
	  		<a href="#top"><span>back to top</span></a>
	  	</p>
		<footer>
			<div class="panel-footer">
				<div class="container">
					<ul class="nav navbar-nav navbar-left">
					  	<li class="active"><a href="#"><strong>HOME</strong></a></li>
					  	<li><a href="#"><strong>OUR SERVICES</strong></a></li>
					  	<li><a href="#"><strong>ABOUT US</strong></a></li>
					  	<li><a href="#"><strong>CONTACT US</strong></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="www.telkom.co.id"><b>PT Telekomunikasi Indonesia</b></a></li>
					</ul>
				</div>
			</div>
		</footer>
  
 		<script src="<?php echo base_url() . 'assets/js/nav.js'; ?>"></script>   
	</body>
</html>