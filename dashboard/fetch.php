<?php  
 //fetch.php  
 include_once "dbconfig.php";
 if(isset($_POST["case_id"]) && $_POST['case_id'] != "")  
 { 
	  $data = array();
	  $image_output = "";
      $query = "SELECT * FROM blog WHERE id='".$_POST["case_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);
	  $secondquery = "select * from images where post_id='".$_POST['case_id']."' order by id desc";
	  $secondresult = mysqli_query($connect, $secondquery);
	  while($secondrow = mysqli_fetch_array($secondresult)){
		$image_output .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 image_divs" style="margin-top:20px;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:10px; padding-top:10px; padding-right:10px;">
		<img class="img-responsive" src="/new1/uploads/'.$secondrow['file_name'].'" style="width:100%;" />
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="margin-top:15px; margin-bottom:15px;"><a rel="popover" data-toggle="popover" title="Детайли за снимката" data-placement="bottom" class="btn btn-primary btn-responsive update_photo" id="'.$secondrow['id'].'" >Промени</a></div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="margin-top:15px; margin-bottom:15px;"><a class="btn btn-danger btn-responsive delete_photo" id="'.$secondrow['id'].'">Изтрий</a></div>
		</div>
		</div>';
	  }
	  $data['case_data'] = $row;
	  $data['images_data'] = $image_output;
      echo json_encode($data);  
 }  
 ?> 