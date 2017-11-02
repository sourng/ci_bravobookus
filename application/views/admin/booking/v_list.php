<section role="main" class="content-body" style="margin-top: -30px;">
					<header class="page-header">
						<h2><i class="fa fa-home"></i> Advanced <?php echo $form_title;  ?></h2>

					<div class="right-wrapper pull-left">
							<ol class="breadcrumbs">
								<li>
									<a href="<?php echo site_url(); ?>dashboard.html">								
									</a>
								</li>								
								<div class="btn btn-default" style="margin-right:10px;">
									<a href="<?php echo site_url(); ?>add-hotels.html"> 
										<i class="fa fa-plus"></i>
										Add
									</a>
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
											<th>Booking Code</th>
											<th>Booking Date</th>
											<th>Guest Name</th>
											<th class="hidden-phone">Seats</th>
											<th class="hidden-phone">Options</th>
										</tr>
									</thead>
									<tbody>


										<?php 
										foreach ($v_ticket as $tk) {
											?>
											<tr class="gradeX">
											<td><?php echo $tk['booking_code']; ?></td>
											<td><?php echo $tk['booking_date']; ?></td>
											<td><?php echo $tk['title']." ".$tk['name']; ?></td>
											<td class="center hidden-phone"><?php echo $tk['seat_number']; ?></td>
											<td class="center hidden-phone">X</td>
										</tr>

											<?php
										}
										?>
										
									</tbody>
								</table>
							</div>
						</section>
						
						
					<!-- end: page -->
				</section>