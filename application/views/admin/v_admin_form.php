<?php 
	//check user has login or not
	if($this->session->userdata('name')){
?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">
		<title>Bravobookus Admin</title>
		<meta name="keywords" content="Bravobookus Admin" />
		<meta name="description" content="Bravobookus Admin">
		<meta name="author" content="okler.net">

 		<base href="<?php echo base_url(); ?>public/admin/">

<?php 
	if(isset($head)){
		$this->load->view($head);
	}
?>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			
			<?php 
				if(isset($header)){
					$this->load->view($header);
				}
			?>

			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php 
					if(isset($sidebar)){
						$this->load->view($sidebar);
					}
				?>
				<!-- end: sidebar -->


					<!-- start: page -->

					
					<?php 

					if(isset($main_content)){
						$this->load->view($main_content);
					}else{
						echo "<h1>	No Page Yet ! </h1>";
					}

					?>		

					<!-- end: page -->
				
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<?php 
				if(isset($sidebar_right)){
						$this->load->view($sidebar_right);
					}

				?>
			</aside>
			
		</section>

<?php 
	if(isset($footer)){
		$this->load->view($footer);
	}

?>
	</body>
</html>

<?php
	if($this->session->userdata('message')){
?>
	<!--<script>						
        //$(document).ready(function(){
            setTimeout(hideNotificationMessage,3000);
            function hideNotificationMessage()
                $("#notification_message").trigger("click");
        //});
    </script>-->
<?php }?>
<?php 
}else{
	redirect(base_url().'admin', 'location', 302);
}
?>