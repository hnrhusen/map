<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="/css/global.css" type="text/css"/>
		<link rel="stylesheet" href="/css/layout.css" type="text/css"/>
		<!--Javascripts-->
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="/js/gmap.js"></script>
		<script type="text/javascript" src="/js/jquery/cookie.js"></script>
		<script type="text/javascript" src="/js/maps/markers.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			
				initialize();
				
				//The button to open the categories panel has been clicked
				$('#btnCategoriesOpen').click(function(){
					
					//If the button to open the categories has the value show categories then 
					//display the categories panel and change the value of the button to hide categories
					if ($('#btnCategoriesOpen').val() == 'show categories')
					{
						$('#categories').css('display','block');
						$('#btnCategoriesOpen').val('hide categories');
						
					}
					else
					{
						//The button has the value hide categories so hide the categories panel and change
						//the value of the button to show categories
						$('#categories').css('display','none');
						$('#btnCategoriesOpen').val('show categories');					
					}	
									
				});
				
				//The button to close the categories panel has been clicked
				$('#btnCategoriesClose').click(function(){
					
					//Hide the categories panel
					$('#categories').css('display','none');
					
					//Change the value of the button to open the categories panel to its default of show categories
					$('#btnCategoriesOpen').val('show categories');										
				});
					
				$('#btnIncreaseZoom').click(function(){
					zoomInMap();
				});							

				$('#btnDecreaseZoom').click(function(){
					zoomOutMap();
				});	
				
				$('#btnSetTypeToMap').click(function(){
					setMapType('roadmap');
				});

				$('#btnSetTypeToSatellite').click(function(){
					setMapType('satellite');
				});
				
				$('#btnSetTypeToHybrid').click(function(){
					setMapType('hybrid');				
				});

				$('#btnSetTypeToTerrain').click(function(){
					setMapType('terrain');				
				});
			});
		</script>
		<!--End Javascripts-->
	</head>		
	<body>
		<div id="header">
			<div id="header-left"><h1>Codeigniter Google Map</h1></div>
			<div id="header-right">
				<div id="header-right-controls">
					<div id="header-right-controls-categories">
						<input id="btnCategoriesOpen" type="button" value="show categories"/>
					</div>
					<div id="header-right-controls-places">
						<?php echo form_open('/place/index');?>
							<?php if ($places):?>
							<select id="place" name="place">
							<?php foreach($places as $place):?>
							<?php if ($selected_place == $place->id):?>
							<option value="<?php echo $place->id?>" selected="selected"><?php echo $place->name;?></option>
							<?php else:?>
							<option value="<?php echo $place->id?>"><?php echo $place->name;?></option>												<?php endif;?>
							<?php endforeach;?>
							</select>&nbsp;<input id="btnUpdatePlace" type="submit" value="Update Place"/> 
							<?php endif;?>
						<?php echo form_close();?>		
					</div>
					<div id="header-right-controls-zoom">
						<input id="btnIncreaseZoom" type="button" value="+"/>&nbsp;<input id="btnDecreaseZoom" type="button" value="-"/>
					</div>
					<div id="header-right-controls-maptype">
						<input id="btnSetTypeToMap" type="button" value="Map"/>
						<input id="btnSetTypeToSatellite" type="button" value="Satellite"/>
						<input id="btnSetTypeToHybrid" type="button" value="Hybrid"/>
						<input id="btnSetTypeToTerrain" type="button" value="Terrain"/>
					</div>
				</div>
			</div>
		</div>
		<div id="categories">
			<?php echo form_open('/category/index');?>
				<?php if ($categories):?>
					<?php foreach($categories as $category):?>
						<?php echo form_checkbox('category'.$category->id, $category->id,checkbox_selected($category->id,$selected_categories));?><?php echo $category->name;?>
					<?php endforeach;?>
					<input id="btnUpdateMap" type="submit" value="Update Map"/>
				<?php endif;?>
				<input id="btnCategoriesClose" type="button" value="Close Categories"/> 
			<?php echo form_close();?>
		</div>
		<div id="map" style="width:100%; height:90%"></div>
	</body>
</html>	