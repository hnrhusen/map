<?php echo $this->load->view('admin/header',array('selected'=>'users'));?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#checkall').click(function(){
			$(this).parents('form').find(':checkbox').attr('checked',this.checked);
		});
	});
</script>

<div id="content">

	<h2>Users</h2>

	<p>Shown below are the users you have created in the admin.</p>

	<div class="hspacer2"></div>

	<div class="box-940">
		<div class="box-940-header">
			<div class="box-940-header-arrow">
				<img src="/img/admin/box-header-arrow.png"/>
			</div>
			<div class="box-940-header-title">
				<p>Users</p>
			</div>
			<div class="box-940-header-state"></div>
		</div>
		<div class="box-940-content">
			<?php echo form_open('/admin/users/action');?>									
				<table class="data" cellpadding="0" cellspacing="0">
					<?php if ($users):?>
					<thead>
						<tr>
							<th width="5%"><input id="checkall" name="checkall" type="checkbox"/></th>
							<th width="5%">ID</th>
							<th width="50%">Username</th>
							<th width="10%">Status</th>
							<th width="30%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user):?>
						<tr>
							<td><input id="user_<?php echo $user->id;?>" name="user_<?php echo $user->id;?>" value="<?php echo $user->id;?>" type="checkbox"/></td>
							<td><?php echo $user->id;?></td>
							<td><?php echo $user->username;?></td>
							<td>
								<?php if ($user->status == 1):?>
									<input type="button" value="Active" onclick="location.href='/index.php/admin/users/status/<?php echo $user->id;?>';"/>
								<?php else:?>
									<input type="button" value="Inactive" onclick="location.href='/index.php/admin/users/status/<?php echo $user->id;?>';"/>
								<?php endif;?>
							</td>
							<td><input type="button" value="Edit" onclick="location.href='/index.php/admin/users/edit/<?php echo $user->id;?>';"/>&nbsp;<input type="button" value="Password" onclick="location.href='/index.php/admin/users/password/<?php echo $user->id;?>';"/>&nbsp;<input type="button" value="Delete" onclick="location.href='/index.php/admin/users/delete/<?php echo $user->id;?>';" <?php echo (count($users) == 1)?"disabled=\"disabled\"":"";?>"/></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					<?php else:?>
					<tbody>
						<tr>
							<td colspan="5">You've not yet added any users</td>
						</tr>				
					</tbody>					
					<?php endif;?>					
					<tfoot>
						<tr>
							<td colspan="5">
								<div class="pager">
									<div class="left">
										<select id="action" name="action">
											<option value="add">Add User</option>
											<option value="activate">Activate Users</option>
											<option value="deactivate">Deactivate Users</option>
										</select>
										<input type="submit" value="Apply"/>	
									</div>
									<div class="right">&nbsp;</div>
								</div>
							</td>
						</tr>
					</tfoot>								
				</table>
			<?php echo form_close();?>																	
		</div>
	</div>
</div>	

<?php echo $this->load->view('admin/footer');?>