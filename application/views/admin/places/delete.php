<?php echo $this->load->view('admin/header',array('selected'=>'places'));?>

<div id="content">
	
	<h2>Delete Place</h2>
	
	<p>Confirm the deletion of the selected place by clicking the delete place button</p>

	<div class="hspacer2"></div>

	<?php echo form_open(current_url())?>

	<?php echo form_hidden('id',$place->id);?>

	<input type="submit" value="Delete Place"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/places';" value="Cancel"/>

	<?php echo form_close()?>	
	
</div>

<?php echo $this->load->view('admin/footer');?>