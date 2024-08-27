<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="icon" type="image/x-icon" href="Superpack-Enterprise-Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #64A651; /* Sidebar color */
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto; /* Adds vertical scroll if content overflows */
        }

        .sidebar .logo_details {
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .sidebar .logo_image {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .sidebar .logo_name {
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
        }

        .sidebar .user_info {
            text-align: center;
            padding: 20px 0;
        }

        .sidebar .user_logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar .user_name,
        .sidebar .user_position {
            color: #ffffff;
            font-size: 16px;
        }

        .nav_list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .nav_list li {
            width: 100%;
            margin-bottom: 10px;
        }

        .nav_list a {
            text-decoration: none;
            color: #ffffff;
            padding: 15px;
            display: flex;
            align-items: center;
            transition: background 0.3s;
        }

        .nav_list a:hover {
            background-color: #006400;
        }

        .nav_list .icon {
            margin-right: 15px;
        }

        .dropdown-container {
            display: none;
            padding-left: 20px;
        }

        .dropdown-btn.active + .dropdown-container {
            display: block;
        }

        .logout_button {
            text-align: center;
            padding: 15px;
            color: #ffffff;
            text-decoration: none;
            display: block;
            margin-top: 20px;
            background-color: #AA4A44;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #ffffff;
        }

        .card-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap; /* Allows cards to wrap to the next line if necessary */
            gap: 20px; /* Adds gap between cards */
            margin-top: 20px;
        }

        .card {
            width: 450px; /* Makes the cards bigger */
            background-color: #e6ffe6; /* Light green color */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px;
            text-align: center;
            border-radius: 8px;
        }

        .card .card-header {
            background-color: #64A651;
            color: #ffffff;
            font-size: 24px;
            padding: 10px 0;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card .card-body {
            padding: 20px;
        }

        .card .card-title {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .card .card-text {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .card .btn-primary {
            background-color: #64A651;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .card .btn-primary:hover {
            background-color: #006400;
        }

        .welcome-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .current-time {
            font-size: 16px;
            color: #666;
        }

        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #006400;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            display: none; /* Hidden by default */
        }

        .scroll-to-top:hover {
            background-color: #004d00;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo_details">
            <img src="Superpack-Enterprise-Logo.png" alt="Superpack Enterprise Logo" class="logo_image">
            <span class="logo_name">Superpack Enterprise</span>
        </div>
        <div class="user_info">
            <img src="cina.jpg" alt="User Logo" class="user_logo">
            <span class="user_name">Krystal Tabamo</span>
            <span class="user_position">Project Manager</span>
        </div>
        <ul class="nav_list">
            <li>
                <a href="#">
                    <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-btn">
                    <span class="icon"><i class="fas fa-th-list"></i></span>
                    <span class="title">Employee</span>
                    <span class="dropdown-icon"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="dropdown-container">
                    <li><a href="#">Checking Attendance</a></li>
                    <li><a href="#">Evaluation</a></li>
                    <li><a href="#">Employee Training</a></li>
                    <li><a href="#">Leave Request</a></li>
                    <li><a href="#">Staff Notice</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="icon"><i class="fas fa-pencil-alt"></i></span>
                    <span class="title">Payroll</span>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-btn">
                    <span class="icon"><i class="fas fa-chart-bar"></i></span>
                    <span class="title">Task Management</span>
                    <span class="dropdown-icon"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="dropdown-container">
                    <li><a href="#">Sales Department</a></li>
                    <li><a href="#">Purchasing Department</a></li>
                    <li><a href="#">Product Development Department</a></li>
                    <li><a href="#">Warehouse Department</a></li>
                    <li><a href="#">Logistic Department</a></li>
                    <li><a href="#">Accounting Department</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span class="icon"><i class="fas fa-chart-pie"></i></span>
                    <span class="title">Recruitment</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon"><i class="fas fa-cogs"></i></span>
                    <span class="title">Personnel Records</span>
                </a>
            </li>
        </ul>
        <a href="logout.html" class="logout_button">Logout</a>
        <div class="scroll-to-top" onclick="scrollToTop()">↑</div>
    </div>

    <div class="content">
        <!-- Added Welcome and Time -->
        <div class="welcome-message">
            Welcome, Admin!
        </div>
        <div class="current-time" id="current-time">
            <!-- Time will be inserted by JavaScript -->
        </div>

        <!-- Card Section -->
        <div class="card-row">
            <div class="card">
                <div class="card-header">Attendance</div>
                <div class="card-body">
                    <p class="card-text">Track Employee attendance and view attendance reports.</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Tasks</div>
                <div class="card-body">
                    <p class="card-text">Tracking work sufficient and scheduling.</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Evaluation</div>
                <div class="card-body">
                    <p class="card-text">Conduct employee evaluations and track performance.</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <!-- End of Card Section -->
    </div>

    <script>
        // Function to display current time
        function displayCurrentTime() {
            var date = new Date();
            document.getElementById("current-time").innerText = "Current time: " + date.toLocaleTimeString();
        }

        // Display time on page load
        window.onload = function() {
            displayCurrentTime();
            setInterval(displayCurrentTime, 1000); // Update every second
        };

        // Function to show or hide the scroll-to-top button
        window.onscroll = function() {
            var button = document.querySelector(".scroll-to-top");
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        };

        // Function to scroll to the top
        function scrollToTop() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }

        // Function to toggle dropdown
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown-btn');

            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>
