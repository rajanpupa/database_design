<?php
	//session handeling and processing section
	session_start();
	if(!isset($_SESSION['id'])){
		$_SESSION['id']=rand(1000, 10000);
	}
	include_once("libraries/items_class.php");
	include_once("libraries/DataBase/result_processor_class.php");
	
	if(!isset($_GET['id'])){
		header("/index.php");
	}
	$product_id = $_GET['id'];
	$item = new Item();
	$item->load($product_id);
	$body = "";
	$body.="<h3>Details of the product</h3>";
	$body.="<h4>Name</h4> : ".$item->name;
	$body.="<p> Description </p>".$item->description;
	$body.="<p> Unit </p> ".$item->unit;
?>
<?php
	//Required variables initialization section
	/*
	* variables to be defined are-:
	*	$image_path, points to the location of the header image "./public/images/header1.jpg"
	*	$navigation_menu, <ul><li><a href="#">menu1</a></li></ul>,
	*	$content, '<div id="article">contents<div>'
	*	$footer, 'Copyright &copy; 2012 reserved to rajan'
	*/
		$title = 'ShopNepal';
		$style = './public/styles/style1.css';
		$image_path = './public/images/header_shopping1.jpg';
		$navigation_menu = '<hr/><ul><li><a href="index.php">Home</a></li>
										<li><a href="#">School</a></li>
										<li><a href="#">Jungle</a></li></ul><hr/>';
		$content = '<p>This is an example content paragraph</p>';
		$content.=$body;
		$footer = 'Copyright &copy; 2012 reserved to Rajan prasad upadhyay.';
?>
<?php
	include_once("./views/view1/header.php");
	include_once("./views/view1/content.php"); 
	include_once("./views/view1/footer.php");
?>