<?php echo $this->load->view('admin/header',array('selected'=>'users'));?>

<div id="content">

	<h2>Thank You</h2>

	<p><?php echo $message;?></p>
	
	<div class="hspacer2"></div>

	<input type="button" onclick="location.href='/index.php/admin/users';" value="Return to Users"/>
	
</div>


<?php echo $this->load->view('admin/footer');?>