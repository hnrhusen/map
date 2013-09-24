<?php echo $this->load->view('admin/header',array('selected'=>'points'));?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#checkall').click(function(){
			$(this).parents('form').find(':checkbox').attr('checked',this.checked);
		});
	});
</script>

<div id="content">

	<h2>Points</h2>

	<p>Shown below are the geographic points you have created in the admin.</p>

	<div class="hspacer2"></div>

	<div class="box-940">
		<div class="box-940-header">
			<div class="box-940-header-arrow">
				<img src="/img/admin/box-header-arrow.png"/>
			</div>
			<div class="box-940-header-title">
				<p>Points</p>
			</div>
			<div class="box-940-header-state"></div>
		</div>
		<div class="box-940-content">
			<?php echo form_open('/admin/points/action');?>									
				<table class="data" cellpadding="0" cellspacing="0">
					<?php if ($points):?>
					<thead>
						<tr>
							<th width="5%"><input id="checkall" name="checkall" type="checkbox"/></th>
							<th width="5%">ID</th>
							<th width="20%">Name</th>
							<th width="15%">Latitude</th>
							<th width="15%">Longitude</th>							
							<th width="10%">Status</th>
							<th width="30%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($points as $point):?>
						<tr>
							<td><input id="point_<?php echo $point->id;?>" name="point_<?php echo $point->id;?>" value="<?php echo $point->id;?>" type="checkbox"/></td>
							<td><?php echo $point->id;?></td>
							<td><?php echo $point->name;?></td>
							<td><?php echo $point->latitude;?></td>
							<td><?php echo $point->longitude;?></td>
							<td>
								<?php if ($point->status == 1):?>
									<input type="button" value="Active" onclick="location.href='/index.php/admin/points/status/<?php echo $point->id;?>';"/>
								<?php else:?>
									<input type="button" value="Inactive" onclick="location.href='/index.php/admin/points/status/<?php echo $point->id;?>';"/>
								<?php endif;?>
							</td>
							<td><input type="button" value="Edit" onclick="location.href='/index.php/admin/points/edit/<?php echo $point->id;?>';"/>&nbsp;<input type="button" value="Delete" onclick="location.href='/index.php/admin/points/delete/<?php echo $point->id;?>';"/></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					<?php else:?>
					<tbody>
						<tr>
							<td colspan="7">You've not yet added any points</td>
						</tr>				
					</tbody>					
					<?php endif;?>
					
					<tfoot>
						<tr>
							<td colspan="7">
								<div class="pager">
									<div class="left">
										<select id="action" name="action">
											<option value="add">Add Point</option>
											<option value="activate">Activate Points</option>
											<option value="deactivate">Deactivate Points</option>
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