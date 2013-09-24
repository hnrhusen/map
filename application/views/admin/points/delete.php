<?php echo $this->load->view('admin/header',array('selected'=>'points'));?>

<div id="content">
	
	<h2>Delete Point</h2>
	
	<p>Confirm the deletion of the selected point by clicking the delete point button</p>

	<div class="hspacer2"></div>

	<?php echo form_open(current_url())?>

	<?php echo form_hidden('id',$point->id);?>

	<input type="submit" value="Delete Point"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/points';" value="Cancel"/>

	<?php echo form_close()?>	
	
</div>

<?php echo $this->load->view('admin/footer');?>