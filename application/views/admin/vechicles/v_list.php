<section role="main" class="content-body" style="margin-top: -30px;">
	<header class="page-header">
		<h2><i class="fa fa-home"></i> Advanced <?php echo $form_title;  ?></h2>
		<div class="right-wrapper pull-left">
			<ol class="breadcrumbs">
				<li>
					<a href="<?php echo site_url(); ?>dashboard.html"></a>
				</li>								
				<button class="btn btn-primary" style="margin-right:10px;" onclick="add_vechicle()"><i class="glyphicon glyphicon-plus"></i> Add Vechicle</button>
				<div class="btn btn-danger" style="margin-right:10px;">
					<a href="<?php echo site_url(); ?>removed-vechicle.html"> 
						<i class="fa fa-trash-o" aria-hidden="true"></i>
						Removed
					</a>
				</div>
				<div class="btn btn-success"> <a href="<?php echo site_url(); ?>blocked-vechicle.html"> 
						<i class="fa fa-ban"></i>
						Blocked
					</a>
				</div>
			</ol>				
		</div>					
		<div class="right-wrapper pull-right">
			<ol class="breadcrumbs">
				<li>
					<a href="index.html">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li><span>Tables</span></li>
				<li><span>Advanced</span></li>
			</ol>					
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
		</div>
	</header>
			<!-- start: page -->						
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>						
			<h2 class="panel-title"><i class="fa fa-home"></i> <?php echo $form_title;  ?></h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
				<thead>
					<tr>
						<th style="width:10%;">#No</th>
						<th style="width:20%;">Comapny Name</th>
						<th style="width:10%;">Vechicle CODE</th>
						<th style="width:15%;">Vechicle Name</th>
						<th style="width:15%;" class="hidden-phone">Driver Name</th>
						<th style="width:15%;" class="hidden-phone">Amenities</th>
						<th style="width:15%;" class="hidden-phone">Tools</th>
					</tr>
				</thead>
				<tbody>										
					<?php 
					$i=1;
					foreach ($vechicles_list as $vch) {
						?>
						<tr class="gradeA">
						<td><?php echo $i; ?></td>
						<td ><?php echo $vch['company_name']; ?></td>
						<td><?php echo $vch['code']; ?></td>
						<td><?php echo $vch['vehicle_name']; ?></td>
						<td class="center hidden-phone"><?php echo $vch['drivers']; ?></td>
						<td class="center hidden-phone"><?php echo $vch['amenities']; ?></td>						
<!-- 						<td class="center hidden-phone">
							<a title="Edit <?php echo $vch['vehicle_name']; ?>" href="#<?php echo $vch['v_id']; ?>" class="btn btn-primary btn-xs" role="button">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

							<a data-toggle="modal" data-target="#myVechicleView<?php echo $vch['v_id']; ?>" title="View <?php echo $vch['vehicle_name']; ?>" href="#<?php echo $vch['v_id']; ?>" class="btn btn-success btn-xs" role="button">
							<i class="fa fa-eye" aria-hidden="true"></i></a>
							<a title="Block <?php echo $vch['vehicle_name']; ?>" href="#<?php echo $vch['v_id']; ?>" class="btn btn-warning btn-xs" role="button">
							<i class="fa fa-ban"></i></a>
						</td> -->
						<td class="center hidden-phone">
	    					<button class="btn btn-warning btn-xs" onclick="edit_vechicle(<?php echo $vch['v_id'];?>)"><i class="glyphicon glyphicon-pencil"></i></button>
	    					<button class="btn btn-danger btn-xs" onclick="delete_vechicle(<?php echo $vch['v_id'];?>)"><i class="glyphicon glyphicon-remove"></i></button> 							
						</td>
					</tr>
						<?php
						$i++;
					}

					?>
					
				</tbody>
			</table>
		</div>
	</section>						
			<!-- end: page -->
</section>

<!-- Modal Add Category -->
<div class="modal fade" id="VechicleAddModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<form  id="frm-vechicle" class="form-horizontal " action="<?php echo site_url(); ?>Admin_dashboard/new_hotel/create" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Vechicle</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" value="" name="v_id" id="v_id"/>
					<div class="form-group"> <!--Company Name-->
						<label class="col-md-3 control-label">Company Name</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate" name="company_id">
								<optgroup label="Select one Company">
								<?php 
									foreach ($companies as $company) {
										?>
										<option value='<?php echo $company['id']; ?>'><?php echo $company['company_name']; ?></option>
										<?php
									}
								?>	
								</optgroup>
							</select>
						</div>
					</div>	
					<div class="form-group"> <!--Vechicle Code-->
						<label class="col-md-3 control-label">Vechicle Code</label>
						<div class="col-md-6">
							<input type="text" name="code" id="code" class="form-control" value="" required="required">
						</div>
					</div>	
					<div class="form-group"> <!--Vechicle Name-->
						<label class="col-md-3 control-label">Vechicle Name</label>
						<div class="col-md-6">
							<input type="text" name="vehicle_name" id="vehicle_name" class="form-control" value="" required="required">
						</div>
					</div>
					<div class="form-group"> <!--Vechicle Type-->
						<label class="col-md-3 control-label">Vechicle Type</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate" name="vehicle_type" >
								<optgroup label="Select one Vechile Type">
								<?php 
									foreach ($vehicle_type as $vc_type) {
										?>
										<option value='<?php echo $vc_type['vt_id']; ?>'><?php echo $vc_type['vehicle_type']; ?></option>
										<?php
									}
								?>	
								</optgroup>
							</select>
						</div>
					</div>	
					<div class="form-group"> <!--Driver Name-->
						<label class="col-md-3 control-label">Driver Name</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate" name="drivers" >
								<optgroup label="Select one Driver Name">
								<?php 
									foreach ($driver_names as $driver_name) {
										?>
										<option value='<?php echo $driver_name['id']; ?>'><?php echo $driver_name['driver_name']; ?></option>
										<?php
									}
								?>	
								</optgroup>
							</select>
						</div>
					</div>				
					<div class="form-group"> <!--Choose Amennities-->
						<label class="col-md-3 control-label">Choose Amennities</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate" multiple="multiple" name="amenities[]" id="amenities">
								<optgroup label="Select Amenities">
								<?php 
									foreach ($facilities as $facil) {
										?>
										<option value='<?php echo $facil['facil_icon']; ?>'><?php echo $facil['facil_name']; ?></option>
										<?php
									}
								?>	
								</optgroup>
							</select>
						</div>
					</div>	
					<div class="form-group"> <!--Status-->
						<label class="col-md-3 control-label">Status</label>
						<div class="col-md-6">
							<div class="checkbox">
								<input type="checkbox" name="status" id="status" data-toggle="toggle" data-on="Active" data-off="DisActive" data-onstyle="success" data-offstyle="danger" checked />
							</div>
							<input type="hidden" name="hidden_status" id="hidden_status" value="1" />
						</div>
					</div>
					<div class="form-group"> <!--Seat Layout-->
						<label class="col-md-3 control-label">Seat Layout</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select a seats", "allowClear": true }' name="seats" >
								<optgroup label="Select one Seattype">
								<?php 
									foreach ($seattypes as $s_type) {
										?>
										<option value='<?php echo $s_type['seat_type_id']; ?>'><?php echo $s_type['seat_type']; ?></option>
										<?php
									}
								?>		
								</optgroup>
							</select>
						</div>
					</div>
					<div></div>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>      
			</div>
		</form>
	</div>
</div>
