<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="icon" type="image/x-icon" href="Superpack-Enterprise-Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      
        /* Dashboard Overview Section */
        .overview-dashboard {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .overview-card {
            width: 22%; /* Smaller width for more compact layout */
            padding: 15px; /* Reduced padding */
            color: #ffffff;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .overview-card.blue {
            background-color: #0099cc;
        }

        .overview-card.green {
            background-color: #4CAF50;
        }

        .overview-card.orange {
            background-color: #ff9933;
        }

        .overview-card .info {
            font-size: 16px; /* Smaller font size */
            margin-bottom: 5px;
        }

        .overview-card .count {
            font-size: 24px; /* Smaller count font size */
            font-weight: bold;
        }

        /* Modify the card-row for better layout */
        .card-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px; /* Reduced gap */
            margin-top: 20px;
        }

        .card {
            flex: 1;
            min-width: 200px; /* Ensures cards shrink for smaller screens */
            max-width: 350px; /* Ensures cards don't get too wide */
            background-color: #e6ffe6;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 8px;
        }

        .card .card-header {
            background-color: #64A651;
            color: #ffffff;
            font-size: 20px;
            padding: 8px 0;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card .card-body {
            padding: 15px; /* Reduced padding */
        }

        .card .card-title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card .card-text {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .card .btn-primary {
            background-color: #64A651;
            border: none;
            padding: 8px 15px;
            font-size: 16px;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .card .btn-primary:hover {
            background-color: #006400;
        }

        /* Welcome and Current Time Section */
        .welcome-section {
            margin-bottom: 20px;
            padding: 0 20px;
        }

        .welcome-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
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
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>
    
       <!-- Overview Dashboard Section -->
       <div class="overview-dashboard">
            <div class="overview-card blue">
                <div class="count">3</div>
                <div class="info">Total Employees</div>
                <a href="#" class="more-info">More info</a>
            </div>
            <div class="overview-card green">
                <div class="count">100%</div>
                <div class="info">On Time Percentage</div>
                <a href="#" class="more-info">More info</a>
            </div>
            <div class="overview-card orange">
                <div class="count">1</div>
                <div class="info">On Time Today</div>
                <a href="#" class="more-info">More info</a>
            </div>
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
    </div>

    <script>
        // JavaScript for time and scroll functionalities
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

            var settings = document.querySelector('.settings');
            settings.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });
    </script>
</body>
</html>