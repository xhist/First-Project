<?php 
	session_start();
?>
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/new1/fancybox/jquery.fancybox.min.css"/>
<link rel="stylesheet" type="text/css" href="/new1/notify/animate.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/new1/notify/bootstrap-notify.js"></script>
<script src="/new1/fancybox/jquery.fancybox.min.js"></script>
<script>
$(document).ready(function(){
	
	$(document).on('click', '.comment_delete', function(e){
		e.preventDefault();
		var comment_id = $(this).attr('id');
		$.ajax({
			url:"/new1/comment_delete.php",
			type:"POST",
			data:{comment_id:comment_id},
			success:function(response){
				$("#comments_area").html(response);
				$.notify({
						message:"Коментарът беше успешно изтрит!"
					},
					{
						type:"success",
						allow_dismiss:false,
						placement:{
							from:"top",
							align: "right"
						},
						delay:2000,
						animate:{
							enter:"animated fadeInDown",
							exit:"animated fadeOutUp"
						},
						mouse_over:"pause",
						newest_on_top:true
					}
				);
			}
		});
	});
	
	$('.redirect_button').click(function(e){
		e.preventDefault();
		var button_link = $(this).attr('href');
		$.ajax({
			url:'/new1/destroy_session',
			success:function(response){
				window.location.href = button_link;
			}
		});
	});
	
	$(".comment_options").popover({
		html:true,
		container: '#second_area',
		content: function(){
			return "<div class='options' style='padding-left:5px; font-size:13px; border-bottom:0.5px solid gray'><a href='#' class='comment_edit' id='"+ $(this).attr('id') +"'>Редактирай</a></div><div class='options' style='padding-left:5px; font-size:13px;'><a href='#' class='comment_delete' id='"+ $(this).attr('id') +"'>Изтрий</a></div>";
		},
		trigger: "click",
		placement: "bottom"
	});
	
	$(".comment_options").click(function(e){
		e.preventDefault();
	});
	
	$(document).on('click', '.options', function(event){
		event.preventDefault();
	});
	
	
	/*$('#comments_area .popover .options').on({
		mouseover:function(){
		var option = $(this);
		$(option).css('background-color', '#dee0e2');
		},
		mouseout:function(){
		var option = $(this);
		$(option).css('background-color', 'white');
		}
	});*/
	
	$(window).off("resize").on("resize", function() {
			$('.popover').each(function(){
				var popover = $(this);			
				if ($(popover).is(":visible")) {
						var ctrl = $(popover.context);
						ctrl.popover('show');
				}
			});
	});
	
	
	$('.navbar-toggle').on({
		mouseover:function(){
		var button = $(this);
		$(button).css('background-color', 'gray');
		$(button).find('span').css('background', 'white');
		},
		mouseout:function(){
		var button = $(this);
		$(button).css('background-color', 'white');
		$(button).find('span').css('background', 'black');
		}
	});
	
	$("#commentform").submit(function(e){
		e.preventDefault();
		var description = $("#description").val();
		var postid = $('#post_id').val();
		$.ajax({
			url:"/new1/comment/",
			type:"post",
			dataType:"JSON",
			data:{description: description, postid: postid},
			success:function(response){
				if(response.success == true){
					$("#commentform")[0].reset();
					$("#comments_area").html(response.output);
					$.notify({
						message:"Коментарът беше успешно добавен!"
					},
					{
						type:"success",
						allow_dismiss:false,
						placement:{
							from:"top",
							align: "right"
						},
						delay:2000,
						animate:{
							enter:"animated fadeInDown",
							exit:"animated fadeOutUp"
						},
						mouse_over:"pause",
						newest_on_top:true
					}
					);
					
					$(".comment_options").popover({
						html:true,
						container: '#comments_area',
						content: function(){
							return "<div class='options' style='padding-left:5px; font-size:13px; border-bottom:0.5px solid gray'><a href='#' class='comment_edit' id='"+ $(this).attr('id') +"'>Редактирай</a></div><div class='options' style='padding-left:5px; font-size:13px;'><a href='#' class='comment_delete' id='"+ $(this).attr('id') +"'>Изтрий</a></div>";
						},
						trigger: "click",
						placement: "bottom"
					});
	
					$(".comment_options").click(function(e){
						e.preventDefault();
					});
					
					
				}else{
					$('.comment_Error').text(response.commentError);
				}
			}
		});
	});
	
	/*$("#fancyboxes").click(function(){
		return false;
	});*/
	
	/*$(window).on('hashchange', function(e){
		history.replaceState ("", document.title, e.originalEvent.oldURL);
	});*/
	
	$('.fancybox').fancybox();
	
	$(document).on('click', '.add_to_favorites', function(e){
		e.preventDefault();
		var button = $(this);
		var postid = $(this).attr('id');
		$.ajax({
			url:"/new1/add_to_favorites",
			type:"POST",
			data:{postid:postid},
			success:function(response){
				$(button).attr('disabled', 'true');
				$.notify({
					message:"Случаят беше успешно добавен във вашите любими."
				},
				
					{
						type:"success",
						allow_dismiss:false,
						placement:{
							from:"top",
							align: "right"
						},
						delay:2000,
						animate:{
							enter:"animated fadeInDown",
							exit:"animated fadeOutUp"
						},
						mouse_over:"pause",
						newest_on_top:true
					}
				
				);
			}
		});
	});
	
	window.onbeforeunload = function(){
		$.ajax({
			url:'/new1/destroy_session',
			success:function(response){
				
			}
		});
	}
	
	
	
});
</script>
</head>
<style>
html body {
    height: 100%;
    width: 100%;
	margin:0px;
	padding-top:50px;
    position:absolute;
}
#header{
    width: 100%;
    background: white;
	color:black;
	right:0px;
	left:0px;
	top:0px;
}
#hr {
	color:black;
}
#footer{
	height: 100px;
    width: 100%;
    background: #575e68;
	bottom:0px;
	left:0px;
	right:0px;
	margin-top:0px;
	position:relative;
}
#drop {
	color:black;
	background:white;
}
#toggle{
	background:white;
}
#icon {
	background:black;
}
#main {
    min-height:100%;
    width:80%;
	height:auto;
	border-left:1px solid black;
	border-right:1px solid black;
	margin-top:0px;
	margin-bottom:0px;
	color:white;
	position:relative;
}
@media (max-width: 320px){
	
	.post_title{
		font-size:22px;
	}
	#disabled_form{
		width:100%;
	}
	#commentform{
		width:100%;
	}
}
@media (min-width:320px) and (max-width: 480px){
	
	.post_title{
		font-size:26px;
	}
	#disabled_form{
		width:100%;
	}
	#commentform{
		width:100%;
	}
	
}
@media (min-width:480px) and (max-width:768px){
	#disabled_form{
		width:100%;
	}
	#commentform{
		width:100%;
	}
	
}
@media (min-width:768px) and (max-width: 992px){
	#disabled_form{
		width:60%;
	}
	#commentform{
		width:60%;
	}
}
@media (min-width : 992px) and (max-width: 1199px){
	#disabled_form{
		width:60%;
	}
	#commentform{
		width:60%;
	}
}
@media (min-width: 1200px){
	#disabled_form{
		width:60%;
	}
	#commentform{
		width:60%;
	}
}
textarea{
	resize:none;
}
.navbar-inverse .navbar-toggle .icon-bar {
	background:black;
}
.popover .options a{
	text-decoration:none;
	color:black;
	
}
.popover{
	min-width:100px;
	margin-left: -30px;
	height:auto;
}
.popover .arrow{
	left:78% !important;
}
.popover .options:hover{
	background-color:#dee0e2;
}
.popover-content{
	padding:0 0 0 0;
}
</style>
<body>
     <div class="navbar navbar-inverse navbar-fixed-top" id="header">
  <div class="container">
    <div class="navbar-header">
      <button id="toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span id="icon" class="icon-bar"></span>
        <span id="icon" class="icon-bar"></span>
        <span id="icon" class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/new1" id="brand" style="color:black;">Начало</a>
    </div>
    <div class="navbar-collapse collapse" id="searchbar">
     
      <ul class="nav navbar-nav navbar-right">
				    <?php
				ob_start();
				
				require_once 'dbconfig.php';
				
				if(!isset($_GET['postid'])){
						header("Location: /new1");
						exit;
				}
	
				if( !isset($_SESSION['user']) ) { ?>
				<li><a id="hr" href="/new1/case/<?php $id= strip_tags($_GET['postid']); echo $id; ?>/register"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
				<li><a id="hr" href="/new1/case/<?php $id= strip_tags($_GET['postid']); echo $id;?>/login"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
				<?php 
				}else{
				
				$res=mysqli_query($connect, "SELECT * FROM users WHERE userId='".$_SESSION['user']."'");
				$userRow=mysqli_fetch_array($res);
				$username = $userRow['userName'];
				$userlevel = $userRow['level'];
					if($userlevel == 2){
                ?>
					<li class="dropdown" style="">
					  <a id="drop" href="#" style="color:black; text-decoration:none;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-user"></span>&nbsp;Здравейте, <?php echo $username; ?>&nbsp;<span class="caret"></span></a>
					  <ul class="dropdown-menu" style="">
						<li><a style="color:black; text-decoration:none;" href="/new1/dashboard/"><span class="glyphicon glyphicon-cog"></span>&nbsp;Контролен панел</a></li>
						<li><a style="color:black; text-decoration:none;" href="/new1/settings/"><span class="glyphicon glyphicon-cog"></span>&nbsp;Настройки</a></li>
						<li><a style="color:black; text-decoration:none;" href="/new1/favorites/"><span class="glyphicon glyphicon-heart"></span>&nbsp;Любими</a></li>
						<li ><a style="color:black; text-decoration:none;" href="/new1/logout/"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Изход</a></li>
					  </ul>
					</li>
			<?php
					}
					else{ ?>
					<li class="dropdown" style="">
					  <a id="drop" href="#" style="color:black; text-decoration:none;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-user"></span>&nbsp;Здравейте, <?php echo $username; ?>&nbsp;<span class="caret"></span></a>
					  <ul class="dropdown-menu" style="">
						<li><a style="color:black; text-decoration:none;" href="/new1/settings/"><span class="glyphicon glyphicon-cog"></span>&nbsp;Настройки</a></li>
						<li><a style="color:black; text-decoration:none;" href="/new1/favorites/"><span class="glyphicon glyphicon-heart"></span>&nbsp;Любими</a></li>
						<li ><a style="color:black; text-decoration:none;" href="/new1/logout/"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Изход</a></li>
					  </ul>
					</li>
			<?php		}
				}
			?>
      </ul>
     <form class="navbar-form">
        <div class="form-group" style="display:inline;">
          <div class="input-group" style="display:table;">
            <input class="form-control" name="search" placeholder="Search Here" autocomplete="off" type="text">
            <div class="input-group-btn" style="width:1%; line-height:1.2px;">
            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </div>
          </div>
        </div>
      </form>

    </div><!--/.nav-collapse -->
  </div>
</div>
	<div class="container text-left" id="main">
           	<div class="container text-right" style="width:100%; margin-bottom:30px; margin-top:30px; color:white;">
			<div class="row">
			<?php 
			if(!isset($_SESSION['user'])){
			?>
			  <form style="width:100%; margin-bottom:30px; margin-top:20px;">
			  <div class="col-sm-12 col-xs-12 col-md-6" style="margin-bottom:10px;">
				<a href="<?php if(isset($_SESSION['url'])){ echo $_SESSION['url']; } else{ echo "/new1"; } ?>" class="btn btn-primary col-sm-12 col-xs-12 col-md-5 redirect_button" style="color:black;"><span class="glyphicon glyphicon-arrow-left"></span> Назад към началото</a>
			  </div>
			  <div class="col-sm-12 col-xs-12 col-md-6">
				<button type="submit" class="btn btn-primary col-sm-12 col-xs-12 col-md-5 pull-right" disabled="true" style="color:black;">Добави в любими</button>
			  </div>
			  </form>
			  <?php }else{
				$pid = strip_tags($_GET['postid']);
				$row = mysqli_query($connect, "select pid, userid from favorites where pid = ".$pid." and userid = '".$_SESSION['user']."'");
				$rownum = mysqli_num_rows($row);
				  if($rownum == 0){
			  ?>
			  <form style="width:100%; margin-bottom:30px; margin-top:20px;">
					<div class="col-sm-12 col-xs-12 col-md-6" style="margin-bottom:10px;">
						<a href="<?php if(isset($_SESSION['url'])){ echo $_SESSION['url']; } else{ echo "/new1"; } ?>" class="btn btn-primary col-sm-12 col-xs-12 col-md-5 redirect_button" style="color:black;"><span class="glyphicon glyphicon-arrow-left"></span> Назад към началото</a>
					</div>
					<div class="col-sm-12 col-xs-12 col-md-6">
						<button id="<?php if(isset($_GET['postid'])){ echo $_GET['postid']; } ?>" type="submit" class="btn btn-primary col-sm-12 col-xs-12 col-md-5 pull-right add_to_favorites" style="color:black;">Добави в любими</button>
					</div>
			  </form>
			  <?php } else {
				
				?>
			  <form style="width:100%; margin-bottom:30px; margin-top:20px;">
			  <div class="col-sm-12 col-xs-12 col-md-6" style="margin-bottom:10px;">
				<a href="<?php if(isset($_SESSION['url'])){ echo $_SESSION['url']; } else{ echo "/new1"; } ?>" class="btn btn-primary col-sm-12 col-xs-12 col-md-5 redirect_button" style="color:black;"><span class="glyphicon glyphicon-arrow-left"></span> Назад към началото</a>
			  </div>
			  <div class="col-sm-12 col-xs-12 col-md-6">
				<button type="submit" class="btn btn-primary col-sm-12 col-xs-12 col-md-5 pull-right" disabled="true" style="color:black;" title="Случаят вече е добавен в любими">Добави в любими</button>
			  </div>
			  </form>
			  <?php }
				}	?>
			</div>
            </div>
			<div class="container" style="width:100%;">
				<div class="row">
				<?php 
	        
				$pid = strip_tags($_GET['postid']);
				$row = mysqli_query($connect, "select * from blog where id=".$pid."");
				$record = mysqli_fetch_array($row);
				?>
				<div class="col-sm-12 col-xs-12 col-md-12 content" style="width:100%; color:black;">
					<?php //echo basename($_SERVER['SCRIPT_FILENAME'], '.php'); ?>
					<h1 class="post_title"><?php echo $record['header']; ?></h1>
					<hr style="background-color:black; border:1px solid black; width:100%;"/>
					
					<div class="col-sm-12 col-xs-12 col-md-6" style="margin-bottom:30px;">
					<p class="col-sm-12 col-xs-12 col-md-12"><?php echo $record['description']; ?></p>
					</div>
					<div class="col-sm-12 col-xs-12 col-md-6" style="border:2px solid #dcdfe5; border-radius:10px; ">
						<h4 align="center" style="margin-bottom:30px; text-decoration:underline;">Инструкции към случая<h4>
						<?php 
							$inst_row = mysqli_query($connect, "select * from images where post_id = '".$pid."'");
							$image_count = mysqli_num_rows($inst_row);
							if($image_count == 0){
								echo "<p align=\"center\">Няма налични инструкции за този случай.</p>";
							}
							else{
								while($row = mysqli_fetch_array($inst_row)){
									echo '<div class="col-xs-12 col-sm-6 col-md-4" style="margin-bottom:20px;">
										<div class="col-xs-12 col-sm-12 col-md-12">
											<a class="fancybox" data-fancybox="fancy_gallery" data-caption="'.$row['file_title'].'" data-height="600" data-width="800" href="/new1/uploads/'.$row['file_name'].'"><img src="/new1/uploads/'.$row['file_name'].'" style="width:100%;"/></a>
										</div>
									</div>';
								}
							}
							
						?>
					</div>
				</div>
				</div>
			</div>
			<?php 
				if(!isset($_SESSION['user'])){
					
			?>
			<div class="container content"  style="width:100%; margin-top:30px; margin-bottom:30px; color:black;">
				<form method="post" id="disabled_form">
					<p style="color:black;"><b>Добави коментар:</b></p>
					<div class="form-group">	
						<textarea rows="5" cols="5" class="form-control" disabled="true" style="color:black;">Влезте в профила си, за да добавите коментар.</textarea>
					</div>
					<button type="submit" class="btn btn-primary" disabled="true" style="color:black;">Добави</button>
				</form>
			</div>
			<?php
			} else {
			?>
			<div class="container content" style="width:100%; margin-top:30px; margin-bottom:30px;">
				<form method="post" id="commentform" role="form">
					<p style="color:black;"><b>Добави коментар:</b></p>
					<div class="form-group">
						<textarea rows="5" cols="5" class="form-control" id="description" style="color:black;"></textarea>
						<span class="comment_Error" style="color:red;"></span>
					</div>
					<div class="form-group">
						<p style="color:black;">Лента с инструменти:</p>
						<div class="container" style="margin-left:0px; width:30%; border:2px solid black; border-style:dotted; padding-right:10px; padding-left:10px;">
							<a href="#" title="Избери снимка..." style="border-right:" ><span class="glyphicon glyphicon-camera" style="color:#8088b2; font-size:20px;"></span></a>
						</div>
						<input type="file" style="display:none;" name="comment_file"/>
					</div>
					<input type="hidden" id="post_id" value="<?php if(isset($_GET['postid'])){ echo $_GET['postid']; } ?>"/>
					<button type="submit" class="btn btn-primary" style="color:black;">Добави</button>
				</form>
			</div>
			<?php 
			}
			?>
			<div class="container content" id="comments_area" style="width:100%; height:auto; ">
				<?php 
				$com = mysqli_query($connect, "select comments.id as comid,comments.cdate as cdate, comments.userid as comuid, comments.description as comdesc, comments.pid as compid, users.userId as uid, users.userName as uname, users.firstname as firstname, users.lastname as lastname, users.photo as photo, users.level as user_level from comments inner join users on comments.userid = users.userId where comments.pid = '".$pid."' order by comments.id");
				$comcount = mysqli_num_rows($com);
				if($comcount > 0){ ?>
				
					<p style="color:black;"><span class="glyphicon glyphicon-comment"></span> <?php echo $comcount; ?> Коментар/a:</p><br> 
				 <div class="row" id="second_area">
				<?php 
					if(isset($_SESSION['user'])){
					$user_select = mysqli_query($connect, "select * from users where userId = '".$_SESSION['user']."'");
					$user_data = mysqli_fetch_array($user_select);
					$user_lev = $user_data['level'];
					if($user_lev == 2){
						while($comments = mysqli_fetch_array($com)){
						$firstname = $comments['firstname']; 
						$lastname = $comments['lastname'];
						 
				?>
				
					<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/<?php echo $comments['photo']; ?>" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;"><?php echo $firstname."&nbsp;".$lastname; ?></b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: <?php /*$tz = 'Europe/Sofia'; $dt = new DateTime($comments['cdate'], new DateTimeZone($tz)); echo $dt->format('d M Y, H:i:s');*/  setlocale(LC_TIME, 'bg_BG.UTF-8'); echo strftime("%e %B, %A %Y", strtotime($comments['cdate']));  //echo date('F j, Y g:i a', strtotime($comments['cdate']));?></i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;"><?php echo $comments['comdesc']; ?></p>
								
							</div>
							<a href="#" data-toggle="popover" class="comment_options" style="position:absolute; top:0px; right:2px;" id="<?php echo $comments['comid']; ?>"><span style="color: #b7b6ae;" class="glyphicon glyphicon-chevron-down"></span></a>
						</div>
					</div>
				 <?php   }  
					}else{
						while($comments = mysqli_fetch_array($com)){
						$firstname = $comments['firstname']; 
						$lastname = $comments['lastname']; 
						if($user_lev == 1 && $comments['comuid'] == $_SESSION['user']){  ?>
					<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/<?php echo $comments['photo']; ?>" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;"><?php echo $firstname."&nbsp;".$lastname; ?></b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: <?php /*$tz = 'Europe/Sofia'; $dt = new DateTime($comments['cdate'], new DateTimeZone($tz)); echo $dt->format('d M Y, H:i:s');*/  setlocale(LC_TIME, 'bg_BG.UTF-8'); echo strftime("%e %B, %A %Y", strtotime($comments['cdate']));  //echo date('F j, Y g:i a', strtotime($comments['cdate']));?></i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;"><?php echo $comments['comdesc']; ?></p>
								
							</div>
							<a href="#" data-toggle="popover" class="comment_options" style="position:absolute; top:0px; right:2px;" id="<?php echo $comments['comid']; ?>"><span style="color: #b7b6ae;" class="glyphicon glyphicon-chevron-down"></span></a>
						</div>
					</div>
				<?php	}
						else{ ?>
					<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/<?php echo $comments['photo']; ?>" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;"><?php echo $firstname."&nbsp;".$lastname; ?></b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: <?php /*$tz = 'Europe/Sofia'; $dt = new DateTime($comments['cdate'], new DateTimeZone($tz)); echo $dt->format('d M Y, H:i:s');*/  setlocale(LC_TIME, 'bg_BG.UTF-8'); echo strftime("%e %B, %A %Y", strtotime($comments['cdate']));  //echo date('F j, Y g:i a', strtotime($comments['cdate']));?></i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;"><?php echo $comments['comdesc']; ?></p>
								
							</div>
						</div>
					</div>	
				<?php		}
						}
					} ?>
					
				<?php	}
				else{ 
					while($comments = mysqli_fetch_array($com)){
					$firstname = $comments['firstname']; 
					$lastname = $comments['lastname'];
				?>
					<div class="col-sm-12 col-xs-12 col-md-8 pull-left" class="comment_div">
						<div class="media pull-left media-responsive" id="media" style="margin-bottom:30px; position:relative;">
							<div class="media-left">
								<img src="/new1/uploads/<?php echo $comments['photo']; ?>" class="media-object" width="50" height="50" />
							</div>
							<div class="media-body">	
								<h4 class="media-heading" style="padding-right:5px;"><b style="color:black;"><?php echo $firstname."&nbsp;".$lastname; ?></b> <small style="word-wrap:break-word; word-break:break-all;"><i>Написан на: <?php /*$tz = 'Europe/Sofia'; $dt = new DateTime($comments['cdate'], new DateTimeZone($tz)); echo $dt->format('d M Y, H:i:s');*/  setlocale(LC_TIME, 'bg_BG.UTF-8'); echo strftime("%e %B, %A %Y", strtotime($comments['cdate']));  //echo date('F j, Y g:i a', strtotime($comments['cdate']));?></i></small></h4>
								<p style="word-wrap:break-word; word-break:break-all; padding-right:5px; color:black;"><?php echo $comments['comdesc']; ?></p>
								
							</div>
						</div>
					</div>
				<?php }
				}
				?>
			</div>
			<?php }else{
			            echo "<p style=\"color:black;\">Не съществуват коментари за този случай.</p>";
				 }
	        ?>
			
			 </div>	
	</div>
	<div class="container-fluid text-center" id="footer"><h2>Hello</h2></div>
</body>
</html>