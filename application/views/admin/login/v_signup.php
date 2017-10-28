		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<img src="assets/images/logo.png" height="54" alt="Porto Admin" />
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign Up</h2>
					</div>
					<div class="panel-body">
						<?php 
							if($this->session->userdata('message')){ 
							echo $this->session->userdata('message');
							 $this->session->set_userdata('message');
							}
						?>
						<form action="<?php echo site_url()?>admin/guest_register" id="validate" class="form" method="post">
							<div class="form-group mb-sm">
								<label>Name</label>
								<input name="name" type="text" class="form-control input-sm" />
							</div>

							<div class="form-group mb-sm">
								<label>E-mail Address</label>
								<input name="email" type="email" class="form-control input-sm" />
							</div>

							<div class="form-group mb-none">
								<div class="row">
									<div class="col-sm-6 mb-sm">
										<label>Password</label>
										<input name="pwd" type="password" class="form-control input-sm" />
									</div>
									<div class="col-sm-6 mb-sm">
										<label>Password Confirmation</label>
										<input name="pwd_confirm" type="password" class="form-control input-sm" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">
										<input id="AgreeTerms" name="agreeterms" type="checkbox"/>
										<label for="AgreeTerms">I agree with <a href="#">terms of use</a></label>
									</div>
								</div>
								<div class="col-sm-4 text-right">
									<button type="submit" class="btn btn-primary hidden-xs">Sign Up</button>
									<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign Up</button>
								</div>
							</div>

							<span class="mt-lg mb-lg line-thru text-center text-uppercase">
								<span>or</span>
							</span>

							<div class="mb-xs text-center">
								<a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
								<a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
							</div>

							<p class="text-center">Already have an account? <a href="<?php echo site_url(); ?>signin.html">Sign In!</a>

						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2014. All Rights Reserved.</p>
			</div>
		</section>