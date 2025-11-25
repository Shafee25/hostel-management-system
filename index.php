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
    if($rs) {
        $uid=$_SESSION['id'];
        $uemail=$_SESSION['login'];
        $ip=$_SERVER['REMOTE_ADDR'];
        $geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
        $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
        $city = $addrDetailsArr['geoplugin_city'];
        $country = $addrDetailsArr['geoplugin_countryName'];
        $log="insert into userLog(userId,userEmail,userIp,city,country) values('$uid','$uemail','$ip','$city','$country')";
        $mysqli->query($log);
        if($log) { header("location:dashboard.php"); }
    } else {
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
    <title>Student Hostel Registration</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
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
            background: rgba(15, 23, 42, 0.6); 
            backdrop-filter: blur(3px);
        }

        /* ==================== HEADER (NAVBAR) ==================== */
        .brand {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 60px;
            background: rgba(20, 22, 35, 0.9) !important; 
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            z-index: 2000; 
            display: flex; 
            align-items: center; /* Vertically centers the content */
            padding: 0 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        
        /* FIXED LOGO STYLING */
        .brand .logo {
            font-size: 18px; /* Slightly smaller to fit cleanly */
            font-weight: 600; 
            color: #ffffff !important; 
            text-decoration: none !important; 
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            
            /* CRITICAL FIXES FOR ALIGNMENT */
            display: flex;
            align-items: center;
            height: 100%;
            white-space: nowrap; /* Prevents text from breaking into 2 lines */
        }
        
        /* Menu Button Position */
        .menu-btn { 
            color: #fff !important; 
            font-size: 20px; 
            cursor: pointer;
            margin-left: auto; /* Pushes button to the far right */
        }
        
        .ts-profile-nav { margin-left: 20px; }
        .ts-profile-nav li a { color: #fff !important; }

        /* ==================== SIDEBAR ==================== */
        .ts-sidebar {
            position: fixed;
            top: 60px; 
            left: 0; width: 250px; height: 100%;
            background: rgba(20, 22, 35, 0.9) !important; 
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255,255,255,0.1);
            z-index: 1000;
            padding-top: 20px;
        }

        .ts-sidebar-menu { padding: 0; list-style: none; }
        .ts-sidebar-menu li.ts-label {
            color: #ccc; 
            font-size: 12px; font-weight: 600; 
            text-transform: uppercase; padding: 15px 20px;
            letter-spacing: 1px;
        }
        .ts-sidebar-menu li a {
            display: block; padding: 12px 20px;
            color: rgba(255,255,255,0.9) !important; 
            text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
            font-size: 14px;
        }
        .ts-sidebar-menu li a:hover {
            background: rgba(108, 92, 231, 0.3); 
            padding-left: 25px; 
            color: #fff !important;
        }
        .ts-sidebar-menu li a i { margin-right: 15px; width: 20px; text-align: center; color: #a29bfe; }

        /* ==================== MAIN CONTENT ==================== */
        .content-wrapper {
            margin-left: 250px; 
            padding-top: 60px; 
            min-height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(20px);
            width: 100%; max-width: 400px;
            padding: 40px 30px; border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            text-align: center; position: relative;
        }

        .login-icon {
            width: 80px; height: 80px; object-fit: contain;
            margin-top: -80px; background: #fff;
            border-radius: 50%; padding: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); margin-bottom: 15px;
        }

        h1 { font-size: 24px; font-weight: 600; color: #333; margin-bottom: 25px; border:none; }
        
        .in {
            width: 100%; padding: 12px 15px; margin-bottom: 20px;
            font-size: 15px; border: 1px solid #ddd; border-radius: 8px;
            background-color: #f0f4ff; 
            outline: none; transition: 0.3s;
        }
        .in:focus { border-color: #6c5ce7; background-color:#fff; box-shadow: 0 0 8px rgba(108, 92, 231, 0.2); }

        #submit {
            width: 100%; padding: 12px; border: none; border-radius: 8px;
            background: linear-gradient(135deg, #6c5ce7, #8e44ad);
            color: white; font-size: 16px; font-weight: 600; cursor: pointer;
            transition: 0.3s; margin-bottom: 20px;
        }
        #submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4); }

        /* ==================== MOBILE RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .ts-sidebar { display: none; } 
            .content-wrapper { margin-left: 0; padding: 20px; padding-top: 80px; }
            .brand .logo { font-size: 15px; } /* Smaller text on mobile to prevent overflow */
        }
    </style>
</head>
<body>

    <div class="login-bg"></div>

    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/sidebar.php');?>
        
        <div class="content-wrapper">
            <form action="" method="post" style="width:100%; max-width:400px;">
                <div class="main-card">
                    <img src="img/login.png" alt="icon" class="login-icon">
                    <h1>User Login</h1>
                    
                    <input type="text" placeholder="Email Address" name="email" class="in" required>
                    <input type="password" placeholder="Password" name="password" class="in" required>
                    
                    <input type="submit" name="login" value="Login" id="submit">
                    
                    <div style="font-size: 14px;">
                        Not a member? <a href="registration.php" style="color:#6c5ce7;font-weight:600;">Sign Up</a>
                    </div>
                </div>
            </form>
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
</body>
</html>