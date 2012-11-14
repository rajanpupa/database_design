<?php
	//session handeling and processing section
	session_start();
	$_SESSION['id']=rand(1000, 10000);
	include_once("libraries/items_class.php");
	include_once("libraries/DataBase/result_processor_class.php");
	
	$items = new Item();
	$result = $items->get_result_root_categories();
	$rp = new Result_processor();
	$arr = array("id", "name");
	$categories = $rp->get_array_of($result, $arr);
	$body = "";
	//print_r($categories);
		foreach($categories as $category){
			//echo " The product is <br/>".$category['name']."";
			$products = $items->get_array_products($category['id']);
			//print_r($products);
			$body.="<div class=\"category\">".$category['name']."<ul>";
			foreach($products as $product){
				$body.="<li><a href=\"details.php?id=".$product['id']."\">".$product['name']."</a></li>";
			}
			$body.="</ul></div>";//category
		}
		//echo $body;
	//die();
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