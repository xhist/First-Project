<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	//console.log(window.location.pathname);
	var url = window.location.pathname;
	$(document).on('click', '.cases', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		$.ajax({
			url:"/new1/register_session",
			type:"POST",
			data:{url:url},
			success:function(response){
				window.location.href = href;
				
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
});
</script>
</head>
<style>
html body {
    height: 100%;
    width: 100%;
	margin:0px;
	padding:0px;
    position:absolute;
	background:gray;
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
	line-height:100px;
    width: 100%;
    background: red;
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
#main {
	min-height:100%;
    width:80%;
    height:auto;
	background:white;
	margin-top:50px;
	margin-bottom:0px;
	color:white;
}
.navbar-inverse .navbar-toggle .icon-bar {
	background:black;
}
</style>
<body>
     <div class="navbar navbar-inverse navbar-fixed-top" id="header">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="background:white;">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/new1" id="brand" style="color:black;">Начало</a>
    </div>
    <div class="navbar-collapse collapse" id="searchbar">
     
      <ul class="nav navbar-nav navbar-right">
		    <?php
				ob_start();
				session_start();
				require_once 'dbconfig.php';
				
	
				if( !isset($_SESSION['user']) ) {
					if(isset($_GET['cid'])){ 	?>
				<li><a id="hr" href="/new1/category/<?php echo strip_tags($_GET['cid']); ?>/register"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
				<li><a id="hr" href="/new1/category/<?php echo strip_tags($_GET['cid']); ?>/login"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
				<?php 
					}else{ ?>
				<li><a id="hr" href="/new1/register/"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
				<li><a id="hr" href="/new1/login/"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>		
				<?php	
					}
				}else{
				// select loggedin users detail
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
	<div class="container text-center" id="main">
			<div class="container-fluid" style="color:black; margin-top:20px; margin-bottom:20px; background:#e8e8ed;">
				<h4 align="center"><b>Категории на случаите:</b></h4>
				<div class="row" style="margin:0 auto; height:auto; padding-top:10px; padding-left:10px; padding-right:10px; width:100%; ">
					<?php
                        include "dbconfig.php";					
						$result = mysqli_query($connect, "select * from cats");
						while ($row = mysqli_fetch_assoc($result)){
						    echo "<div class=\"col-xs-12 col-sm-12 col-md-6 \" style=\"margin-bottom:10px; height:50px; border-radius:10px; font-size:20px; text-align:center; padding-top:8px; padding-bottom:8px;\"><a class=\"cat_links\" href=\"/new1/category/".$row['cid']."/\" style=\"color:black; text-decoration:none;\">".$row['cname']."</a></div>";
						}
					?>
				</div>
			</div>
			
			<div class="container-fluid" id="results" style="width:100%; height:auto; color:black;">
			
			    <?php
                 include "dbconfig.php";				
				 if(isset($_GET['cid'])){
					$catid = strip_tags($_GET['cid']);
					$cat_row = mysqli_query($connect, "select * from cats where cid='".$catid."'");
					$cat_result = mysqli_fetch_array($cat_row);
					echo '<h4 align=\"center\"><b>Списък със случаите за категория '.$cat_result['cname'].':</b></h4>';
                    $row1 = mysqli_query($connect, "select * from blog where cid=".$catid." order by id");
				    if(mysqli_num_rows($row1) > 0){
                    while($results = mysqli_fetch_array($row1)){
						echo "<table border=0 style=\"font-size:15px;\">
						      <tr>
							  <td style=\"padding-right:5px; padding-left:5px;\">".$results['id']."</td>
							  <td><a class='cases' href=\"/new1/case/".$results['id']."/\" style=\"text-decoration:none;\">".$results['header']."</a></td>
						      </tr>
						      </table>";
					}					
				    }
				    else {
					   echo "<p>Няма налични случаи за тази категория!<p>";
				    }
				 }
				 else {
					 $row1 = mysqli_query($connect, "select * from blog order by id");
					 echo '<h4 align=\"center\"><b>Списък със случаите:</b></h4>';
				 while($result1 = mysqli_fetch_array($row1)){
					echo "<table border=0 style=\"font-size:15px;\">
						  <tr>
						  <td style=\"padding-right:5px; padding-left:5px;\">".$result1['id']."</td>
						  <td><a class='cases' href=\"/new1/case/".$result1['id']."/\" style=\"text-decoration:none;\">".$result1['header']."</a></td>
						  </tr>
						  </table>";
				    }
				 }
				  
			    ?>
			</div>
	</div>
	<div class="container-fluid text-center" id="footer"><h1>Hello</h1></div>
</body>
</html>