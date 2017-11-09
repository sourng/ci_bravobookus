<section role="main" class="content-body">
	<header class="page-header">
		<h2>Advanced Forms</h2>					
		<div class="right-wrapper pull-right">
			<ol class="breadcrumbs">
				<li>
					<a href="index.html">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li><span>Forms</span></li>
				<li><span>Advanced</span></li>
			</ol>					
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
		</div>
	</header>
	<!-- start: page -->
	<div class="row">
		<div class="col-xs-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>	
					<h2 class="panel-title">Add New Vechicle</h2>
				</header>
				<div class="panel-body">
					<form class="form-horizontal form-bordered" action="<?php echo site_url(); ?>Admin_dashboard/new_hotel/create" method="post">
						<div class="form-group">
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
						<div class="form-group">
							<label class="col-md-3 control-label">Vechicle Code</label>
							<div class="col-md-6">
							<input type="text" name="vc_code" id="vc_code" class="form-control" value="" required="required">
							</div>
						</div>	
						<div class="form-group">
							<label class="col-md-3 control-label">Vechicle Name</label>
							<div class="col-md-6">
							<input type="text" name="vc_name" id="vc_name" class="form-control" value="" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Vechicle Type</label>
							<div class="col-md-6">
								<select data-plugin-selectTwo class="form-control populate" name="vc_type" >
									<optgroup label="Select one Company">
									<?php 
									foreach ($vehicle_type as $vc_type) {
									?>
									<option value='<?php echo $vc_type['id']; ?>'><?php echo $vc_type['vehicle_type']; ?></option>
									<?php
									}
									?>	
									</optgroup>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-md-3 control-label">Driver Name</label>
							<div class="col-md-6">
								<select data-plugin-selectTwo class="form-control populate" name="driver_name" >
									<optgroup label="Select one Company">
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
						<div class="form-group">
							<label class="col-md-3 control-label">Amennities</label>
							<div class="col-md-6">
								<select multiple data-plugin-selectTwo class="form-control populate" multiple="multiple" name="facilities[]">
									<optgroup label="Select Facilities">
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
						<div class="form-group">
							<label class="col-md-3 control-label">Status</label>
							<div class="col-md-6">
							     <div class="checkbox">
							      <input type="checkbox" name="gender" id="gender" data-toggle="toggle" data-on="Active" data-off="DisActive" data-onstyle="success" data-offstyle="danger" checked />
							    </div>
							    <input type="hidden" name="hidden_gender" id="hidden_gender" value="0" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Seat Type</label>
							<div class="col-md-6">
								<select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select a State", "allowClear": true }' name="seat_type" >
									<optgroup label="Select one Company">
									<?php 
									foreach ($seattypes as $seattype) {
									?>
									<option value='<?php echo $seattype['id']; ?>'><?php echo $seattype['seat_type']; ?></option>
									<?php
									}
									?>	
									</optgroup>
								</select>
							</div>
						</div>
						<div></div>
						<input type="submit" name="btnSave" class="btn btn-success" value="Save">						
					</form>
				</div>
			</section>
		</div>
	</div>
	<!-- end: page -->
</section>

