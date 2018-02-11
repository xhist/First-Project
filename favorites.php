<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	$(document).on('click', '.delete', function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url:"/new1/delete",
			type:"POST",
			dataType:"JSON",
			data:{id:id},
			success:function(response){
				$("#main").html(response.output);
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
	padding-top:50px;
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
	border-left:1px solid black;
	border-right:1px solid black;
	background:white;
	margin-top:0px;
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
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
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
					header("Location: /new1/favorites/login");
					exit;
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
	<div class="container text-left" id="main" style="color:black;">
		
         	<?php 
				include "dbconfig.php";
				$query = "select blog.id as postid, blog.header as header, favorites.pid as fid, favorites.userid as fuserid, favorites.favid as favid from blog inner join favorites  on blog.id = favorites.pid where favorites.userid = '".$_SESSION['user']."' order by favorites.pid";
				$favorites = mysqli_query($connect, $query);
				$rownum = mysqli_num_rows($favorites);
				if($rownum > 0){ ?>
					<div class="container text-center" style="width:100%; margin-top:30px;">
									<h3 style="color:black;">Списък с любими:</h3>
							  </div> 
				<?php	while($row = mysqli_fetch_array($favorites)){ ?>
						
						<div class="container text-center" style="width:100%; margin-top:30px; color:black;">
								<table style="color:black; width:100%;">
									<tr><td style="width:10%; padding:15px 15px 15px 15px; text-align:center;"><?php echo $row['fid']; ?></td>
										<td style="width:60%; padding-top:15px; padding-bottom:15px; padding-left:15px; text-align:left;">
											<a href="/new1/case/<?php echo $row['fid']; ?>/" style="text-decoration:none;"><?php echo $row['header']; ?></a>
										</td>
										<td style="width:30%;">
										<button type="submit" class="btn btn-danger delete" id="<?php echo $row['favid']; ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;Изтрий</button>
										</td>
									</tr>
								</table>
						</div> 
				<?php 
					}
				}else {
					echo "<div class=\"container text-center\" style=\"width:100%; margin-top:30px;\">
									<h3 style=\"color:black;\">Не разполагате с любими случаи.</h3>
						  </div>";
				}
		?>
	</div>
	<div class="container-fluid text-center" id="footer"><h1>Hello</h1></div>
</body>
</html>