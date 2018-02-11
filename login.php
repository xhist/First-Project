<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#form1").submit(function(e){
		$(".text-danger").text("");
		var valid = true;
		$("#errordiv").hide();
		var username = $("#name").val();
		var password = $("#password").val();
		if(username == ""){
			$("#nameerror").text("Моля напишете вашето потребителско име.");
			valid = false;
		}
		if(password == ""){
			$("#passerror").text("Моля напишете вашата парола.");
			valid = false;
		}
		if(valid == true){
			$.ajax({
				url: "/new1/ajaxlogin/",
				type: "POST",
				dataType: "JSON",
				data: "name="+username+"&pass="+password,
				success: function(data){
					if(data.success == true){
						if($("#page").length > 0){
							var page_value = $("#page").val();
							window.location.href= "/new1/"+page_value;
						}else{
							window.location.href = "/new1";
						}
						
					}
					else{
						$("#errordiv").show();
					}
				}
			});
		}
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
});
</script>
</head>
<style>
html body {
    height: 100%;
    width: 100%;
    position:absolute;
}
#header{
    width: 100%;
    background: white;
	color:black;
	right:0px;
	left:0px;
	top:0px;
	margin-bottom:0px;
	position:relative;
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
#main {
    min-height:100%;
    width: 80%;
	height:auto;
	border-left:1px solid black;
	border-right:1px solid black;
	margin-bottom:0px;
	color:white;
}
.navbar-inverse .navbar-toggle .icon-bar {
	background:black;
}
</style>
<?php


	ob_start();
	session_start();
	require_once 'dbconfig.php';
	
	if(isset($_SESSION['user'])){
			header("Location: /new1");
			exit;
	}
	// it will never let you open index(login) page if session is set
	
	
?>
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
		<li id="userPage"><a href="/new1/register/" id="hr"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
        <li><a href="/new1/login/" id="hr"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>	
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
	<div class="row ">
	<div class="container col-md-5 col-xs-12 col-sm-10 col-md-offset-3 col-sm-offset-1">
    <h2 style="color:black; margin-bottom:30px; margin-top:30px; text-align:center;">Вход в системата</h2>
                <div class="form-group" style="display:none;" id="errordiv">
            	<div class="alert alert-danger" style="color:red;">
				<span class="glyphicon glyphicon-info-sign"></span> Грешно потребителско име или парола.
                </div>
            	</div>
             
	<form method="post" action="" autocomplete="off" id="form1" style="margin:0 auto;">	
            
            <div class="form-group">
				<label for="name" style="color:black;"><b>Потребителско име:</b></label>
            	<div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            	<input id="name" type="text" name="name" class="form-control" placeholder="Вашето потребителско име" maxlength="50">
                </div>
                <span class="text-danger" id="nameerror"></span>
            </div>
           
            <div class="form-group">
				<label for="password" style="color:black;"><b>Парола:</b></label>
            	<div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            	<input id="password" type="password" name="pass" class="form-control" placeholder="Вашата парола" maxlength="15">
                </div>
                <span class="text-danger" id="passerror"></span>
            </div>
			
			
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
				<?php if(isset($_GET['page'])){ ?>
				<input type="hidden" id="page" value="<?php echo str_replace('.php', '', $_GET['page']); ?>/"/>	
				<?php } ?>
            	<button type="submit" class="btn btn-block btn-primary responsive-width" name="login" style="min-width:10vw; width:auto;" id="login">Вход</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
          
			<div class="form-group">
            	<a href="/new1/<?php if(isset($_GET['page'])){ echo str_replace('.php', '', $_GET['page']); } ?>/register">Нямате акаунт? Създайте сега!</a>
            </div>

			
			
		
    </form>
	</div>
    </div>
	</div>
	<div class="container-fluid text-center" id="footer"><h1>Hello</h1></div>
</body>
</html>
<?php ob_end_flush(); ?>