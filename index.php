<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="icon" type="image/x-icon" href="Superpack-Enterprise-Logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a href="#">
                    <span class="icon"><i class="fas fa-chart-bar"></i></span>
                    <span class="title">Task Management</span>
                </a>
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
    </div>

    <div class="content">
        <h2>Dropdown Sidebar</h2>
    </div>

    <script src="script.js"></script>
</body>
</html>
