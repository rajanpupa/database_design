<?php
	class Result_processor{
		
		public function get_array($result){
			$arr = array();
			while($row = mysql_fetch_array($result)){
				array_push($arr, $row);
				//$arr[]
			}
			return $arr;
		}
		public function get_array_of($result, $field ){
			//field is a single string variable
			$arr = array();
			if(is_array($field)) {
				while($row = mysql_fetch_array($result)){
					$temp_arr = array();
					foreach($field as $temp_field){
						//array_push($temp_arr, $row[$temp_field]);
						$temp_arr[$temp_field] = $row[$temp_field];
					}
					array_push($arr, $temp_arr);
				}
				return $arr;
			}else {
				while($row = mysql_fetch_array($result)){
					array_push($arr, $row[$field]);
				}
				return $arr;
			}
		}
	}
?>