<?php echo $this->load->view('admin/header',array('selected'=>'categories'));?>

<div id="content">
	
	<h2>Delete Category</h2>
	
	<p>Confirm the deletion of the selected category by clicking the delete category button</p>

	<div class="hspacer2"></div>

	<?php echo form_open(current_url())?>

	<?php echo form_hidden('id',$category->id);?>

	<input type="submit" value="Delete Category"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/categories';" value="Cancel"/>

	<?php echo form_close()?>				
	
</div>

<?php echo $this->load->view('admin/footer');?>