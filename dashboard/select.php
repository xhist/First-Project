<?php 
 include_once "dbconfig.php"; 
 if(isset($_POST["case_id"]) && $_POST["case_id"] != "")  
 {  
	  $caseid = $_POST["case_id"];
	  
      $output = '';    
      $query = "select * from blog where id = '".$caseid."'";  
      $result = mysqli_query($connect, $query);//or die("Error: ".mysqli_error($connect));  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td width="30%"><label>Заглавие</label></td>  
                     <td width="70%" style="overflow:auto;">'.$row["header"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Описание</label></td>  
                     <td width="70%" style="overflow:auto;">'.$row["description"].'</td>  
                </tr>   
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>