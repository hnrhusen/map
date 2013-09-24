<?php echo $this->load->view('admin/header',array('selected'=>'places'));?>

<div id="content">

	<h2>Thank You</h2>

	<p><?php echo $message;?></p>
	
	<div class="hspacer2"></div>

	<input type="button" onclick="location.href='/index.php/admin/places';" value="Return to Places"/>
	
</div>

<?php echo $this->load->view('admin/footer');?>