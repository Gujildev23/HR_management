<?php
session_start(); // Starting session

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve email from POST data
    $email = $_POST["email"];
    // Retrieve password from POST data
    $password = $_POST["password"];

    try {
        // Include the database connection file
        require_once("database.php");

        // Define SQL query to fetch user from 'users' table
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        // Prepare SQL statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $password);

        // Execute statement
        $stmt->execute();

        // Fetch user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        if ($user) {
            // User authenticated, set session and redirect
            $_SESSION["email"] = $email;
            header("Location: dashboard.php"); // Redirect to index.php
            exit(); // Terminate script execution after redirection
        } else {
            // Invalid credentials
            echo "Invalid email or password!";
        }

        // Close statement
        $stmt = null;

        // Close database connection
        $pdo = null;

        // Terminate script execution
        die();
    } catch (PDOException $e) {
        // Handle PDOException and display error message
        die("Query Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR & Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      display: flex;
      min-height: 100vh;
      position: relative;
      overflow: hidden;
    }

    .company-info,
    .login-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      color: #ffffff;
    }

    .company-info {
      background-color: rgba(40, 167, 69, 0.8); /* Set background color with opacity */
      border-bottom-right-radius: 20px;
      border-top-right-radius: 20px;
      display: flex;
      align-items: center;
      padding: 40px;
    }

    .login-panel {
      background-color: rgba(255, 255, 255, 0.8); /* Set background color with opacity */
      border-bottom-left-radius: 20px;
      border-top-left-radius: 20px;
      position: relative;
      z-index: 1;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .company-info .logo img {
      width: 150px; /* Increase the width of the logo */
      height: auto;
      margin-right: 20px; /* Add margin to separate logo from text */
    }

    .company-info h2 {
      font-size: 36px; /* Increase the font size */
      font-weight: bold;
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Add text shadow */
      color: #ffffff; /* Set text color to white */
    }

    .company-info p {
      font-size: 20px; /* Increase the font size */
      margin-bottom: 20px;
      line-height: 1.6;
      color: #ffffff; /* Set text color to white */
    }

    .login-panel h1 {
      font-size: 32px;
      margin-bottom: 30px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      color: #218838;
    }

    .login-panel form {
      max-width: 400px;
      text-align: center;
    }

    .login-panel input[type="email"],
    .login-panel input[type="password"] {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      box-sizing: border-box;
      border: 2px solid #218838;
      background-color: #f5f5f5;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .login-panel input[type="email"]:focus,
    .login-panel input[type="password"]:focus {
      border-color: #28a745;
    }

    .login-panel input[type="submit"] {
      width: 200px;
      background-color: #218838;
      color: white;
      padding: 14px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 18px;
      transition: background-color 0.3s ease;
    }

    .login-panel input[type="submit"]:hover {
      background-color: #1e7e34;
    }

    .login-footer {
      margin-top: 20px;
      color: #777;
      font-weight: bold;
    }

    .register-link {
      margin-top: 20px;
      color: #777;
      font-weight: bold;
    }

    video {
      position: absolute;
      top: 0;
      left: 0;
      width: 50%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
      opacity: 0.8;
    }

    @media only screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .company-info,
      .login-panel {
        width: 100%;
        border-radius: 0;
      }

      video {
        width: 100%;
        height: auto;
      }
    }
  </style>

</head>
<body>

<div class="container">
  <video autoplay loop muted>
    <source src="video.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
  <div class="company-info">
    <div class="logo">
      <img src="logo.png" alt="Superpack Enterprise GIF">
    </div>
    <div>
      <h2><span style="color: #ffffff;">SUPERPACK</span> ENTERPRISE</h2>
      <p>HR & Management with us. Because your box matters.</p>
    </div>
  </div>
  <div class="login-panel">
    <form method="post" action="login.php">
      <h1>Welcome Admin!</h1>
      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>
      <input type="submit" value="Sign In">
    </form>
    <div class="login-footer">
      <p>Powered by Superpack</p>
      <palign="center"><a href="forget_password.php">Forgot Password</a></p>
    </div>
    <!-- New div for registration link -->
    <div class="register-link">
      <p>Don't have an account? <a href="register.php">New Admin? Register Here</a></p>
    </div>
  </div>
</div>

</body>
</html>