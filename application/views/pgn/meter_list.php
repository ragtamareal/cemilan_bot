<!-- FANCYBOX --------------------------------------------->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/fancybox/jquery.fancybox.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/fancybox/jquery.fancybox.pack.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/fancybox/jquery.mousewheel-3.0.6.pack.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/js/fancybox/jquery.fancybox.css'; ?>" />

<script type="text/javascript">
	$(document).ready(function() {
		$(".btnconf_hapus").each(function() {
	 	var id = this.id;
	 	var arr = id.split('-');
	 	var a = document.getElementById('link_del'); //or grab it by tagname etc
		a.href = "del_meter/"+arr[0]+"/"+arr[1];
	 	var content = $("#modal_remove").html();
	 	$(this).fancybox({
	 			'title'		: false,
		 		'closeBtn' : false,
				'padding' : 0,
				'content' : content,
				 afterLoad   : function() {
			       this.content = this.content;
			    }
			});
		});
	}); 
</script>
<div class="col-md-9">
	<div class="content-dashboard">
		<h4>ADD & VIEW METER</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Add & View Meter</a>
			</li>
			<li class="active">
				List
			</li>
		</ol>
		<form class="form-horizontal" role="form" action="" method="post">
			<div class="form-group first-form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">ADD METER</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="inputEmail1" placeholder="Meter ID" name="id_meter">
					<?php if (form_error('id_meter') != '') echo '<div class="error_label">'.form_error('id_meter').'</div>'; ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-default">
						Submit
					</button>
				</div>
			</div>
		</form>
		<br/>
		<?php echo $warn; ?>
		<div class="wrap_table">
			<div class="tab-reg-head">
				<input type="search" placeholder="Search here" >
			</div>
            <table cellpadding="0" cellspacing="0" border="0" class="tab-reg">
            <thead>
                <tr role="row">
                <th>No.</th>
                <th>No Meter</th>
                <th>Nama</th>
                <th>No HP</th> 
                <th>Alamat</th> 
               	<th>Email</th> 
                <th>Tanggal Input</th> 
                <th>Aksi</th> 
                </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            	<?php 
            	$j=1;
            	foreach($all_meter as $am){ ?>
                <tr class="even_gradeA odd" id="5">
                	<td><?php echo $j; ?></td>
                    <td><?php echo $am->no_meter; ?></td>
                    <td><?php echo $am->firstname.' '.$am->lastname; ?></td>
                    <td><?php echo $am->no_hp; ?></td>
                    <td><?php echo $am->address; ?></td>
                    <td><?php echo $am->email; ?></td>
                    <td><?php echo $am->map_date; ?></td>
                   	<td class=" ">
                   		<?php if($am->no_meter != $main_meter){ ?>
                   			<a class="btnconf_hapus" href="#modal_remove" id="<?php echo $mem_id.'-'.$am->no_meter; ?>" title="Remove"><img src="<?php echo base_url() . 'assets/img/icon/ico_cross.png'; ?>" width="16"></a>
                   		<?php } ?>
					</td>
                </tr>
                <?php $j++;} ?>
            </tbody>
            </table>
            <div class="wrap_pagination">
                <ul class="pagination">
				  <li><a href="#">&laquo;</a></li>
				  <li><a href="#">1</a></li>
				  <li><a href="#">2</a></li>
				  <li><a href="#">3</a></li>
				  <li><a href="#">4</a></li>
				  <li><a href="#">5</a></li>
				  <li><a href="#">&raquo;</a></li>
				</ul>
            </div>
		</div>
		<!-- MODAL FANCYBOX ----------->
		<div style="display:none">
			<div id="modal_remove">
				<div class="wrap_modal">
					<h4 class="header_modal">DELETE <b>CONFIRMATION</b></h4>
					<div class="content_modal">
						<p>
							Apakah anda setuju akan menghapus data ini?
						</p>
						<div class="wrap_conf">
							<a class="cancel_button button_small" id="link_del">Setuju</a>
							<a class="no_button button_small" onclick="$.fancybox.close();">Tidak</a>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- END MODAL FANCYBOX ----------->
	</div>
</div>
