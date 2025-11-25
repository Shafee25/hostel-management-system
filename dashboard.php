<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#3e454c">

    <title>User Dashboard</title>

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
        .global-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url(img/image_1.png);
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        .global-bg::before {
            content: "";
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.7); /* Darker overlay for dashboard readability */
            backdrop-filter: blur(5px);
        }

        /* ==================== GLASS HEADER (NAVBAR) ==================== */
        .brand {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 60px;
            background: rgba(20, 22, 35, 0.9) !important; /* Dark Glass */
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            z-index: 2000;
            display: flex; 
            align-items: center; 
            padding: 0 0 0 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .brand .logo {
            font-size: 18px; font-weight: 600; color: #ffffff !important;
            text-decoration: none !important; font-family: 'Poppins', sans-serif;
            text-transform: uppercase; letter-spacing: 1px;
            display: flex; align-items: center; height: 100%; white-space: nowrap;
        }

        /* FIX: Push the Account Section to the Right */
        .ts-profile-nav { 
            margin-left: auto; /* This pushes it to the far right */
            display: flex;
            align-items: center;
        }
        
        .ts-profile-nav li a { color: #fff !important; }
        .ts-account a { color: #fff !important; }
        .ts-account ul { background: rgba(20, 22, 35, 0.95); } /* Dark glass for dropdown */

        .menu-btn { 
            color: #fff !important; 
            font-size: 20px; 
            cursor: pointer; 
            margin-left: 20px; /* Space between logo and menu if visible */
            margin-right: 10px;
        }

        /* ==================== GLASS SIDEBAR ==================== */
        .ts-sidebar {
            position: fixed;
            top: 60px; left: 0; width: 250px; height: 100%;
            background: rgba(20, 22, 35, 0.9) !important; /* Dark Glass */
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255,255,255,0.1);
            z-index: 1000;
            padding-top: 20px;
        }

        .ts-sidebar-menu { padding: 0; list-style: none; }
        .ts-sidebar-menu li.ts-label {
            color: #ccc; font-size: 12px; font-weight: 600; 
            text-transform: uppercase; padding: 15px 20px; letter-spacing: 1px;
        }
        .ts-sidebar-menu li a {
            display: block; padding: 12px 20px;
            color: rgba(255,255,255,0.9) !important; /* Force White Links */
            text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s; font-size: 14px;
        }
        .ts-sidebar-menu li a:hover {
            background: rgba(108, 92, 231, 0.3); padding-left: 25px; color: #fff !important;
        }
        .ts-sidebar-menu li a i { margin-right: 15px; width: 20px; text-align: center; color: #a29bfe; }

        /* ==================== CONTENT STYLING ==================== */
        .content-wrapper {
            margin-left: 250px;
            padding-top: 80px;
            min-height: 100vh;
        }

        .page-title {
            color: #fff;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 40px;
            text-shadow: 0 4px 4px rgba(0,0,0,0.3);
        }

        /* DASHBOARD CARDS */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
            color: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .glass-panel:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Decorative Line */
        .glass-panel::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        }

        .panel-profile .stat-icon { color: #f1c40f; }
        .panel-room .stat-icon { color: #e74c3c; }

        .stat-icon { font-size: 50px; margin-bottom: 15px; opacity: 0.9; }
        .stat-title { font-size: 24px; font-weight: 500; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; }

        .glass-btn {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-decoration: none !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: 0.3s;
            font-size: 14px;
        }
        .glass-btn:hover { background: #fff; color: #333; }

        /* Responsive */
        @media (max-width: 768px) {
            .ts-sidebar { display: none; }
            .content-wrapper { margin-left: 0; padding: 20px; padding-top: 80px; }
            .brand .logo { font-size: 15px; }
        }
    </style>
</head>

<body>

    <!-- Shared Background -->
    <div class="global-bg"></div>

    <?php include("includes/header.php");?>

    <div class="ts-main-content">
        <?php include("includes/sidebar.php");?>
        
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        
                        <h2 class="page-title text-center" style="margin-top: 50px;">User Dashboard</h2>

                        <div class="row">
                            <div class="col-md-2"></div>
                            
                            <!-- Profile Card -->
                            <div class="col-md-4">
                                <div class="glass-panel panel-profile">
                                    <div class="stat-icon"><i class="fa fa-user"></i></div>
                                    <div class="stat-title">My Profile</div>
                                    <a href="my-profile.php" class="glass-btn">View Details <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Room Card -->
                            <div class="col-md-4">
                                <div class="glass-panel panel-room">
                                    <div class="stat-icon"><i class="fa fa-bed"></i></div>
                                    <div class="stat-title">My Room</div>
                                    <a href="room-details.php" class="glass-btn">View Details <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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