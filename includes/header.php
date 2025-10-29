<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: rgb(196, 235, 196);
        }

        img {
            height: 40px;
            width: 40px;
            margin-left: 16px;
        }

        nav {
            background-color: rgb(2, 17, 31);
        }

        .navbar-brand {
            text-align: center;
            width: 100%;
        }

        .navbar .navbar-right {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar .navbar-right img {
            height: 40px;
            width: 40px;
            margin-left: 10px;
        }

        #sidebar {
            width: 250px;
            min-height: 75vh;
            background-color: rgb(2, 17, 31);
            color: white;
            transition: all 0.3s ease;
        }

        #sidebar.collapsed {
            align-items: center;
            width: 60px;
            overflow: hidden;
        }

        #sidebar.collapsed h4 {
            display: none;
        }

        #sidebar.collapsed ul li a span {
            display: none;
        }

        #sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
        }

        #sidebar ul li a:hover {
            background-color: rgb(2, 17, 31);
        }

        #toggleSidebar {
            margin: 10px 0;
            cursor: pointer;
            font-size: 28px;
            padding-left: 10px;
        }

        .nav-link {
            white-space: nowrap;
            cursor: pointer;
            color: white;
            text-decoration: none;
        }

        #sidebar .nav-link:hover {
            color: white;
        }

        #main-container {
            display: flex;
            flex: 1;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container-fluid">
            <a class="navbar-brand">
                <h2>Welcome!</h2>
            </a>
            <div class="navbar-right">
                <a href="../logout.php" class="btn btn-outline-light me-2">Logout</a>

            </div>
        </div>
    </nav>
    <div id="main-container" class="flex-grow-1">
        <div id="sidebar" class="p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Menu</h4>
                <i class="fa-solid fa-bars" id="toggleSidebar" alt="Toggle"></i>
            </div>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="../pages/dashboard.php" class="nav-link">
                        <i class="fa fa-house"></i>
                        <span> Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex  align-items-center justify-content"
                        data-bs-toggle="collapse" href="#employeeMenu" role="button">
                        <div class="d-flex align-items-center">

                            <span>Employee Management</span>
                        </div>
                        <span class="ms-auto"> <i class="fa fa-chevron-down"></i></span>
                    </a>
                    <div class="collapse" id="employeeMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="../actions/addemp.php">
                                    <i class="fa fa-plus-circle me-2"></i> Add Employee
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../actions/viewemp.php">
                                    <i class="fa fa-tasks me-2"></i> Update Employee
                                </a>
                                <a class="nav-link" href="../actions/department.php">
                                    <i class="fa fa-plus-circle me-2"></i> Department Management
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex  align-items-center justify-content"
                        data-bs-toggle="collapse" href="#AttendanceMenu" role="button">
                        <div class="d-flex align-items-center">

                            <span> Attendance</span>
                        </div>
                        <span class="ms-auto"> <i class="fa fa-chevron-down"></i></span>
                    </a>
                    <div class="collapse" id="AttendanceMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="../actions/markattendance.php">
                                    <i class="fa fa-plus-circle me-2"></i> Add Attendance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../actions/viewattendance.php">
                                    <i class="fa fa-tasks me-2"></i> View Attendance
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>


                <li class="nav-item">
                    <a class="nav-link d-flex  align-items-center justify-content"
                        data-bs-toggle="collapse" href="#SalaryMenu" role="button">
                        <div class="d-flex align-items-center">

                            <span> Salary </span>
                        </div>
                        <span class="ms-auto"> <i class="fa fa-chevron-down"></i></span>
                    </a>
                    <div class="collapse" id="SalaryMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="../actions/calsalary.php">
                                    <i class="fa-solid fa-wallet me-2"></i> Calculate Salary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../actions/viewsalary.php">
                                    <i class="fa fa-tasks me-2"></i> View Salary
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>






                <li class="nav-item">
                    <a href="../profile.php" class="nav-link">
                        <i class="fa-solid fa-user"></i>
                        <span> Profile</span>
                    </a>
                </li>

            </ul>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>