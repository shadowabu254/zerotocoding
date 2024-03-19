<?php

session_start();
require_once "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are set
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Include database connection file (replace with your actual database connection)

        // Sanitize input to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        // Prepare SQL query to retrieve user information
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables
                $_SESSION["username"] = $username;
                // Redirect to dashboard
                header("Location: contactus.html");
                exit();
            } else {
                // Invalid credentials, display error message
                $_SESSION['login_error'] = "Invalid password.";
            }
        } else {
            // Invalid credentials, display error message
            $_SESSION['login_error'] = "Invalid username or password.";
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    } else {
        // Username or password not set, display error message
        $_SESSION['login_error'] = "Please enter both username and password.";
    }
    // Clear session messages
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
  <link rel="stylesheet" href="logins.css">
</head>
<body>
    <video autoplay muted loop id="video-bg">
        <source src="images/hacker1.mp4" type="video/mp4">
        <!-- Add additional source tags if necessary for other video formats -->
        Your browser does not support the video tag.
    </video>
  <div class="background"></div>
  <div class="container">
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="form-group">
        <i class="fas fa-user input-icon"></i> <!-- Icon for username -->
        <input type="text" id="username" name="username" placeholder="Username" required>
      </div>
      <div class="form-group">
        <i class="fas fa-lock input-icon"></i> <!-- Icon for password -->
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="button" class="show-password-btn" id="show-password-btn" onclick="togglePasswordVisibility()">
          <i class="far fa-eye"></i> <!-- Eye icon for showing password -->
        </button>
      </div>
      <button class="signup" type="submit">Login</button>
      <?php
      // Display error message if set
      if (isset($error_message)) {
          echo '<p class="error-message">' . $error_message . '</p>';
      }
      ?>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
  </div>
  <script>
    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const passwordBtn = document.getElementById('show-password-btn');
      
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordBtn.innerHTML = '<i class="far fa-eye-slash"></i>'; // Change eye icon to open eye
      } else {
        passwordField.type = 'password';
        passwordBtn.innerHTML = '<i class="far fa-eye"></i>'; 
      }
    }
  </script>
</body>
</html>
