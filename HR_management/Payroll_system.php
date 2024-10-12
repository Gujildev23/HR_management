<?php
session_start(); // Starting session 

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve data from POST
    $name = $_POST["name"];
    $position = $_POST["position"];
    $salary = $_POST["salary"];
    $daily_rate = $salary / 30; // Compute daily rate
    $basic_pay = $daily_rate * 7; // Set basic pay as salary  
    $reg_OT = $_POST["reg_OT"];
    $late_deduction = $_POST["late_deduction"];
    $gross_pay = $basic_pay + $reg_OT - $late_deduction;
    $sss_deduction = $_POST["sss_deduction"];
    $pagibig_deduction = $_POST["pagibig_deduction"];
    $philhealth_deduction = $_POST["philhealth_deduction"];
    $total_deduction = $sss_deduction + $pagibig_deduction + $philhealth_deduction; // Calculate total deduction
    $net_salary = $salary - ($gross_pay + $total_deduction); // Calculate net salary
    $date= $_POST["date"];

    // Include the database connection file 
    require_once("database.php");

    try {
        // Define SQL query to insert data into 'payroll' table
        $query = "INSERT INTO payroll (name, position, salary, daily_rate, basic_pay, reg_OT, late_deduction, gross_pay, sss_deduction, pagibig_deduction, philhealth_deduction, total_deduction, net_salary, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare SQL statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $position);
        $stmt->bindParam(3, $salary);
        $stmt->bindParam(4, $daily_rate);
        $stmt->bindParam(5, $basic_pay);
        $stmt->bindParam(6, $reg_OT);
        $stmt->bindParam(7, $late_deduction);
        $stmt->bindParam(8, $gross_pay);
        $stmt->bindParam(9, $sss_deduction);
        $stmt->bindParam(10, $pagibig_deduction);
        $stmt->bindParam(11, $philhealth_deduction);
        $stmt->bindParam(12, $total_deduction);
        $stmt->bindParam(13, $net_salary);
        $stmt->bindParam(14, $date);

        // Execute the statement
        if ($stmt->execute()) {
            // Successful submission
            $_SESSION['success_message'] = "New employee added successfully!";
            echo '<script>alert("New employee added successfully!"); window.location.href = "payroll_system.php";</script>';
            exit; // Exit to prevent further execution
        } else {
            // Error handling
            $_SESSION['error_message'] = "Error adding new record: " . $stmt->errorInfo()[2];
            echo '<script>alert("Error adding new record: ' . $stmt->errorInfo()[2] . '"); window.location.href = "payroll_system.php";</script>';
            exit; // Exit to prevent further execution
        }
    } catch (PDOException $e) {
        // Handle PDO exceptions
        $_SESSION['error_message'] = "PDO Exception: " . $e->getMessage();
        echo '<script>alert("PDO Exception: ' . $e->getMessage() . '"); window.location.href = "payroll_system.php";</script>';
        exit; // Exit to prevent further execution
    }
} 

// Include the database connection file
require_once("database.php");

try {
    // Prepare SQL statement to select all employees from 'employee_list' table
    $sql = "SELECT * FROM payroll ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);

    // Execute the statement
    $stmt->execute();

    // Fetch all employees
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle PDO exceptions
    $_SESSION['error_message'] = "PDO Exception: " . $e->getMessage();
    echo '<script>alert("PDO Exception: ' . $e->getMessage() . '"); window.location.href = "payroll_system.php";</script>';
    exit; // Exit to prevent further execution
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll System</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* Reset CSS */
    *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #c3e6cb; /* Green pastel background */
            color: #333;
            margin: 0;
        }

        .dashboard {
            display: flex;
            align-items: flex-start;
        }

        .sidebar {
            width: 250px;
            max-width: 250px;
            background-color: #fff;
            padding: 30px;
            padding-bottom: 100px; /* Extend the menu downwards */
            border-right: 1px solid #ddd;
        }

        .content {
            flex: 1;
            padding: 0 20px;
        }

        .company-logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .company-logo {
            max-width: 80px;
            height: auto;
            margin-right: 10px;
        }

        .company-info {
            color: #000;
        }

        .company-info h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }

        .company-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            margin-bottom: 15px;
        }

        .menu-item a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu-item a img {
            width: 24px; /* Adjust the width as needed */
            height: 24px; /* Adjust the height as needed */
            margin-right: 10px;
        }

        .menu-item a i {
            font-size: 18px; /* Adjust the font size of the icon */
        }

        .menu-item a:hover {
            background-color: #d4edda;
            color: #28a745;
        }

        .content {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

       .title {
          margin-bottom: 50px;
          text-align: center; /* Center the text horizontally */
          width: 100%; /* Ensure the title takes full width */
          display: flex; /* Use flexbox for centering */
          justify-content: center; /* Center items horizontally */
           white-space: nowrap; /* Prevent text from breaking into multiple lines */
        }

      .title h1 {
        font-size: 32px;
        font-weight: bold;
        margin: 0; /* Remove default margin */
       }


        .options {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .option {
            flex: 1 1 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
        }

        .option:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .option h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .option p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
        }

        .option a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .option a:hover {
            background-color: #218838;
        }

        .logout-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 20px;
        }

        .logout-btn i {
            font-size: 20px; /* Adjust the font size of the icon */
            margin-right: 10px; /* Adjust the spacing between icon and text */
        }

        .logout-btn:hover {
            background-color: #218838;
        }

      .content {
       display: flex;
       justify-content: center;
       flex-wrap: wrap;
       gap: 10px;
       margin-top: 10px;
    }
    
    .title {
      margin-bottom: 50px;
      text-align: center;
      color: #333; /* Dark green heading */
      width: 100%;
      display: flex;
      margin-right: 194px;

        

    }
    .title h1{
      text-align: right;
      width: 70%;
      display: flex;
      align-items: center;
      max-width: 100px;
      height: auto;
      margin-right: 10px;
    }


    table {
      width: 10%;
      border-collapse: collapse;
      margin-bottom: 20px;
      background-color: #fff; /* White background for table */
      border-radius: 10px; /* Rounded corners */
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #7fbf7f; /* Dark green header */
      color: #fff; /* White text */
    }

    /* Style for the form */
    .add-form, .edit-form {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    .form input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form button {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 5px;
      background-color: #4CAF50; /* Green button */
      color: #fff; /* White text */
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form button:hover {
      background-color: #45a049; /* Darker green on hover */
    }

    /* Add styles for the action bar */
    .action-bar {
      display: flex;
      justify-content: center;
      align-items: center; /* Center items vertically */
      width: 100%;
      margin-bottom: 10px;
    }

    .action-bar button {
      margin: 0 5px; /* Add some space between buttons */
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      background-color: #4CAF50; /* Green button */
      color: #fff; /* White text */
      cursor: pointer;
      transition: background-color 0.3s;
      font-size: 16px;
    }

    .action-bar button:hover {
      background-color: #45a049; /* Darker green on hover */
    }

    .h1 {
      color: #388e3c; /* Dark green heading */
      width: 50%;
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      
    }
    /* Company logo and name */
    .company-info-container {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .company-logo {
      max-width: 80px;
      height: auto;
      margin-right: 10px;
    }

    .company-name {
      font-size: 24px;
      font-weight: bold;
      color: #388e3c; /* Dark green color for company name */
    }

    .slogan {
      font-size: 14px;
      color: #388e3c; /* Dark green color for slogan */
    }

    .back-btn {
      background-color: #4CAF50; /* Green button */
      color: #fff; /* White text */
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .back-btn:hover {
      background-color: #45a049; /* Darker green on hover */
    }
  </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <div class="company-logo-container">
            <img src="logo.png" alt="Company Logo" class="company-logo">
            <div class="company-info">
                <h3>Superpack Enterprise</h3>
                <p>Because your box matters</p>
            </div>
        </div>
        <ul class="menu">
            <li class="menu-item dashboard-link"><a href="dashboard.php"><img src="dashboard icon.png" alt="Dashboard"> Dashboard</a></li>
            <li class="menu-item employee-link"><a href="employe.php"><img src="employee icon.png" alt="Employee"> Employee</a></li>
            <li class="menu-item payroll-link"><a href="Payroll_system.php"><img src="payroll icon.png" alt="Payroll"> Payroll</a></li>
            <li class="menu-item task-management-link"><a href="task.php"><img src="task icon.png" alt="Task Management"> Task Management</a></li>
            <li class="menu-item staff-notice-link"><a href="staffnotice.php"><img src="staff notice icon.png" alt="Staff Notice"> Staff Notice</a></li>
            <li class="menu-item employment-link"><a href="recruitment.php"><img src="recruitment icon.png" alt="Recruitment"> Recruitment</a></li>
            <li class="menu-item personnel-records-link"><a href="employee_records.php"><img src="personal records icon.png" alt="Personnel Records"> Personnel Records</a></li>
            <button class="logout-btn" onclick="logout()">
            <img src="logout icon.png" alt="Logout" style="max-width: 20px; margin-right: 10px;"> Logout
              </button>
            </li>
        </ul>
        </ul>
</div>

<div class="content">
<div class="title"><h1>PAYROLL SYSTEM</h1>
</div>

  

  <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Salary</th>
            <th>Daily Rate</th>
            <th>Basic Pay</th>
            <th>Regular OT</th>
            <th>Late Deduction</th>
            <th>Gross Pay</th>
            <th>SSS Deduction</th>
            <th>Pag-IBIG Deduction</th>
            <th>Phil Heath deduction</th>
            <th>Total Deduction</th>
            <th>Net Salary</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $row): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['position']; ?></td>
                <td><?php echo $row['salary']; ?></td>
                <td><?php echo $row['daily_rate']; ?></td>
                <td><?php echo $row['basic_pay']; ?></td>
                <td><?php echo $row['reg_OT']; ?></td>
                <td><?php echo $row['late_deduction']; ?></td>
                <td><?php echo $row['gross_pay']; ?></td>
                <td><?php echo $row['sss_deduction']; ?></td>
                <td><?php echo $row['pagibig_deduction']; ?></td>
                <td><?php echo $row['philhealth_deduction']; ?></td>
                <td><?php echo $row['total_deduction']; ?></td>
                <td><?php echo $row['net_salary']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td class="button_form">
                    <button name="save">Save</button>
                    <button name="cancel">Cancel</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

  <!-- Action Bar -->
  <div class="action-bar">
    <button onclick="showAddForm()">Add New Employee</button>
    <button class="back-btn" onclick="goBack()">Back</button>
  </div>
  
 <!-- New Employee Form -->
  <div class="add-form" id="addEmployeeForm">
    <form action="payroll_system.php" method="post">
 
    <h2>Add New Employee</h2>
    <input name="name" type="text" id="newName" oninput="lettersOnly(event)" placeholder="Name" onkeyup="mult(this.value);">
    <input name="position" type="text" id="newPosition" oninput="lettersOnly(event)" placeholder="Position" onkeyup="mult(this.value);">
    <input name="salary" type="number" id="newSalary" placeholder="Salary" onkeyup="mult(this.value);">
    <input name="daily_rate" type="number" id="editDailyRate" placeholder="Daily Rate" onkeyup="mult(this.value);">
    <input name="basic_pay" type="number" id="editBasicPay" placeholder="Basic Pay" onkeyup="mult(this.value);">
    <input name="reg_OT" type="number" id="editRegOT" placeholder="Regular OT" onkeyup="mult(this.value);">
    <input name="late_deduction" type="number" id="editLateDeduction" placeholder="Late Deduction" onkeyup="mult(this.value);">
    <input name="gross_pay" type="number" id="editGrossPay" placeholder="Gross Pay" onkeyup="mult(this.value);">
    <input name="sss_deduction" type="number" id="newSSS" placeholder="SSS Deduction" optional onkeyup="mult(this.value);">
    <input name="pagibig_deduction" type="number" id="newPagibig" placeholder="Pag-IBIG Deduction" optional onkeyup="mult(this.value);">
    <input name="philhealth_deduction" type="number" id="newPhilHealth" placeholder="Phil Health Deduction" optional onkeyup="mult(this.value);">
    <input name="net_salary" type="number" id="newNetSalary" placeholder="Net Salary" onkeyup="mult(this.value);">
    <input required type="date" name="date" id="newdate" title="Choose your desired date" min="<?php echo date('Y-m-d'); ?>"/>
    <button name="save" onclick="addEmployee()">Save</button>
    <button name="cancel" onclick="hideAddForm()">Cancel</button>
    </form>
  </div>

  <!-- Edit Employee Form -->
  <div class="edit-form" id="editEmployeeForm">
    <h2>Edit Employee</h2>
    <input type="text" id="editName" placeholder="Name" oninput="lettersOnly(event)" onkeyup="mult(this.value);">
    <input type="text" id="editPosition" placeholder="Position" oninput="lettersOnly(event)" onkeyup="mult(this.value);">
    <input type="number" id="editSalary" placeholder="Salary" onkeyup="mult(this.value);"> 
    <input type="number" id="editDailyRate" placeholder="Daily Rate" onkeyup="mult(this.value);">
    <input type="number" id="editBasicPay" placeholder="Basic Pay" onkeyup="mult(this.value);" >
    <input type="number" id="editRegOT" placeholder="Regular OT" onkeyup="mult(this.value);">
    <input type="number" id="editLateDeduction" placeholder="Late Deduction" onkeyup="mult(this.value);">
    <input type="number" id="editGrossPay" placeholder="Gross Pay" onkeyup="mult(this.value);">
    <input type="number" id="editSSS" placeholder="SSS Deduction" optional onkeyup="mult(this.value);">
    <input type="number" id="editPagibig" placeholder="Pag-IBIG Deduction" optional onkeyup="mult(this.value);"> 
    <input type="number" id="editPhilHealth" placeholder="Phil Health Deduction" optional onkeyup="mult(this.value);">
    <input type="date" id="editDate" placeholder="Date" optional onkeyup="mult(this.value);">
    <input type="number" id="editOtherInsurance" placeholder="Other Insurance Deduction" onkeyup="mult(this.value);">
    <button onclick="updateEmployee()">Update</button>
    <button onclick="cancelEdit()">Cancel</button>
  </div>
</div>

<script>

  //Only letters will be inputted
function lettersOnly(event) {
     var inputValue = event.target.value;
  var newValue = inputValue.replace(/[0-9]/g, '');
  event.target.value = newValue;
}

// Function to show the add employee form
function showAddForm() {
  var addForm = document.getElementById("addEmployeeForm");
  addForm.style.display = "block";
}

// Function to hide the add employee form
function hideAddForm() {
  var addForm = document.getElementById("addEmployeeForm");
  addForm.style.display = "none";
}

// Function to add a new employee
function addEmployee() {
  var newName = document.getElementById("newName").value;
  var newPosition = document.getElementById("newPosition").value;
  var newSalary = parseInt(document.getElementById("newSalary").value); // Parse salary as integer
  var newDailyRate = document.getElementById("newDailyRate").value;
  var newBasicPay = document.getElementById("newBasicPay").value;
  var newRegOT = document.getElementById("newRegOT").value;
  var newLateDeduction = document.getElementById("newLateDeduction").value;
  var newGrossPay = document.getElementById("newGrossPay").value;
  var newSSS = parseInt(document.getElementById("newSSS").value);
  var newPagibig = parseInt(document.getElementById("newPagibig").value);
  var newPhilHealth = parseInt(document.getElementById("newPhilHealth").value);

  document.getElementById("editDailyRate").value = dailyRate.toFixed(2);
  document.getElementById("editBasicPay").value = basicPay.toFixed(2);
  document.getElementById("editRegOT").value = regOT.toFixed(2);
  document.getElementById("editLateDeduction").value = lateDeduction.toFixed(2);
  document.getElementById("editGrossPay").value = grossPay.toFixed(2);
  document.getElementById("editNetPay").value = netPay.toFixed(2);

  var totalDeduction = sss + pagibig + philhealth;
  document.getElementById("editTotalDeduction").value = totalDeduction.toFixed(2);
}

// Function to cancel edit
function cancelEdit() {
  var editForm = document.getElementById("editEmployeeForm");
  editForm.style.display = "none";
}

// Function to update employee details
function updateEmployee() {
  // You can implement update functionality here

  // After updating, hide the edit form

  // Create a new row for the new employee
  var newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td>${newName}</td>
    <td>${newPosition}</td>
    <td>${newSalary}</td>
    <td>${newDailyRate}</td>
    <td>${newBasicPay}</td>
    <td>${newRegOT}</td>
    <td>${newLateDeduction}</td>
    <td>${newGrossPay}</td>    
    <td>${newSSS}</td>
    <td>${newPagibig}</td>
    <td>${newPhilHealth}</td>
    <td>${totalDeduction}</td>
    <td>${netSalary}</td>
    <td>
      <button onclick="editEmployeeForm(this)">Edit</button>
      <button onclick="deleteEmployee(this)">Delete</button>
    </td>
  `;

  // Append the new row to the table
  var tableBody = document.getElementById("workersTableBody");
  tableBody.insertBefore(newRow, tableBody.firstChild);

  // Hide the add employee form
  hideAddForm();
}
// Fill the edit form with employee data
document.getElementById("name").value = name;
  document.getElementById("position").value = position;
  document.getElementById("salary").value = salary;
  document.getElementById("daily_rate").value = daily_rate;
  document.getElementById("basic_pay").value = basic_pay;
  document.getElementById("reg_OT").value = reg_OT
  document.getElementById("late_deduction").value = late_deduction;
  document.getElementById("gross_pay").value = gross_pay;
  document.getElementById("sss").value = sss;
  document.getElementById("pagibig").value = pagibig;
  document.getElementById("otherInsurance").value = otherInsurance;

// Function to edit an employee
function editEmployeeForm(button) {
  var row = button.closest('tr');
  var cells = row.getElementsByTagName('td');
  var name = cells[0].innerText;
  var position = cells[1].innerText;
  var salary = parseFloat(cells[2].innerText).toFixed(2);
  var daily_rate = parseInt(cells[3].innerText);
  var basic_pay = parseInt(cells[4].innerText);
  var reg_OT = parseInt(cells[5].innerText);
  var late_deduction = parseInt(cells[6].innerText);
  var gross_pay = parseInt(cells[7].innerText);
  var pagibig = parseInt(cells[8].innerText);
  var otherInsurance = parseInt(cells[9].innerText);

  var editForm = document.getElementById("editEmployeeForm");
  editForm.style.display = "block";

  // Fill the edit form with employee data
  document.getElementById("editName").value = name;
  document.getElementById("editPosition").value = position;
  document.getElementById("editSalary").value = salary;
  document.getElementById("editDailyRate").value = daily_rate;
  document.getElementById("editBasicPay").value = basic_pay;
  document.getElementById("editRegOT").value = reg_OT
  document.getElementById("editLateDeduction").value = late_deduction;
  document.getElementById("editGrossPay").value = gross_pay;
  document.getElementById("editSSS").value = sss;
  document.getElementById("editPagibig").value = pagibig;
  document.getElementById("editOtherInsurance").value = otherInsurance;
}

// Function to cancel edit
function cancelEdit() {
  var editForm = document.getElementById("editEmployeeForm");
  editForm.style.display = "none";
}

// Function to update employee details
function updateEmployee() {
  // You can implement update functionality here

  // After updating, hide the edit form
  cancelEdit();
}

// Function to delete an employee
function deleteEmployee(button) {
  var row = button.closest('tr');
  row.remove();
}

// Function to go back
function goBack() {
  window.history.back();
}
// Function to logout and redirect to login.php
    function logout() {
        // Redirect to login page
        window.location.href = "login.php";
    }
</script>

</body>
</html>
