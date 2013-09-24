<?php echo $this->load->view('admin/header',array('selected'=>'places'));?>

<script type="text/javascript" src="/js/admin/gmap.js"></script>

<script type="text/javascript">
	$(document).ready(function(){	
		initialize(<?php echo $place->latitude;?>,<?php echo $place->longitude;?>);
	});
</script>

<div id="content">
	<?php echo form_open(current_url())?>
	<?php echo form_hidden('id',$place->id);?>
	<?php echo form_hidden('latitude',$place->latitude);?>
	<?php echo form_hidden('longitude',$place->longitude);?>
	
	<h2>Edit Place</h2>

	<p>Edit the selected place by updating the information required below</p>

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
					<label for="">Enter Place Name:</label>
				</div>
			</div>
			<div class="row">
				<div class="field">
					<?php echo form_input('name',$place->name);?>
				</div>
			</div>
			
			<div class="hspacer2"></div>
			
			<div class="row">
				<div class="label">
					<label for="">Place Is Default Location:</label>
				</div>
			</div>
			<div class="row">
				<div class="field">
					<?php echo form_dropdown('default', array('1'=>'Yes','0'=>'No'),$place->default);?>
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
					<?php echo form_dropdown('status', array('1'=>'Active','0'=>'Inactive'),$place->status);?>
				</div>
			</div>					
		</div>
	</div>
	
	<div class="hspacer2"></div>
	
	<div class="box-940">
	
		<div class="box-940-content">

			<div class="row">
				<input type="submit" value="Edit Place"/>&nbsp;<input type="button" onclick="location.href='/index.php/admin/places';" value="Cancel"/>
			</div>		

		</div>

	</div>

	<?php echo form_close()?>
	

	<?php echo form_close()?>
	
</div>

<?php echo $this->load->view('admin/footer');?>