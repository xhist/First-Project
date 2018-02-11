<?php 
include_once "dbconfig.php";
if(isset($_POST['case_id']) && $_POST['case_id'] != ''){
	$caseid = $_POST['case_id'];
	$output = '';
	$message = 'Данните бяха успешно изтрити.';
	$query = "delete from blog where id = '$caseid'";
	$comment_delete = mysqli_query($connect, "delete from comments where pid='$caseid'");
	$result = mysqli_query($connect, $query);
	$select = "select * from images where post_id = '$caseid'";
	$select_query = mysqli_query($connect, $select) or die("Error: ".mysqli_error($connect));
	while($select_array = mysqli_fetch_array($select_query)){
		unlink('D:/xampp/htdocs/new1/uploads/'.$select_array['file_name']);
	}
	$delete_images = "delete from images where post_id = '$caseid'";
	$delete_query = mysqli_query($connect, $delete_images) or die("Error: ".mysqli_error($connect));
	if($result){
		   $output .= '<label class="text-success">' . $message . '</label>';  
           $select_query = "select * from blog order by id desc";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr>  
                          <th width="55%">Заглавие</th>  
                          <th width="15%">Редактиране</th>  
                          <th width="15%">Разглеждане</th>
						  <th width="15%">Изтриване</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr>  
                          <td>'.$row["header"].'</td>  
                                    <td><button name="edit" id="'.$row["id"].'" class="btn btn-warning btn-sm edit_data"><span class="glyphicon glyphicon-edit"></span>&nbsp;Редактирай</button></td>  
                                    <td><button name="view" id="'.$row["id"].'" class="btn btn-info btn-sm view_data"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Разгледай</button></td>
									<td><button name="delete" id="'.$row["id"].'" class="btn btn-danger btn-sm delete_data"><span class="glyphicon glyphicon-trash"></span>&nbsp;Изтрий</button></td>  
                     </tr>  
                ';  
           }  
           $output .= '</table>';
	}
	echo $output;
}
?>