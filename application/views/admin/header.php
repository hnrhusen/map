<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
	<head>
		<title>Codeigniter Mapping Admin</title>
		<style type="text/css">
			@import url('/css/admin/global.css');
			@import url('/css/admin/layout.css');
			@import url('/css/admin/boxes.css');
			@import url('/css/admin/columns.css');
			@import url('/css/admin/data.css');
			@import url('/css/admin/forms.css');
		</style>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="/js/jquery/jqtransform.js"></script>
	</head>
	<body>
		<div id="outer">
			
			<div id="inner">
			
				<div id="header">
				
					<div id="header-top">
						
						<div id="header-top-left">
							<h1>Codeigniter Mapping Admin</h1>
						</div>
						
						<div id="header-top-right">	
								<p><img src="/img/admin/icons/padlock.png"/><a href="/index.php/admin/users/logout">Logout</a></p>
						</div>
					
					</div>
				
					<div id="header-bottom">
						<?php echo $this->load->view('admin/menu',array('selected'=>$selected));?>					
					</div>
				
				</div>
					