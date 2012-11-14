<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<?php if(isset($style)){
					echo "<link type='text/css' rel='stylesheet' href='$style' />";
				}
		?>
	</head>
	<body>
		<div id="wrapper" >
			<div id="header" >
				<div id="image">
					<img src="<? echo $image_path; ?>" />				
				</div>
				<div id="navigation" >
					<?php echo $navigation_menu; ?>
				</div>
			</div>