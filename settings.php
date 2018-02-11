<?php 
	session_start();
	require_once 'dbconfig.php';
	ob_start();
	
	if( !isset($_SESSION['user']) ) { 
		header("Location: /new1/settings/login");
		exit;
	}
?>
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".close.closebuttons").click(function(e){
		$(this).parent('div').hide();
		e.preventDefault();
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
	
	$("#changeimg").submit(function(e){
		if($("#imagesuc").is(":visible")){
			$("#imagesuc").hide();
		}
		if($("#imagedanger").is(":visible")){
			$("#imagedanger").hide();
		}
		
		$.ajax({
			url:"/new1/changeavatar/",
			type:"POST",
			dataType:"JSON",
			data: new FormData(this),
			contentType: false,       
			cache: false,             
			processData:false,
			success:function(response){
				
				if(response.success == false){
					$("#imageerr").text(response.imageError);
				}
				else{
					if(response.query == true){
						$("#changeimg")[0].reset();
						$(".text-danger.image").text("");
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#img").attr('src', response.image);
						$("#imagesuc").show();
					}
					else{
						$("#changeimg")[0].reset();
						$(".text-danger.image").text("");
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#imagedanger").show();
					}
				}
			}
		});
		e.preventDefault();
	});
	
	
	$("#changemail").submit(function(e){
		if($("#emailsuc").is(":visible")){
			$("#emailsuc").hide();
		}
		if($("#emaildanger").is(":visible")){
			$("#emaildanger").hide();
		}
		
		var email = $("#email").val();
		var formdata = "email="+email;
		$.ajax({
			url:"/new1/changemail/",
			type:"POST",
			dataType:"JSON",
			data:formdata,
			success:function(response){
				if(response.success == false){
					$("#emailerr").text(response.emailError);
				}
				else{
					if(response.query == true){
						$("#changemail")[0].reset();
						$(".text-danger.email").text("");
						$("#useremail").text(response.email);
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#emailsuc").show();
					}
					else{
						$("#changemail")[0].reset();
						$(".text-danger.email").text("");
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#emaildanger").show();
					}
				}
			}
		});
		e.preventDefault();
	});
	
	
	$("#changepass").submit(function(e){
		if($("#passsuc").is(":visible")){
			$("#passsuc").hide();
		}
		if($("#passdanger").is(":visible")){
			$("#passdanger").hide();
		}
		var password = $("#password").val();
		var newpassword = $("#newpassword").val();
		var confirmpassword = $("#confirmpassword").val();
		var formdata = "password="+password+"&newpassword="+newpassword+"&confirmpassword="+confirmpassword;
		$.ajax({
			url:"/new1/changepass/",
			type:"POST",
			dataType:"JSON",
			data: formdata,
			success:function(response){
				if(response.success == false){
					$("#passerr").text(response.passwordError);
					$("#newpasserr").text(response.newpasswordError);
					$("#confpasserr").text(response.confirmpasswordError);
				}
				else{
					if(response.query == true){
						$("#changepass")[0].reset();
						$(".text-danger.pass").text("");
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#passsuc").show();
					}
					else{
						$("#changepass")[0].reset();
						$(".text-danger.pass").text("");
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#passdanger").show();
					}
				}
			}
		});
		e.preventDefault();
	});
});
</script>
</head>
<style>
html body {
    height: 100%;
    width: 100%;
    position:absolute;
	padding-top:50px;
	margin:0px;
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
#drop {
	color:black;
	background:white;
}
#footer{
	height: 100px;
    width: 100%;
    background: red;
	bottom:0px;
	left:0px;
	right:0px;
	margin-top:30px;
	position:relative;
}
#main {
    min-height:100%;
    width: 80%;
	height:auto;
	border-left:1px solid black;
	border-right:1px solid black;
	margin-bottom:-30px;
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
        <span class="icon-bar" style="background:black;"></span>
        <span class="icon-bar" style="background:black;"></span>
        <span class="icon-bar" style="background:black;"></span>
      </button>
      <a class="navbar-brand" href="/new1" id="brand" style="color:black;">Начало</a>
    </div>
    <div class="navbar-collapse collapse" id="searchbar">
     
      <ul class="nav navbar-nav navbar-right">
		<?php	
				
				if(isset($_SESSION['user'])){
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
	<div class="container" id="main">

				<div class="alert alert-success alert-dismissable" style="margin-top:30px; display:none;" id="emailsuc">
				<a href="#" class="close closebuttons" aria-label="close">×</a>
				<span class="glyphicon glyphicon-info-sign"></span> Имейл адресът успешно беше променен.
                </div>
	
            	<div class="alert alert-danger alert-dismissable" style="margin-top:30px;display:none;" id="emaildanger">
				<a href="#" class="close closebuttons" aria-label="close">×</a>
				<span class="glyphicon glyphicon-info-sign"></span> Възникна грешка с обновяването на имейл адресът.
                </div>	

            	<div class="alert alert-success alert-dismissable" style="margin-top:30px; display:none;" id="passsuc">
				<a href="#" class="close closebuttons" aria-label="close">×</a>
				<span class="glyphicon glyphicon-info-sign"></span> Паролата беше успешно променена.
                </div>

            	<div class="alert alert-danger alert-dismissable" style="margin-top:30px; display:none;" id="passdanger">
				<a href="#" class="close closebuttons" aria-label="close">×</a>
				<span class="glyphicon glyphicon-info-sign"></span> Възникна грешка с обновяването на паролата.
                </div>
            	
            	<div class="alert alert-success alert-dismissable" style="margin-top:30px; display:none;" id="imagesuc">
				<a href="#" class="close closebuttons" aria-label="close">×</a>
				<span class="glyphicon glyphicon-info-sign"></span> Профилната снимка успешно беше променена.
                </div>

            	<div class="alert alert-danger alert-dismissable" style="margin-top:30px; display:none;" id="imagedanger">
				<a href="#" class="close closebuttons" aria-label="close">×</a>
				<span class="glyphicon glyphicon-info-sign"></span> Възникна грешка с обновяването на профилната снимка.
                </div>
            	

	<?php 
		  $query = mysqli_query($connect, "select * from users where userId='".$_SESSION['user']."'");
		  while($row = mysqli_fetch_array($query)){ ?>
		<div class="container" style="width:100%;"> 
		<h2 style="color:black; margin-bottom:40px;">Промяна на профилната снимка</h2>
		<div class="row" style="width:auto;">
			<div class="col-md-3 col-xs-12 col-sm-12"><img id="img" src="/new1/uploads/<?php echo $row['photo']; ?>" class="img-responsive" alt="Profile image" width="600" height="700"></div>
			<div class="col-md-9 col-xs-12 col-sm-12">
				<form method="post" enctype="multipart/form-data" id="changeimg" autocomplete="off">
					
					<div class="form-group row" style="margin-bottom:30px; margin-top:30px;">
					<p class="col-md-12 col-xs-12 col-sm-12" style="color:black; margin-bottom:20px;"><b>Изберете снимка:</b></p>
					<input name="image" class="col-md-12 col-xs-12 col-sm-12" type="file" value="Select" style="color:black;" />
					<span class="col-md-12 col-xs-12 col-sm-12 text-danger image" id="imageerr"></span>
					</div>
					<button type="submit" class="btn btn-primary" id="uploadBtn">Промени</button>
				</form>
			</div>
		</div>
		</div>
		            <hr style="background-color:black; border:1px solid black;"/>
		<div class="container" style="width:100%; margin-top:30px;">
			<h2 style="color:black; margin-bottom:30px;">Детайли за профила.</h2>
			<form class="form-horizontal" method="post" id="changemail" role="form" style="margin-bottom:50px;" autocomplete="off">
			

			<div class="row" style="width:100%;">
			<h4 class="col-md-12 col-xs-12 col-sm-12" style="color:black; margin-bottom:30px;">Променя на имейл адрес:</h4>
				<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="form-group">
					<p class="col-md-3" style="color:black; text-align:center;"><b>Потребителско име:</b></p>
					<p class="col-md-9" style="text-align:left; color:black;"><b><?php echo $row['userName']; ?></b></p>
				</div>
				</div>
				
				<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="form-group" style="margin-top:15px;">
					<p class="col-md-3" style="color:black; text-align:center;"><b>Текущ имейл адрес:</b></p>
					<p class="col-md-9" style="text-align:left; color:black;"><b id="useremail"><?php echo $row['userEmail']; ?></b></p>	
			    </div>
				</div>
				
				<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="form-group" style="margin-top:15px;">
					<p class="col-md-3 control-label" style="color:black; text-align:center;"><b>Промяна на имейл адрес:</b></p>
					<div class="col-md-9">
						<input type="text" class="form-control" id="email" name="email" placeholder="Имейл адрес" style="color:black;">
						<span class="text-danger email" id="emailerr"></span>
					</div>	
				</div>
				</div>
				
				<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:30px; text-align:right;">
				<button type="submit" name="update" class="btn btn-primary" >Промени</button>
				</div>
			</div>
			</form>
			
			<form method="post" role="form" id="changepass" class="form-horizontal" style="margin-bottom:50px;" autocomplete="off">
			
				<div class="row" style="width:100%;">
				<h4 class="col-md-12 col-xs-12 col-sm-12" style="color:black; margin-bottom:30px;">Промяна на парола:</h4>
				<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="form-group" style="margin-bottom:30px;">
					<p class="col-md-3 control-label" style="color:black; text-align:center;"><b>Текуща парола:</b></p>
					<div class="col-md-9">
						<input id="password" type="password" class="form-control" placeholder="Текуща парола" style="color:black;">
						<span class="text-danger pass" style="padding-bottom:15px;" id="passerr"></span>
					</div>	
				</div>
				</div>
				
				<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="form-group" style="margin-bottom:30px;">
					<p class="col-md-3 control-label" style="color:black; text-align:center;"><b>Нова парола:</b></p>
					<div class="col-md-9">
						<input id="newpassword" type="password" class="form-control" placeholder="Нова парола" style="color:black;">
						<span class="text-danger pass" style="padding-bottom:15px;" id="newpasserr"></span>
					</div>	
				</div>
				</div>
				
				<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="form-group" style="margin-bottom:30px;">
					<p class="col-md-3 control-label" style="color:black; text-align:center;"><b>Потвърдете новата парола:</b></p>
					<div class="col-md-9">
						<input id="confirmpassword" type="password" class="form-control" placeholder="Потвърдете новата парола" style="color:black;">
						<span class="text-danger pass" style="padding-bottom:15px;" id="confpasserr"></span>
					</div>	
				</div>
				</div>
				
				<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:30px; text-align:right;">
					<button type="submit" name="updatepass" class="btn btn-primary" >Промени</button>
				</div>
				</div>
			</form>
		</div>
		<?php 
		}	
		?>
	</div>
	<div class="container-fluid text-center" id="footer"><h1>Hello</h1></div>
</body>
</html>