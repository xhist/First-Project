<?php
	session_start();
	function test_input($field){
		$field = trim($field);
		$field = strip_tags($field);
		$field = htmlspecialchars($field);
		return $field;
	}
	
	include_once "dbconfig.php";
	$data = array();
	$data['output'] = "";
	$output = '';
	if(isset($_SESSION['user']) && $_SESSION['user'] != "" && isset($_POST['photo_id']) && $_POST['photo_id'] != ""){
		$photo_id = test_input($_POST['photo_id']);
		$select_image = mysqli_query($connect, "select * from images where id='".$photo_id."'");
		$image_array = mysqli_fetch_array($select_image);
		$abspath = $_SERVER['DOCUMENT_ROOT'];
		unlink($abspath.'/new1/uploads/'.$image_array['file_name']);
		$delete_query = mysqli_query($connect, "delete from images where id = '$photo_id'");
		$select_all = mysqli_query($connect, "select * from images order by id desc");
		if(mysqli_num_rows($select_all) > 0){
			while($row = mysqli_fetch_array($select_all)){
			$output .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 image_divs" style="margin-top:20px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:10px; padding-top:10px; padding-right:10px;">
						<img class="img-responsive" src="/new1/uploads/'.$row['file_name'].'" style="width:100%;" />
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="margin-top:15px; margin-bottom:15px;"><a rel="popover" data-toggle="popover" title="Детайли за снимката" data-placement="bottom" class="btn btn-primary btn-responsive update_photo" id="'.$row['id'].'" >Промени</a></div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="margin-top:15px; margin-bottom:15px;"><a class="btn btn-danger btn-responsive delete_photo" id="'.$row['id'].'">Изтрий</a></div>
						</div>
						</div>';
			}
		}
		else{
			$output .= '<p style="margin-left:5px; margin-right:5px; margin-top:10px;">Няма снимки за този случай, но можете да добавите.</p>';
		}
	}
	$data['output'] = $output;
	echo json_encode($data);
?>