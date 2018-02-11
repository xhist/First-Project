<?php 
	session_start();
	include_once "dbconfig.php";
	$data = array();
	$data['output'] = "";
	$output = "";
	if(isset($_POST['id']) && $_POST['id'] != "" && isset($_SESSION['user']) && $_SESSION['user'] != ""){
		$favid = strip_tags($_POST['id']);
		$query = "delete from favorites where favid='".$favid."'";
		$delete = mysqli_query($connect, $query);
		$favorites_select = mysqli_query($connect, "select blog.id as postid, blog.header as header, favorites.pid as fid, favorites.userid as fuserid, favorites.favid as favid from blog inner join favorites  on blog.id = favorites.pid where favorites.userid = '".$_SESSION['user']."' order by favorites.pid");
		if(mysqli_num_rows($favorites_select) > 0){
			$output.= '	<div class="container text-center" style="width:100%; margin-top:30px;">
									<h3 style="color:black;">Списък с любими:</h3>
							  </div>';
				while($row = mysqli_fetch_array($favorites_select)){ 
						
					$output .= '<div class="container text-center" style="width:100%; margin-top:30px; color:black;">
								<table style="color:black; width:100%;">
									<tr><td style="width:10%; padding:15px 15px 15px 15px; text-align:center;">'.$row['fid'].'</td>
										<td style="width:60%; padding-top:15px; padding-bottom:15px; padding-left:15px; text-align:left;">
											<a href="/new1/case/'.$row['fid'].'/" style="text-decoration:none;">'.$row['header'].'</a>
										</td>
										<td style="width:30%;"><button type="submit" class="btn btn-danger delete" id="'.$row['favid'].'">
											<span class="glyphicon glyphicon-trash"></span>&nbsp;Изтрий</button>
										</td>
									</tr>
								</table>
						</div>'; 
				 
					}
		}else {
		$output .= '<div class="container text-center" style="width:100%; margin-top:30px;">
				<h3 style="color:black;">Не разполагате с любими случаи.</h3>
				</div>';
		}
		$data['output'] = $output;
		echo json_encode($data);
	}

?>