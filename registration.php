<?php
session_start();
include('includes/config.php');
if(isset($_POST['submit']))
{
    $regno=$_POST['regno'];
    $fname=$_POST['fname'];
    $mname=$_POST['mname'];
    $lname=$_POST['lname'];
    $gender=$_POST['gender'];
    $contactno=$_POST['contact'];
    $emailid=$_POST['email'];
    $password=$_POST['password'];
    $query="insert into userRegistration(regNo,firstName,middleName,lastName,gender,contactNo,email,password) values(?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc=$stmt->bind_param('sssssiss',$regno,$fname,$mname,$lname,$gender,$contactno,$emailid,$password);
    $stmt->execute();
    echo"<script>alert('Student Successfully registered');</script>";
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>User Registration</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* ==================== GLOBAL RESET ==================== */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0; padding: 0;
            overflow-x: hidden;
            background-color: #1a1a1a;
        }

        /* ==================== BACKGROUND IMAGE ==================== */
        .login-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url(img/image_1.png);
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        .login-bg::before {
            content: "";
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6); /* Dark Overlay */
            backdrop-filter: blur(4px);
        }

        /* ==================== HEADER (NAVBAR) ==================== */
        /* Note: Header styles are inherited from header.php, but we ensure overrides here */
        .brand {
            background: rgba(20, 22, 35, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        /* ==================== SIDEBAR ==================== */
        .ts-sidebar {
            background: rgba(20, 22, 35, 0.9) !important;
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        /* ==================== MAIN CONTENT ==================== */
        .content-wrapper {
            margin-left: 250px;
            padding-top: 80px; /* Space for header */
            padding-bottom: 40px;
            min-height: 100vh;
        }

        /* GLASS CARD FOR REGISTRATION */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            margin: 0 auto;
            max-width: 800px; /* Wider than login for form fields */
        }

        .page-title {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        /* FORM STYLING */
        h2.card-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
            border-bottom: 2px solid #6c5ce7;
            padding-bottom: 10px;
            display: inline-block;
        }

        label {
            color: #555;
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            box-shadow: none;
            font-size: 14px;
            color: #333;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #6c5ce7;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.1);
        }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(135deg, #6c5ce7, #8e44ad) !important;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }

        .btn-default {
            background: transparent;
            border: 1px solid #ccc;
            border-radius: 8px;
            color: #666;
            padding: 10px 30px;
        }
        
        .btn-default:hover {
            background: #eee;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .content-wrapper { margin-left: 0; padding: 20px; padding-top: 80px; }
            .glass-card { padding: 20px; }
        }
    </style>

    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
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
</head>
<body>
    
    <!-- Background -->
    <div class="login-bg"></div>

	<?php include('includes/header.php');?>
    
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
        
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title" style="margin-top: 50px;">Student Registration</h2>

                        <!-- Glass Card Form -->
						<div class="glass-card">
                            <div class="text-center">
                                <h2 class="card-title">Fill Information</h2>
                            </div>
                            
							<form method="post" action="" name="registration" onSubmit="return valid();">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Registration No : </label>
                                            <input type="text" name="regno" id="regno" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>First Name : </label>
                                            <input type="text" name="fname" id="fname" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Middle Name : </label>
                                            <input type="text" name="mname" id="mname" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Last Name : </label>
                                            <input type="text" name="lname" id="lname" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender : </label>
                                            <select name="gender" class="form-control" required="required">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact No : </label>
                                            <input type="text" name="contact" id="contact" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email ID : </label>
                                    <input type="email" name="email" id="email" class="form-control" onBlur="checkAvailability()" required="required">
                                    <span id="user-availability-status" style="font-size:12px; color:red;"></span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password : </label>
                                            <input type="password" name="password" id="password" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm Password : </label>
                                            <input type="password" name="cpassword" id="cpassword" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center" style="margin-top: 20px;">
                                    <button class="btn btn-default" type="button" onclick="window.history.back();">Cancel</button>
                                    <input type="submit" name="submit" Value="Register" class="btn btn-primary">
                                </div>

                            </form>
						</div>
                        <!-- End Glass Card -->
                        
					</div>
				</div> 	
			</div>
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
    
	<script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data:'emailid='+$("#email").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){
                event.preventDefault();
                alert('error');
            }
        });
    }
    </script>
</body>
</html>