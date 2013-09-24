<?php echo $this->load->view('admin/header',array('selected'=>'categories'));?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#checkall').click(function(){
			$(this).parents('form').find(':checkbox').attr('checked',this.checked);
		});
	});
</script>

<div id="content">

	<h2>Categories</h2>

	<p>Shown below are the categories you have created in the admin.</p>

	<div class="hspacer2"></div>

	<div class="box-940">
		<div class="box-940-header">
			<div class="box-940-header-arrow">
				<img src="/img/admin/box-header-arrow.png"/>
			</div>
			<div class="box-940-header-title">
				<p>Categories</p>
			</div>
			<div class="box-940-header-state"></div>
		</div>
		<div class="box-940-content">
			<?php echo form_open('/admin/categories/action');?>									
				<table class="data" cellpadding="0" cellspacing="0">
					<?php if ($categories):?>
						<thead>
							<tr>
								<th width="5%"><input id="checkall" name="checkall" type="checkbox"/></th>
								<th width="5%">ID</th>
								<th width="50%">Name</th>
								<th width="10%">Status</th>
								<th width="30%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($categories as $category):?>
							<tr>
								<td><input id="category_<?php echo $category->id;?>" name="category_<?php echo $category->id;?>" value="<?php echo $category->id;?>" type="checkbox"/></td>
								<td><?php echo $category->id;?></td>
								<td><?php echo $category->name;?></td>
								<td>
									<?php if ($category->status == 1):?>
										<input type="button" value="Active" onclick="location.href='/index.php/admin/categories/status/<?php echo $category->id;?>';"/>
									<?php else:?>
										<input type="button" value="Inactive" onclick="location.href='/index.php/admin/categories/status/<?php echo $category->id;?>';"/>
									<?php endif;?>
								</td>
								<td><input type="button" value="Edit" onclick="location.href='/index.php/admin/categories/edit/<?php echo $category->id;?>';"/>&nbsp;<input type="button" value="Delete" onclick="location.href='/index.php/admin/categories/delete/<?php echo $category->id;?>';"/></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					<?php else:?>
						<tbody>
							<tr>
								<td colspan="5">You've not yet added any categories</td>
							</tr>				
						</tbody>					
					<?php endif;?>					
					<tfoot>
						<tr>
							<td colspan="5">
								<div class="pager">
									<div class="left">
										<select id="action" name="action">
											<option value="add">Add Category</option>
											<option value="activate">Activate Categories</option>
											<option value="deactivate">Deactivate Categories</option>
										</select>
										<input type="submit" value="Apply"/>	
									</div>
									<div class="right">
										<?php echo $this->pagination->create_links(); ?>
									</div>
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