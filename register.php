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
		
		$("#sucdiv").hide();
		var username = $("#name").val();
		var password = $("#password").val();
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var email = $("#email").val();
		
		var formdata = "name="+username+"&pass="+password+"&firstname="+firstname+"&lastname="+lastname+"&email="+email;
		$.ajax({
				url:"/new1/reg/",
				type:"POST",
				dataType:"JSON",
				data: formdata,
				success:function(response){
					if(response.success == false){
					$("#nameerror").text(response.username);
					$("#firsterror").text(response.firstname);
					$("#lasterror").text(response.lastname);
					$("#emailerror").text(response.email);
					$("#passerror").text(response.password);
					}else{
					$("#form1")[0].reset();
					$("#sucdiv").show();
					$(".text-danger").text("");
					}
				}
		});
		
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
	<div class="container col-md-4 col-xs-12 col-sm-10 col-md-offset-4 col-sm-offset-1">
    <h2 style="color:black; margin-bottom:30px; margin-top:30px; text-align:center;">Регистрация в системата</h2>
                <div class="form-group" style="display:none;" id="sucdiv">
            	<div class="alert alert-success">
				<span class="glyphicon glyphicon-info-sign"></span> Успешно се регистрирахте. Можете да влезете в акаунта си от <a href="/new1/<?php if(isset($_GET['page'])){ echo str_replace('.php', '', $_GET['page']); } ?>/login/">тук</a>.
                </div>
            	</div>
             
	<form method="post" action="" autocomplete="off" id="form1" >	
            
            <div class="form-group">
				<label for="name" style="color:black;"><b>Потребителско име:</b></label>
            	<div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            	<input id="name" type="text" name="name" class="form-control" placeholder="Вашето потребителско име" maxlength="50">
                </div>
                <span class="text-danger" id="nameerror"></span>
            </div>
           
            <div class="form-group">
				<label for="name" style="color:black;"><b>Име:</b></label>
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input id="firstname" type="text" name="firstname" class="form-control" placeholder="Вашето име" maxlength="50">
                </div>
                <span class="text-danger" id="firsterror"></span>
            </div>
            
			
            <div class="form-group">
				<label for="name" style="color:black;"><b>Фамилия:</b></label>
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input id="lastname" type="text" name="lastname" class="form-control" placeholder="Вашата фамилия" maxlength="50">
                </div>
                <span class="text-danger" id="lasterror"></span>
            </div>
            
			
            <div class="form-group">
				<label for="email" style="color:black;"><b>Имейл адрес:</b></label>
            	<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input id="email" type="email" name="email" class="form-control" placeholder="Вашият имейл адрес" maxlength="40">
                </div>
                <span class="text-danger" id="emailerror"></span>
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
            	<button type="submit" class="btn btn-block btn-primary responsive-width" name="signup" style="min-width:10vw; width:auto;" id="signup">Регистриране</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>

			
			
		
    </form>
	</div>
    </div>
	</div>
	<div class="container-fluid text-center" id="footer"><h1>Hello</h1></div>
</body>
<?php ob_end_flush(); ?>
</html>