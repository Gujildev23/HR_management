<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../welcome.php');
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$database = "hr_management";
$port = 3307;

// mysqli connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Define name
$name = isset($_GET['name']) ? $_GET['name'] : '';

// Initialize search ID
$searchId = isset($_GET['search_id']) ? $_GET['search_id'] : '';

// Base query to retrieve tasks from the database
$query = "SELECT * FROM payroll_records";

// If search_id is provided, add WHERE clause with LIKE
if (!empty($searchId)) {
    $query .= " WHERE name LIKE ?";
}
// Prepare the SQL statement
$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

// Bind the search ID with wildcard if a search term is provided
if (!empty($searchId)) {
    $searchTerm = '%' . $searchId . '%';
    $stmt->bind_param("s", $searchTerm);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

// Handling form submissions for adding, editing, and deleting tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a new task
    if (isset($_POST['addPayroll'])) {
        $newTask = [
            'name' => $_POST['name'],
            'position' => $_POST['position'],
            'salary' => floatval($_POST['salary']), // Convert to float
            'daily_rate' => floatval($_POST['daily_rate']), // Convert to float
            'basic_pay' => floatval($_POST['basic_pay']), // Convert to float
            'ot_pay' => floatval($_POST['ot_pay']), // Convert to float
            'late_deduct' => floatval($_POST['late_deduct']), // Convert to float
            'gross_pay' => floatval($_POST['gross_pay']), // Convert to float
            'sss_deduct' => floatval($_POST['sss_deduct']), // Convert to float
            'pagibig_deduct' => floatval($_POST['pagibig_deduct']), // Convert to float
            'philhealth_deduct' => floatval($_POST['philhealth_deduct']), // Convert to float
            'total_deduct' => floatval($_POST['sss_deduct']) + floatval($_POST['pagibig_deduct']) + floatval($_POST['philhealth_deduct']), // Calculate and convert to float
            'net_salary' => floatval($_POST['net_salary']), // Convert to float
            'date_created' => date('Y-m-d')
        ];

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO payroll_records (name, position, salary, daily_rate, basic_pay, ot_pay, late_deduct, gross_pay, sss_deduct, pagibig_deduct, philhealth_deduct, total_deduct, net_salary, date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddddddddddds", $newTask['name'], $newTask['position'], $newTask['salary'], $newTask['daily_rate'], $newTask['basic_pay'], $newTask['ot_pay'], $newTask['late_deduct'], $newTask['gross_pay'], $newTask['sss_deduct'], $newTask['pagibig_deduct'], $newTask['philhealth_deduct'], $newTask['total_deduct'], $newTask['net_salary'], $newTask['date_created']);
        $stmt->execute();

    }

    // Edit a task
    if (isset($_POST['editPayroll'])) {
        $editTask = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'position' => $_POST['position'],
            'salary' => floatval($_POST['salary']), // Convert to float
            'daily_rate' => floatval($_POST['daily_rate']), // Convert to float
            'basic_pay' => floatval($_POST['basic_pay']), // Convert to float
            'ot_pay' => floatval($_POST['ot_pay']), // Convert to float
            'late_deduct' => floatval($_POST['late_deduct']), // Convert to float
            'gross_pay' => floatval($_POST['gross_pay']), // Convert to float
            'sss_deduct' => floatval($_POST['sss_deduct']), // Convert to float
            'pagibig_deduct' => floatval($_POST['pagibig_deduct']), // Convert to float
            'philhealth_deduct' => floatval($_POST['philhealth_deduct']), // Convert to float
            'total_deduct' => floatval($_POST['sss_deduct']) + floatval($_POST['pagibig_deduct']) + floatval($_POST['philhealth_deduct']), // Calculate and convert to float
            'net_salary' => floatval($_POST['net_salary']), // Convert to float
            'date_created' => date('Y-m-d')
            ];

        // prepare and bind
        $stmt = $conn->prepare("UPDATE payroll_records SET name = ?, position = ?, salary = ?, daily_rate = ?, basic_pay = ?, ot_pay = ?, late_deduct = ?, gross_pay = ?, sss_deduct = ?, pagibig_deduct = ?, philhealth_deduct = ?, total_deduct = ?, net_salary = ?, date_created = ? WHERE id = ?");
        $stmt->bind_param("ssdddddddddddsi", $editTask['name'], $editTask['position'], $editTask['salary'], $editTask['daily_rate'], $editTask['basic_pay'], $editTask['ot_pay'], $editTask['late_deduct'], $editTask['gross_pay'], $editTask['sss_deduct'], $editTask['pagibig_deduct'], $editTask['philhealth_deduct'], $editTask['total_deduct'], $editTask['net_salary'], $editTask['date_created'], $editTask['id']);
        $stmt->execute();
        
    }
    // Delete a task
    if (isset($_POST['deleteTask'])) {
        // Get the task IDs from the form
        $taskIds = $_POST['task_checkbox'];

        // Create a string with the same number of placeholders as the number of task IDs
        $placeholders = rtrim(str_repeat('?, ', count($taskIds)), ', ');

        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM payroll_records WHERE id IN ($placeholders)");

        // Bind the task IDs to the placeholders
        $stmt->bind_param(str_repeat('i', count($taskIds)), ...$taskIds);

        // Execute the statement
        $stmt->execute();
    }

    header('Location: payroll.php');
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Payroll</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="icon" type="image/x-icon" href="Superpack-Enterprise-Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboardnew.css">
    <style>
    </style>

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
    <?php include 'sidebar_small.php'; ?>
    <div class="container-everything" style="height:100%;">
            <div class="container-all">
                <div class="container-top">
                    <?php include 'header_2.php'; ?>
                </div>
                <div class="container-search">
                    <div class="table-container">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>OT Pay</th>
                                    <th>Late deduct</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch payroll records from the database
                                $query = "SELECT * FROM additional_pay";
                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['ot_pay']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['late_deduct']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['date_created']) . "</td>";
                                        echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#editTaskModal' data-id='" . htmlspecialchars($row['id']) . "'>Edit</button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'><button class='btn btn-primary' data-toggle='modal' data-target='#addPayModal'>Set a Value</button></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="border-top:5px solid #131313; width:100%; height:1px;"></div>
                <div class="container-search"  style="height:100%;">
                    <div class="search-bar">
                        <form method="GET" action="" class="form-inline">
                            <div class="input-group mb-3 flex-grow-1">
                                <!-- Search input and button -->
                                <input type="hidden" name="department" value="<?php echo htmlspecialchars($department); ?>">
                                <input type="text" class="form-control" name="search_id" placeholder="Search by ID" value="<?php echo htmlspecialchars($searchId); ?>"style="border-radius: 10px 0 0 10px; border: 3px solid #131313; height:42px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" style="border-radius: 0; border: 3px solid #131313;">Search</button>
                                </div>
                            </div>
                            <button class="btn btn-primary mb-3" type="button" data-toggle="modal" data-target="#addPayrollModal" style="border-radius: 0 10px 10px 0; border: 3px solid #131313;">Add Record</button>
                        </form>
                    </div>
                    <div class="tool-bar">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div style="color: #FFFAFA;">
                                <span id="selected-count">0</span> items selected
                            </div>
                            
                            <div class="d-flex align-items-center" style="gap:10px;">
                                
                                <!-- Start the form for deletion -->
                                <form method="POST" id="deleteForm" style="display:inline;">
                                    <button type="submit" name="deleteTask" class="btn btn-danger" disabled>Del</button>
                                </form>
                                <button class="btn btn-primary" name="editTaskMod" data-toggle="modal" data-target="#editTaskModal" disabled data-id="<?php echo $task['id']; ?>">Edit</button>
                                
                                <button class="btn btn-info" onclick="window.location.href='payroll.php'">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="checkbox-col"></th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Salary</th>
                                    <th>Daily Rate</th>
                                    <th>Basic Pay</th>
                                    <th>Overtime Pay</th>
                                    <th>Late deduct</th>
                                    <th>Gross Pay</th>
                                    <th>SSS deduct</th>
                                    <th>Pag-IBIG deduct</th>
                                    <th>PhilHealth deduct</th>
                                    <th>Total deduct</th>
                                    <th>Net Salary</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($tasks as $row): ?>
                                <tr>
                                    <td><input type="checkbox" id="chkbx" name="task_checkbox[]" form="deleteForm" value="<?php echo $row['id']; ?>" onclick="updateSelectedCount(this)">
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                                    <td><?php echo htmlspecialchars($row['salary']); ?></td>
                                    <td><?php echo htmlspecialchars($row['daily_rate']); ?></td>
                                    <td><?php echo htmlspecialchars($row['basic_pay']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ot_pay']); ?></td>
                                    <td><?php echo htmlspecialchars($row['late_deduct']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gross_pay']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sss_deduct']); ?></td>
                                    <td><?php echo htmlspecialchars($row['pagibig_deduct']); ?></td>
                                    <td><?php echo htmlspecialchars($row['philhealth_deduct']); ?></td>
                                    <td><?php echo htmlspecialchars($row['total_deduct']); ?></td>
                                    <td><?php echo htmlspecialchars($row['net_salary']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_created']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
    </div>
    <!-- Additional Pay Modal -->
    <div class="modal fade" id="addPayModal" tabindex="-1" role="dialog" aria-labelledby="addPayModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPayModalLabel">Set New Values</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ot_pay">OT Pay</label>
                            <input type="number" class="form-control" id="ot_pay" name="ot_pay" required>
                        </div>
                        <div class="form-group">
                            <label for="late_deduct">Late deduct</label>
                            <input type="number" class="form-control" id="late_deduct" name="late_deduct" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addPay" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Payroll Records Modal -->
    <div class="modal fade" id="addPayrollModal" tabindex="-1" role="dialog" aria-labelledby="addPayrollModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPayrollModalLabel">New Payroll Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body form-content">
                        <div id="payrollCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Slide 1: Basic Information -->
                                <div class="carousel-item active">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" name="position" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input type="number" class="form-control" id="salary" name="salary" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="daily_rate">Daily Rate</label>
                                        <input type="number" class="form-control" id="daily_rate" name="daily_rate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="basic_pay">Basic Pay</label>
                                        <input type="number" class="form-control" id="basic_pay" name="basic_pay" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ot_pay">Overtime Pay</label>
                                        <input type="number" class="form-control" id="ot_pay" name="ot_pay" required>
                                    </div>
                                </div>

                                <!-- Slide 2: Payroll Details -->
                                <div class="carousel-item">
                                    
                                    <div class="form-group">
                                        <label for="late_deduct">Late deduct</label>
                                        <input type="number" class="form-control" id="late_deduct" name="late_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="gross_pay">Gross Pay</label>
                                        <input type="number" class="form-control" id="gross_pay" name="gross_pay" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sss_deduct">SSS deduct</label>
                                        <input type="number" class="form-control" id="sss_deduct" name="sss_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pagibig_deduct">Pag-IBIG deduct</label>
                                        <input type="number" class="form-control" id="pagibig_deduct" name="pagibig_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="philhealth_deduct">PhilHealth deduct</label>
                                        <input type="number" class="form-control" id="philhealth_deduct" name="philhealth_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="net_salary">Net Salary</label>
                                        <input type="number" class="form-control" id="net_salary" name="net_salary" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Carousel Controls -->
                            <a class="carousel-control-prev" href="#payrollCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#payrollCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addPayroll" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Payroll Records Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Payroll Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body form-content">
                        <div id="editPayrollCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Slide 1: Basic Information -->
                                <div class="carousel-item active">
                                    <input type="hidden" id="edit_id" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <div class="form-group">
                                        <label for="edit_name">Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_position">Position</label>
                                        <input type="text" class="form-control" id="edit_position" name="position" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_salary">Salary</label>
                                        <input type="number" class="form-control" id="edit_salary" name="salary" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_daily_rate">Daily Rate</label>
                                        <input type="number" class="form-control" id="edit_daily_rate" name="daily_rate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_basic_pay">Basic Pay</label>
                                        <input type="number" class="form-control" id="edit_basic_pay" name="basic_pay" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_ot_pay">Overtime Pay</label>
                                        <input type="number" class="form-control" id="edit_ot_pay" name="ot_pay" required>
                                    </div>
                                </div>

                                <!-- Slide 2: Payroll Details -->
                                <div class="carousel-item">
                                    <div class="form-group">
                                        <label for="edit_late_deduct">Late deduct</label>
                                        <input type="number" class="form-control" id="edit_late_deduct" name="late_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_gross_pay">Gross Pay</label>
                                        <input type="number" class="form-control" id="edit_gross_pay" name="gross_pay" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_sss_deduct">SSS deduct</label>
                                        <input type="number" class="form-control" id="edit_sss_deduct" name="sss_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_pagibig_deduct">Pag-IBIG deduct</label>
                                        <input type="number" class="form-control" id="edit_pagibig_deduct" name="pagibig_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_philhealth_deduct">PhilHealth deduct</label>
                                        <input type="number" class="form-control" id="edit_philhealth_deduct" name="philhealth_deduct" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_net_salary">Net Salary</label>
                                        <input type="number" class="form-control" id="edit_net_salary" name="net_salary" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Carousel Controls -->
                            <a class="carousel-control-prev" href="#editPayrollCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#editPayrollCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="editPayroll" class="btn btn-primary">Edit Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const clock = document.querySelector('.current-time');
        const options = {hour: '2-digit', minute: '2-digit'};
        const locale = 'en-PH';
        setInterval(() => {
            const now = new Date();
            clock.textContent = now.toLocaleTimeString(locale, options);
        }, 1000);

        // Change logo name 
        const logoName = document.querySelector('.logo_name');
        logoName.textContent = 'Payroll';

        function updateSelectedCount() {
    var selectedCount = document.querySelectorAll('input[name="task_checkbox[]"]:checked').length;
    document.getElementById('selected-count').textContent = selectedCount;

    // Toggle buttons based on the number of selected checkboxes
    toggleButtons(selectedCount);
}

// Function to toggle the delete and edit buttons
function toggleButtons(selectedCount) {
    // Get the delete and edit buttons
    var deleteButton = document.querySelector('button[name="deleteTask"]');
    var editButton = document.querySelector('button[name="editTaskMod"]');

    // Enable delete button if at least one checkbox is selected
    deleteButton.disabled = selectedCount === 0;

    // Enable edit button only if exactly one checkbox is selected
    editButton.disabled = selectedCount !== 1;
}

// Attach event listeners to all checkboxes
document.querySelectorAll('input[name="task_checkbox[]"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        updateSelectedCount();
    });
});
    </script>
</body>
</html>
