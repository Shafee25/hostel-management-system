<?php
session_start();
include('includes/config.php');
if(isset($_POST['login']))
{
$email=$_POST['email'];
$password=$_POST['password'];
$stmt=$mysqli->prepare("SELECT email,password,id FROM userregistration WHERE email=? and password=? ");
				$stmt->bind_param('ss',$email,$password);
				$stmt->execute();
				$stmt -> bind_result($email,$password,$id);
				$rs=$stmt->fetch();
				$stmt->close();
				$_SESSION['id']=$id;
				$_SESSION['login']=$email;
				$uip=$_SERVER['REMOTE_ADDR'];
				$ldate=date('d/m/Y h:i:s', time());
				if($rs)
				{
             $uid=$_SESSION['id'];
             $uemail=$_SESSION['login'];
$ip=$_SERVER['REMOTE_ADDR'];
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
$city = $addrDetailsArr['geoplugin_city'];
$country = $addrDetailsArr['geoplugin_countryName'];
$log="insert into userLog(userId,userEmail,userIp,city,country) values('$uid','$uemail','$ip','$city','$country')";
$mysqli->query($log);
if($log)
{
header("location:dashboard.php");
				}
}
				else
				{
					echo "<script>alert('Invalid Username/Email or password');</script>";
				}
			}
				?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Student Hostel Registration</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
function valid()
{
if(document.registration.password.value!= document.registration.cpassword.value)
{
alert("Password and Re-Type Password Field do not match  !!");
document.registration.cpassword.focus();
return false;
}
return true;
}
</script>
<style>
	/* *{
	margin:0 ;
	padding:0 ;
} */

/* body{
	height:100vh ;
	width: 100%;
	background: url(9.jpg);
	background-repeat: no-repeat ;
	background-size:cover ;
} */


.main{
	top:48% ;
	left:42%;
	position: absolute;
	transform: translate(-48%,-42%);
	width: 350px;
	background-color:#ffffff90 ;
	padding: 40px;
	border-radius:20px ;
	height: 350px;
	margin-left: 250px;
}

h1{
	border-bottom: 2px solid silver;
	font-family:Georgia ;
	text-align: center;
	padding-bottom: 15px;
}

a{
	text-decoration: none;
	color: black;
}

#submit{
	height: 40px;
	width: 100%;
	border-radius: 40px;
	font-size: 20px;
	background-color: gray;
	border: none ;
	color: White;
	cursor:pointer ;
}


.in{
	font-size: 20px;
	border: none;
	border-bottom: 2px solid silver;
	background: none;
	padding-left: 20px;
	border-radius: 5px;
	width: 100%;
	height: 30px;
}

img{
	opacity: 0.9;
}
img{
	position: absolute;
	margin-top:-90px ;
	margin-left: 80px;
}

#girl{
	margin-top:5px ;
	margin-bottom:5px ;
	margin-left:1100px ;
	opacity: 80%;
	border-radius: 100px;
}
</style>
</head>
<body>

<div class="login-page bk-img" style="background-image: url(img/hstl.jpg);">

	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<!-- <div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h1 class="page-title h1 text-bold text-center bg-white" style="color:black">User Login </h1> -->

						<!-- <div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="well row pt-2x pb-3x bk-light">
							<div class="col-md-8 col-md-offset-2"> --> 

								<!-- <form action="" class="mt" method="post">
									
										<img src="img/login.png" alt="icon" height="100" width="100"><br>
										<h1 class="h1 text-bold text-center" style="color:black"> Login </h1>

										<label for="" class="text-uppercase text-sm">Email</label>
										<input type="text" placeholder="Email" name="email" class="form-control mb">
										<label for="" class="text-uppercase text-sm">Password</label>
										<input type="password" placeholder="Password" name="password" class="form-control mb">
										<input type="submit" name="login" class="btn btn-primary btn-block" value="login" >
								
								</form> -->
								<form action="" class="mt" method="post">
									<div class="main">
										<img src="img/login.png" alt="icon" height="100" width="100"><br>
											<h1>Login</h1><br>
											<input type="text" placeholder="Email" name="email" class="in"><br><br>
											<input type="password" placeholder="Password" name="password" class="in"><br><br>
											<input type="submit" name="login" value="login" id="submit"><br><br>
											Not a member?<a href="registration.php"> Sign Up </a>
									</div>
								</form>
							</div>
						</div>
						<!-- <div class="text-center text-light" style="color:black;">
							<a href="forgot-password.php" style="color:black;">Forgot password?</a>
						</div>
					</div>
				</div>
						</div>
							</div>
						</div>
					</div>
				</div> 	
			</div> -->
		 <!-- </div>
	</div>  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>

</html>