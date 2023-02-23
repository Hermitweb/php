<?php
	
	/*
	*连接数据库的函数
	*$db_host 数据库的地址
	*$db_user 数据库账号
	*$db_password 数据库的密码
	*$db_name 数据的名称
	*/
	function connect($db_host,$db_user,$db_password,$db_name){
		$link = mysqli_connect($db_host,$db_user,$db_password,$db_name);
		if($link===false){
			echo "<script>alert('连接数据库有问题')</script>";die();
		}
		mysqli_query($link,"set names utf8");
		return 	$link;
	}
	/*
	*插入数据的函数
	*$table 数据表名称
	*$data 插入的数据数组，包含下标(表的字段)
	*/
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
	
	/*
	*修改数据的函数
	*$table 数据表名称
	*$data 修改的数据数组，包含下标(表的字段)
	*$where 条件字符串
	*/
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
	
	/*
	*删除
	*$table 数据表
	*$where 条件字符串
	*/
	function del($table,$where){
		$sql = "delete from ".PRE.$table." where ".$where;
		$result = mysqli_query($GLOBALS['link'],$sql);
		return $result;
		
	}
	/*
	*查询单条记录
	*$table 数据表
	*$where 条件字符串
	*/
	function getOne($table,$where=" 1 "){
		
		$sql = "select * from ".PRE.$table." where ".$where." limit 1";
		$query = mysqli_query($GLOBALS['link'],$sql);
		$result = mysqli_fetch_assoc($query);
		return $result;
		
		
	}
	/*
	*查询多条记录
	*$table 数据表
	*$where 条件字符串
	*/
	function getList($table,$where=' 1 ',$limit=10,$offset=0){
		
		$sql = "select * from ".PRE.$table." where ".$where." limit $offset,$limit";
		$query = mysqli_query($GLOBALS['link'],$sql);
		$list = array();
		while($result = mysqli_fetch_assoc($query)){
			$list[] = $result;
			
		}
		return $list;
		
		
	}
	
	
	
	
	
	
	
	
	
	