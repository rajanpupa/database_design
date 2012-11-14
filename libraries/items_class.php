<?php
	include_once('DataBase/database_class.php');
	include_once("DataBase/result_processor_class.php");
	class Item {
		public $id;
		public $name;
		public $description = "";
		public $unit;

		public function get_result_root_categories(){
			$db = new Database();
			$query="select * from `itm_categories` where (parent_id is null)";
			//echo $query;//####This is to be commented
			$result = $db->execute_query_return_result($query);
			return $result;
		}
		public function get_result_products($category_id){
			$db = new Database();
			$query="select * from `itm_products` where (category_id = $category_id)";
			//echo $query;//####This is to be commented
			$result = $db->execute_query_return_result($query);
			return $result;
		}
		public function get_array_products($category_id){
			$result = $this->get_result_products($category_id);
			$rp = new Result_processor();
			$arr = array('id','name');
			return $rp->get_array_of($result,$arr);
		}
		
		public function load($id){
			$db = new Database();
			$query="select * from `itm_products` where (id = $id)";
			//echo $query;//####This is to be commented
			$result = $db->execute_query_return_result($query);
			$rp = new Result_processor();
			$fields = array('id','name','description','unit');
			$arr = $rp->get_array_of($result, $fields);
			$this->id=$id;
			$this->name = $arr[0]['name'];
			$this->description = $arr[0]['description'];
			$this->unit = $arr[0]['unit'];
			//echo $this->id." ".$this->name;
		}
		
	}
?>