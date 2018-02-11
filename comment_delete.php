<?php 
	include_once "dbconfig.php";
	session_start();
	function test_input($field){
		$field = trim($field);
		$field = strip_tags($field);
		$field = htmlspecialchars($field);
		return $field;
	}
	
	if(isset($_SESSION['user']) && isset($_POST['comment_id'])){
		$comment_id = test_input($_POST['comment_id']);
		$comment_select = mysqli_query($connect, "select * from comments where id='".$comment_id."'");
		$comment_info = mysqli_fetch_array($comment_select);
		$pid = $comment_info['pid'];
		$output = '';
		$delete_comment = mysqli_query($connect, "delete from comments where id='".$comment_id."'");
		
		$com = mysqli_query($connect, "select comments.id as comid,comments.cdate as cdate, comments.userid as comuid, comments.description as comdesc, comments.pid as compid, users.userId as uid, users.userName as uname, users.firstname as firstname, users.lastname as lastname, users.photo as photo, users.level as user_level from comments inner join users on comments.userid = users.userId where comments.pid = '".$pid."' order by comments.id");
				$comcount = mysqli_num_rows($com);
				setlocale(LC_TIME, 'bg_BG.UTF-8');
				if($comcount > 0){ 
				$output .='	<p style="color:black;"><span class="glyphicon glyphicon-comment"></span> '.$comcount.' Коментар/a:</p><br> 
					<div class="row" id="second_area">';
						
						
					if(isset($_SESSION['user'])){
					$user_select = mysqli_query($connect, "select * from users where userId = '".$_SESSION['user']."'");
					$user_data = mysqli_fetch_array($user_select);
					$user_lev = $user_data['level'];
					if($user_lev == 2){
						while($comments = mysqli_fetch_array($com)){
						$firstname = $comments['firstname']; 
						$lastname = $comments['lastname'];
						 
				
				
					$output .= '<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/'.$comments['photo'].'" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;">'.$firstname."&nbsp;".$lastname.'</b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: '.strftime("%e %B, %A %Y", strtotime($comments['cdate'])).'</i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;">'.$comments['comdesc'].'</p>
								
							</div>
							<a href="#" data-toggle="popover" class="comment_options" style="position:absolute; top:0px; right:2px;" id="'.$comments['comid'].'"><span style="color: #b7b6ae;" class="glyphicon glyphicon-chevron-down"></span></a>
						</div>
					</div>';
						}  
					}else{
						while($comments = mysqli_fetch_array($com)){
						$firstname = $comments['firstname']; 
						$lastname = $comments['lastname']; 
						if($user_lev == 1 && $comments['comuid'] == $_SESSION['user']){ 
					$output .='<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/'.$comments['photo'].'" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;">'.$firstname."&nbsp;".$lastname.'</b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: '.strftime("%e %B, %A %Y", strtotime($comments['cdate'])).'</i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;">'.$comments['comdesc'].'</p>
								
							</div>
							<a href="#" data-toggle="popover" class="comment_options" style="position:absolute; top:0px; right:2px;" id="'.$comments['comid'].'"><span style="color: #b7b6ae;" class="glyphicon glyphicon-chevron-down"></span></a>
						</div>
					</div>';
					}
						else{
							
					$output .='<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/'.$comments['photo'].'" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;">'.$firstname."&nbsp;".$lastname.'</b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: '.strftime("%e %B, %A %Y", strtotime($comments['cdate'])).'</i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;">'.$comments['comdesc'].'</p>
								
							</div>
						</div>
					</div>';	
						}
						}
					} 
					
					}
				else{ 
					while($comments = mysqli_fetch_array($com)){
					$firstname = $comments['firstname']; 
					$lastname = $comments['lastname'];
				
					$output .='<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/'.$comments['photo'].'" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;">'.$firstname."&nbsp;".$lastname.'</b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: '.strftime("%e %B, %A %Y", strtotime($comments['cdate'])).'</i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;">'.$comments['comdesc'].'</p>
								
							</div>
						</div>
					</div>';
					}
				}
				
						
				 $output .= '</div>';
				 }
				 else{
			            $output .= '<p style=\"color:black;\">Не съществуват коментари за този случай.</p>';
				 }
		echo $output;
	}
?>