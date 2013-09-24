<?php echo $this->load->view('admin/header',array('selected'=>'places'));?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#checkall').click(function(){
			$(this).parents('form').find(':checkbox').attr('checked',this.checked);
		});
	});
</script>

<div id="content">

	<h2>Places</h2>
	
	<p>Shown below are the places you have created in the admin.</p>
	
	<div class="hspacer2"></div>
	
	<div class="box-940">
		<div class="box-940-header">
			<div class="box-940-header-arrow">
				<img src="/img/admin/box-header-arrow.png"/>
			</div>
			<div class="box-940-header-title">
				<p>Places</p>
			</div>
			<div class="box-940-header-state"></div>
		</div>
		<div class="box-940-content">
			<?php echo form_open('/admin/places/action');?>									
				<table class="data" cellpadding="0" cellspacing="0">
					<?php if ($places):?>
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
						<?php foreach($places as $place):?>
						<tr>
							<td><input id="place_<?php echo $place->id;?>" name="place_<?php echo $place->id;?>" value="<?php echo $place->id;?>" type="checkbox"/></td>
							<td><?php echo $place->id;?></td>
							<td><?php echo $place->name;?></td>
							<td><?php echo $place->latitude;?></td>
							<td><?php echo $place->longitude;?></td>
							<td>
								<?php if ($place->status == 1):?>
									<input type="button" value="Active" onclick="location.href='/index.php/admin/places/status/<?php echo $place->id;?>';"/>
								<?php else:?>
									<input type="button" value="Inactive" onclick="location.href='/index.php/admin/places/status/<?php echo $place->id;?>';"/>
								<?php endif;?>
							</td>
							<td><input type="button" value="Edit" onclick="location.href='/index.php/admin/places/edit/<?php echo $place->id;?>';"/>&nbsp;<input type="button" value="Delete" onclick="location.href='/index.php/admin/places/delete/<?php echo $place->id;?>';"/></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					<?php else:?>
					<tbody>
						<tr>
							<td colspan="7">You've not yet added any places</td>
						</tr>				
					</tbody>					
					<?php endif;?>
					<tfoot>
						<tr>
							<td colspan="7">
								<div class="pager">
									<div class="left">
										<select id="action" name="action">
											<option value="add">Add Place</option>
											<option value="activate">Activate Places</option>
											<option value="deactivate">Deactivate Places</option>
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