<?php echo $this->load->view('admin/header',array('selected'=>'categories'));?>

<div id="content">

	<h2>Thank You</h2>

	<p><?php echo $message;?></p>
	
	<div class="hspacer2"></div>

	<input type="button" onclick="location.href='/index.php/admin/categories';" value="Return to Categories"/>
	
</div>


<?php echo $this->load->view('admin/footer');?>