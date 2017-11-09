<section role="main" class="content-body" style="margin-top: -30px;">
	<header class="page-header">
		<h2><i class="fa fa-home"></i> Advanced <?php echo $form_title;  ?></h2>
		<div class="right-wrapper pull-left">
			<ol class="breadcrumbs">
				<li>
					<a href="<?php echo site_url(); ?>dashboard.html">								
					</a>
				</li>								
				<div class="btn btn-default" data-toggle="modal" data-target="#myModalAdd" style="margin-right:10px;"><i class="fa fa-plus"> Add</i>
<!-- 					<a href="<?php  $this->uri->segment(1); ?><?php echo site_url(); ?>add-vechicles.html"> 
						<i class="fa fa-plus"></i>
						Add
					</a> -->
				</div>
				<div class="btn btn-danger" style="margin-right:10px;">
					<a href="<?php echo site_url(); ?>removed-hotels.html"> 
						<i class="fa fa-trash-o" aria-hidden="true"></i>
						Removed
					</a>
				</div>
				<div class="btn btn-success"> <a href="<?php echo site_url(); ?>blocked-hotels.html"> 
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
						<th>Rendering engine</th>
						<th>Browser</th>
						<th>Platform(s)</th>
						<th class="hidden-phone">Engine version</th>
						<th class="hidden-phone">CSS grade</th>
					</tr>
				</thead>
				<tbody>
					<tr class="gradeX">
						<td>Trident</td>
						<td>Internet
							Explorer 4.0
						</td>
						<td>Win 95+</td>
						<td class="center hidden-phone">4</td>
						<td class="center hidden-phone">X</td>
					</tr>
					<tr class="gradeC">
						<td>Trident</td>
						<td>Internet
							Explorer 5.0
						</td>
						<td>Win 95+</td>
						<td class="center hidden-phone">5</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeA">
						<td>Trident</td>
						<td>Internet
							Explorer 5.5
						</td>
						<td>Win 95+</td>
						<td class="center hidden-phone">5.5</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Trident</td>
						<td>Internet
							Explorer 6
						</td>
						<td>Win 98+</td>
						<td class="center hidden-phone">6</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Trident</td>
						<td>Internet Explorer 7</td>
						<td>Win XP SP2+</td>
						<td class="center hidden-phone">7</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Trident</td>
						<td>AOL browser (AOL desktop)</td>
						<td>Win XP</td>
						<td class="center hidden-phone">6</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 1.0</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center hidden-phone">1.7</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 1.5</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 2.0</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 3.0</td>
						<td>Win 2k+ / OSX.3+</td>
						<td class="center hidden-phone">1.9</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Camino 1.0</td>
						<td>OSX.2+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Camino 1.5</td>
						<td>OSX.3+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Netscape 7.2</td>
						<td>Win 95+ / Mac OS 8.6-9.2</td>
						<td class="center hidden-phone">1.7</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Netscape Browser 8</td>
						<td>Win 98SE+</td>
						<td class="center hidden-phone">1.7</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Netscape Navigator 9</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.0</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.1</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1.1</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.2</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1.2</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.3</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1.3</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.4</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1.4</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.5</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1.5</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.6</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">1.6</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.7</td>
						<td>Win 98+ / OSX.1+</td>
						<td class="center hidden-phone">1.7</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.8</td>
						<td>Win 98+ / OSX.1+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Seamonkey 1.1</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Epiphany 2.20</td>
						<td>Gnome</td>
						<td class="center hidden-phone">1.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>Safari 1.2</td>
						<td>OSX.3</td>
						<td class="center hidden-phone">125.5</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>Safari 1.3</td>
						<td>OSX.3</td>
						<td class="center hidden-phone">312.8</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>Safari 2.0</td>
						<td>OSX.4+</td>
						<td class="center hidden-phone">419.3</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>Safari 3.0</td>
						<td>OSX.4+</td>
						<td class="center hidden-phone">522.1</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>OmniWeb 5.5</td>
						<td>OSX.4+</td>
						<td class="center hidden-phone">420</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>iPod Touch / iPhone</td>
						<td>iPod</td>
						<td class="center hidden-phone">420.1</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Webkit</td>
						<td>S60</td>
						<td>S60</td>
						<td class="center hidden-phone">413</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 7.0</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 7.5</td>
						<td>Win 95+ / OSX.2+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 8.0</td>
						<td>Win 95+ / OSX.2+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 8.5</td>
						<td>Win 95+ / OSX.2+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 9.0</td>
						<td>Win 95+ / OSX.3+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 9.2</td>
						<td>Win 88+ / OSX.3+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera 9.5</td>
						<td>Win 88+ / OSX.3+</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Opera for Wii</td>
						<td>Wii</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Nokia N800</td>
						<td>N800</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>Presto</td>
						<td>Nintendo DS browser</td>
						<td>Nintendo DS</td>
						<td class="center hidden-phone">8.5</td>
						<td class="center hidden-phone">C/A<sup>1</sup></td>
					</tr>
					<tr class="gradeC">
						<td>KHTML</td>
						<td>Konqureror 3.1</td>
						<td>KDE 3.1</td>
						<td class="center hidden-phone">3.1</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeA">
						<td>KHTML</td>
						<td>Konqureror 3.3</td>
						<td>KDE 3.3</td>
						<td class="center hidden-phone">3.3</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeA">
						<td>KHTML</td>
						<td>Konqureror 3.5</td>
						<td>KDE 3.5</td>
						<td class="center hidden-phone">3.5</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeX">
						<td>Tasman</td>
						<td>Internet Explorer 4.5</td>
						<td>Mac OS 8-9</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">X</td>
					</tr>
					<tr class="gradeC">
						<td>Tasman</td>
						<td>Internet Explorer 5.1</td>
						<td>Mac OS 7.6-9</td>
						<td class="center hidden-phone">1</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeC">
						<td>Tasman</td>
						<td>Internet Explorer 5.2</td>
						<td>Mac OS 8-X</td>
						<td class="center hidden-phone">1</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeA">
						<td>Misc</td>
						<td>NetFront 3.1</td>
						<td>Embedded devices</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeA">
						<td>Misc</td>
						<td>NetFront 3.4</td>
						<td>Embedded devices</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">A</td>
					</tr>
					<tr class="gradeX">
						<td>Misc</td>
						<td>Dillo 0.8</td>
						<td>Embedded devices</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">X</td>
					</tr>
					<tr class="gradeX">
						<td>Misc</td>
						<td>Links</td>
						<td>Text only</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">X</td>
					</tr>
					<tr class="gradeX">
						<td>Misc</td>
						<td>Lynx</td>
						<td>Text only</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">X</td>
					</tr>
					<tr class="gradeC">
						<td>Misc</td>
						<td>IE Mobile</td>
						<td>Windows Mobile 6</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeC">
						<td>Misc</td>
						<td>PSP browser</td>
						<td>PSP</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">C</td>
					</tr>
					<tr class="gradeU">
						<td>Other browsers</td>
						<td>All others</td>
						<td>-</td>
						<td class="center hidden-phone">-</td>
						<td class="center hidden-phone">U</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>						
			<!-- end: page -->
</section>

<!-- Modal Add Category -->
<div class="modal fade" id="myModalAdd" role="dialog">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Add New Vechicle</h4>
    </div>
    <div class="modal-body">
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
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
