<div class="col-md-9">
	<div class="content-dashboard">
		<h4>REGISTER PREMIUM MEMBER</h4>
		<ol class="breadcrumb">
			<li>
				<a href="#">Home</a>
			</li>
			<li class="active">
				<a href="#">Register</a>
			</li>

		</ol>
		<div class="content-wrap">
			<div class="col-md-8">
				<form class="form-horizontal" role="form" action="" method="post">
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Service</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" value="PLN" name="utility" readonly="" />
						</div>
						
					</div>
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Meter ID</label>
						<div class="col-lg-6">
							<select class=" form-control col-lg-4" name="id_meter">
								<option value="">-- Choose Meter --</option>
								<?php foreach($all_meter as $am){ ?>
								<option value="<?php echo $am->no_meter; ?>" <?php if($am->no_meter == $met) echo "selected='selected'"; ?>><?php echo $am->no_meter.' a/n '.$am->firstname.' '.$am->lastname; ?></option>
								<?php } ?>
							</select>
							<?php if (form_error('id_meter') != '') echo '<div class="error_label">'.form_error('id_meter').'</div>'; ?>
						</div>
						
					</div>
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">ID Customer</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="id_pel" placeholder="ID Customer" value="<?php echo $id_pel; ?>">
							<?php if (form_error('id_pel') != '') echo '<div class="error_label">'.form_error('id_pel').'</div>'; ?>
						</div>
					</div>
					<div class="form-group first-form-group">
						<label for="inputEmail1" class="col-lg-4 control-label">Mobile Phone</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="no_hp" placeholder="Use +628xxxxxxxxx" value="<?php echo $no_hp; ?>">
							<?php if (form_error('no_hp') != '') echo '<div class="error_label">'.form_error('no_hp').'</div>'; ?>
						</div>
						<div class="clearfix"></div>
						
					</div>
					<div class="form-group first-form-group">

						<div class="col-lg-offset-4 col-md-8">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="term" value="1">
									I agree with <a data-toggle="modal" href="#myModal" class="btn-action">Terms & Condition</a> applied </label>
							</div>
							<?php if (form_error('term') != '') echo '<div class="error_label">'.form_error('term').'</div>'; ?>
						</div>
						
					</div>

					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-5">
							<button type="submit" id="loading" class="btn btn-default">
								Register Premium Member
							</button>
						</div>
					</div>

					<!-- Modal -->
					<div class="modal fade modal-loc" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									<h4 class="modal-title">Terms & Agreement</h4>
								</div>
								<div class="modal-body">
									<div class="terms">
										Naskah Lorem Ipsum standar yang digunakan sejak tahun 1500an

										"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."

										Bagian 1.10.32 dari "de Finibus Bonorum et Malorum", ditulis oleh Cicero pada tahun 45 sebelum masehi

										"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"

										Terjemahan tahun 1914 oleh H. Rackham

										"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"

										Bagian 1.10.33 dari "de Finibus Bonorum et Malorum", ditulis oleh Cicero pada tahun 45 sebelum masehi

										"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."
									</div>
								</div>

							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

				</form>
				<?php echo $warn; ?>
			</div>
			<div class="col-md-4">
				<div class="well">
					<ul class="info-premium">
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>AMR System</strong></h5>
								<p>
									Fitur untuk melakukan pembacaan data meter secara realtime 
								</p>
							</div>
						</li>
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>Alerting System</strong></h5>
								<p>
									Fitur untuk memberikan notifikasi kepada user baik berupa sms maupun email
								</p>
							</div>
						</li>
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>Top Up Management</strong></h5>
								<p>
									Fitur untuk melakukan pengisian ulang pulsa listrik
								</p>
							</div>
						</li>
						<li>
							<div class="ico-prem"><img src="<?php echo base_url() . 'assets/img/static/icon-meter.png'; ?>" width="40px">
							</div>
							<div class="info-desc">
								<h5><strong>Price</strong></h5>
								<p>
									Fitur untuk mengetahui harga yang harus dibayar berdasarkan data meter
								</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>