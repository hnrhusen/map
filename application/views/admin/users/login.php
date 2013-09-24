<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 

	<head>
		<title>GMap Admin</title>
		<style type="text/css">
			@import url('/css/admin/global.css');
			@import url('/css/admin/boxes.css');
		</style>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>

	<body>
	
		<div id="outer">

			<div id="inner">

				<div class="box-280-login">
					<div class="box-280-login-header">
						<div class="box-280-login-header-arrow">
							<img src="/img/admin/box-header-arrow.png"/>
						</div>
						<div class="box-280-login-header-title">
							<p>Login</p>
						</div>
						<div class="box-280-login-header-state"></div>
					</div>
					<div class="box-280-login-content">
					
						<?php if (validation_errors()): ?>
							<div class="errors">
								<p><strong>The following errors have occurred...</strong></p>
								<?php echo validation_errors(); ?>
							</div>
						<?php endif;?>
						
						<?php echo form_open(current_url());?>
						
						<div class="row">
							<div class="label"><?php echo form_label('Username', 'username');?></div>
							<div class="field"><?php echo form_input('username');?></div>
						</div>
						
						<div class="hspacer"></div>
						
						<div class="row">
							<div class="label"><?php echo form_label('Password', 'password');?></div>
							<div class="field"><?php echo form_password('password');?></div>
						</div>
						
						<div class="hspacer"></div>
						
						<div class="row">
							<div class="label">&nbsp;</div>
							<div class="field"><?php echo form_submit('submit', 'Login');?></div>
						</div>
						
						<?php echo form_close();?>					
					
					</div>
				
				</div>

			</div>

		</div>

	</body>

</html>
