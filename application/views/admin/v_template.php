<!doctype html>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">	
		 <base href="<?php echo base_url(); ?>public/admin/">
		<?php 
		if(isset($head_login)){
			$this->load->view($head_login);
		}
		?>

	</head>
	<body>
		<!-- start: page -->
		<?php $this->load->view($main_content); ?>
		<!-- end: page -->
		<?php 
		if(isset($footer)){
			$this->load->view($footer);
		}
		?>
	</body>
</html>