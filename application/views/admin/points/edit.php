<?php echo $this->load->view('admin/header',array('selected'=>'points'));?>

<script type="text/javascript" src="/js/admin/gmap.js"></script>

<script type="text/javascript">
	$(document).ready(function(){	
		initialize(<?php echo $point->latitude;?>,<?php echo $point->longitude;?>);
	});
</script>

<div id="content">
	<?php echo form_open(current_url())?>
	<?php echo form_hidden('latitude',$point->latitude);?>
	<?php echo form_hidden('longitude',$point->longitude);?>
	
	<h2>Edit Point</h2>

	<p>Edit the selected point by updating the information required below</p>

	<div class="hspacer2"></div>
	
	<div class="box-940">

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
					<label for="">Enter Point Name:</label>
				</div>
			</div>
			<div class="row">
				<div class="field">
					<?php echo form_input('name',$point->name);?>
				</div>
			</div>
			
			<div class="hspacer2"></div>
			
			<div class="row">
				<div class="label">
					<label for="">Select Point Categories:</label>
				</div>
			</div>
			<div class="row">
				<div class="field">
					<select id="categories" name="categories[]" multiple="multiple">
						<?php foreach($categories as $category):?>
						<?php if (category_selected($selected,$category)):?>
						<option value="<?php echo $category->id;?>" selected="selected"><?php echo $category->name;?></option>
						<?php else:?>
						<option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>							
						<?php endif;?>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			
			<div class="hspacer2"></div>				
			
			<div class="row">
				<div class="label">
					<label for="">Enter Point Description:</label>
				</div>
			</div>
			<div class="row">
				<div class="field">
					<?php echo form_textarea('description',$point->description);?>
				</div>
			</div>	
							
			<div class="hspacer2"></div>
			
			<div id="map" style="width:898px;height:389px;border:solid 1px #ccc;"></div>
			
			<div class="hspacer2"></div>
			
			<div class="row">
				<div class="label">
					<label for="">Select Place Display Status:</label>
				</div>
			</div>
			<div class="row">
				<div class="field">
					<?php echo form_dropdown('status', array('1'=>'Active','0'=>'Inactive'),$point->status);?>
				</div>
			</div>	
			
		</div>

	</div>
	
	<div class="hspacer2"></div>
	
	<div class="box-940">
	
		<div class="box-940-content">

			<div class="row">
				<input type="submit" value="Edit Point"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/points';" value="Cancel"/>
			</div>		

		</div>

	</div>	

	<?php echo form_close()?>
	
</div>

<?php echo $this->load->view('admin/footer');?>