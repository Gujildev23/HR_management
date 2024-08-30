<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Sidebar styling */
        .sidebar {
            height: 100%;
            width: 250px;
            background-color: #008000;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .logo_details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo_image {
            height: 50px;
            width: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .logo_name {
            font-size: 18px;
            font-weight: bold;
        }

        .user_info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .user_logo {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user_name, .user_position {
            display: block;
        }

        .user_name {
            font-weight: bold;
        }

        .nav_list {
            list-style: none;
            padding: 0;
        }

        .nav_list li {
            margin-bottom: 10px;
        }

        .nav_list a {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }

        .nav_list .icon {
            margin-right: 10px;
        }

        .nav_list .dropdown-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav_list .dropdown-container {
            display: none;
            list-style: none;
            padding-left: 20px;
        }

        .nav_list .dropdown-container li {
            margin-bottom: 5px;
        }

        .nav_list .dropdown-container a {
            padding: 5px 10px;
        }

        .nav_list a:hover, .nav_list .dropdown-btn:hover {
            background-color: #34495e;
        }

        .logout_button {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #c0392b;
            text-align: center;
        }

        .logout_button:hover {
            background-color: #e74c3c;
        }

        .scroll-to-top {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
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
                <a href="dashboardnew.php">
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
                    <li><a href="attendance.php">Checking Attendance</a></li>
                    <li><a href="worker_evaluation.php">Evaluation</a></li>
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
                    <li><a href="sales.php">Sales Department</a></li>
                    <li><a href="purchase.php">Purchasing Department</a></li>
                    <li><a href="purchasedev.php">Product Development Department</a></li>
                    <li><a href="warehouse.php">Warehouse Department</a></li>
                    <li><a href="logistic.php">Logistic Department</a></li>
                    <li><a href="accounting.php">Accounting Department</a></li>
                </ul>
            </li>
            <li>
                <a href="employee_list.php">
                    <span class="icon"><i class="fas fa-cogs"></i></span>
                    <span class="title">Personnel Records</span>
                </a>
            </li>
        </ul>
        <a href="logout.html" class="logout_button">Logout</a>
        <div class="scroll-to-top" onclick="scrollToTop()"></div>
    </div>

    <!-- JavaScript for dropdowns and scroll-to-top functionality -->
    <script>
        // Dropdown functionality
        document.querySelectorAll('.dropdown-btn').forEach(button => {
            button.addEventListener('click', () => {
                const dropdown = button.nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
        });

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>
