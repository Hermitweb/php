<?php

	include_once('int.php');
	$type = $_POST['type'];
	switch ($type) {
		case 'pinglun':
			
			$id = $_POST['id'];
			$news = getOne('wen',"id=$id");

            $data = array(
            	'pinglun'=>$news['pinglun']?0:1
            );
            $result = update('wen',$data,"id=$id");
            if($result){

            	$return = array(
            		'code'=>100,
            		'string'=>$news['pinglun']==1?"允许评论":"禁止评论"
            	);
            }else{
				$return = array(
            		'code'=>404,
            		
            	);

            }
			echo json_encode($return);
			break;
		case 'remen':
			
			$id = $_POST['id'];
			$news = getOne('wen',"id=$id");

            $data = array(
            	'remen'=>$news['remen']?0:1
            );
            $result = update('wen',$data,"id=$id");
            if($result){

            	$return = array(
            		'code'=>100,
            		'string'=>$news['remen']==0?"取消热门":"设为热门"
            	);
            }else{
				$return = array(
            		'code'=>404,
            		
            	);

            }
			echo json_encode($return);
			break;
		case 'del':
			
			$id = $_POST['id'];
			

            
            $result = del('wen',"id=$id");
            if($result){

            	$return = array(
            		'code'=>100,
            	);
            }else{
				$return = array(
            		'code'=>404,
            		
            	);

            }
			echo json_encode($return);
			break;
            case 'udel':
                  
                  $id = $_POST['id'];
                  

            
            $result = del('user',"id=$id");
            if($result){

                  $return = array(
                        'code'=>100,
                  );
            }else{
                        $return = array(
                        'code'=>404,
                        
                  );

            }
                  echo json_encode($return);
                  break;	


		default:
			# code...
			break;
	}
	
?>