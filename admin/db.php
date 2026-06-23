<?php
	// 检查是否已定义模拟函数，如果已定义则跳过
	if (!function_exists('connect')) {
		function connect($db_host,$db_user,$db_password,$db_name){
			global $link;
			$link = mysqli_connect($db_host,$db_user,$db_password,$db_name);
			if($link===false){
				echo "<script>alert('连接数据库有问题')</script>";die();
			}
			mysqli_query($link,"set names utf8");
		}
	}
	
	if (!function_exists('add')) {
		function add($table,$data){
			$field = '';
			$value = '';
			foreach($data as $key=>$val){
				$field .= '`'.$key.'`,';
				$value .= "'".$val."',";	
			}
			$field = substr($field,0,-1);
			$value =  substr($value,0,-1);
			$sql = "insert into ".PRE.$table."(".$field.") value(".$value.")";
			$result = mysqli_query($GLOBALS['link'],$sql);
			return $result;
		}
	}
	
	if (!function_exists('update')) {
		function update($table,$data,$where){
			$files_value = '';
			foreach($data as $key=>$val){
				$files_value.='`'.$key."`='".$val."',";
			}
			$files_value = substr($files_value,0,-1);
			$sql = "update ".PRE.$table." set ".$files_value." where ".$where;
			$result = mysqli_query($GLOBALS['link'],$sql);
			return $result;
		}
	}
	
	if (!function_exists('del')) {
		function del($table,$where){
			$sql = "delete from ".PRE.$table." where ".$where;
			$result = mysqli_query($GLOBALS['link'],$sql);
			return $result;
		}
	}
	
	if (!function_exists('getOne')) {
		function getOne($table,$where=" 1 "){
			$sql = "select * from ".PRE.$table." where ".$where." limit 1";
			$query = mysqli_query($GLOBALS['link'],$sql);
			$result = mysqli_fetch_assoc($query);
			return $result;
		}
	}
	
	if (!function_exists('getList')) {
		function getList($table,$where=' 1 ',$limit=10,$offset=0){
			$sql = "select * from ".PRE.$table." where ".$where." limit $offset,$limit";
			$query = mysqli_query($GLOBALS['link'],$sql);
			$list = array();
			while($result = mysqli_fetch_assoc($query)){
				$list[] = $result;
			}
			return $list;
		}
	}
	
	if (!function_exists('get_rows')) {
		function get_rows($table,$where=" 1 "){
			$sql = "select count(*) as total from ".PRE.$table." where ".$where;
			$query = mysqli_query($GLOBALS['link'],$sql);
			$result = mysqli_fetch_assoc($query);
			return $result['total'];
		}
	}

	function getIp() {
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if($ip){
				array_unshift($ips, $ip); 
				$ip = FALSE;
			}
			for($i = 0; $i < count($ips); $i++){
				if (!preg_match("/^(10|172\.16|192\.168)\./", $ips[$i])){
					$ip = $ips[$i];
					break;
				}
			}
		}
		return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
?>
