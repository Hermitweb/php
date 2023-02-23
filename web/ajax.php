<?php

	include_once('int.php');
	$type = $_POST['type'];
	switch ($type) {
		case 'index':
		$page_size = 4;
		$page = $_POST['page'];
		$offset = ($page-1)*$page_size;	
		$list = getList('wen',$where=' pinglun= 1 ',$limit=$page_size,$offset);
        if(empty($list)){

        	$data = array(
        		'code' =>404,
        		'list' =>$list
        		 );
        }else{

        	$data = array(
        		'code' =>100,
        		'list' =>$list
        		 );
        }
        echo json_encode($data);
		//print_r($data);




		break;
		case 'list':
		$page_size = 4;
		$page = $_POST['page'];
		$offset = ($page-1)*$page_size;	
		$catid = $_POST['catid'];
		$list = getList('wen',$where=" catid=$catid and status = 1 ",$limit=$page_size,$offset);
        if(empty($list)){

        	$data = array(
        		'code' =>404,
        		'list' =>$list
        		 );
        }else{

        	$data = array(
        		'code' =>100,
        		'list' =>$list
        		 );
        }
        echo json_encode($data);
		//print_r($data);




		break;
		case 'search':
		$page_size = 4;
		$page = $_POST['page'];
		$offset = ($page-1)*$page_size;	
		
		$keywords = $_POST['keywords'];
		if(!empty($keywords)){
			$where="( title like '%$keywords%' or content like '%$keywords%' or `describe`  like '%$keywords%')  and status = 1 ";
		}else{
			$where=" status = 1 ";
		}
		$list = getList('wen',$where,$limit=$page_size,$offset);
        if(empty($list)){

        	$data = array(
        		'code' =>404,
        		'list' =>$list
        		 );
        }else{

        	$data = array(
        		'code' =>100,
        		'list' =>$list
        		 );
        }
        echo json_encode($data);
		//print_r($data);




		break;
		
		
		default:
			# code...
			break;
	}
	
?>