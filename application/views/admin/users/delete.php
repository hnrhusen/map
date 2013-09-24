<?php echo $this->load->view('admin/header',array('selected'=>'users'));?>

<div id="content">

	<h2>Delete User</h2>
	
	<p>Confirm the deletion of the selected user by clicking the delete user button</p>

	<div class="hspacer2"></div>

	<?php echo form_open(current_url())?>

	<?php echo form_hidden('id',$user->id);?>

	<input type="submit" value="Delete User"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/users';" value="Cancel"/>

	<?php echo form_close()?>	
	
</div>

<?php echo $this->load->view('admin/footer');?>