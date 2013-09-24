<?php echo $this->load->view('admin/header',array('selected'=>'users'));?>

<div id="content">

	<h2>Change Password</h2>

	<p>Change the user password by entering the information required below</p>

	<div class="hspacer2"></div>

	<div class="box-940">
		<?php echo form_open(current_url())?>
			<div class="box-940-header">
				<div class="box-940-header-arrow">
					<img src="/img/admin/box-header-arrow.png"/>
				</div>
				<div class="box-940-header-title">
					<p>Fill in the form below...</p>
				</div>
				<div class="box-940-header-state"></div>
			</div>
			<div class="box-940-content">

				<?php if (validation_errors()): ?>
					<div class="errors">
						<p><strong>The following errors have occurred...</strong></p>
						<?php echo validation_errors(); ?>
					</div>
				<?php endif;?>
				
				<div class="row">
					<div class="label">
						<label for="">Enter New Password:</label>
					</div>
				</div>
				<div class="row">
					<div class="field">
						<?php echo form_password('password');?>
					</div>
				</div>
				
				<div class="hspacer2"></div>
				
				<div class="row">
					<input type="submit" value="Change Password"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/users';" value="Cancel"/>
				</div>					
			</div>
		<?php echo form_close()?>
	</div>
	
</div>

<?php echo $this->load->view('admin/footer');?>