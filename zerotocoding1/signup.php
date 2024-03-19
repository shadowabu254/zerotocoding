<?php
require_once "db_connection.php";

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Validate input
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // Check if there are any validation errors
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            $_SESSION['signup_success'] = "Sign-up successful. You can now login.";
            header("Location: index.php"); // Redirect to login page
            exit();
        } else {
            $_SESSION['signup_error'] = "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        // Store validation errors in session
        $_SESSION['signup_errors'] = $errors;
    }
     // Clear session messages
     unset($_SESSION['signup_success']);
     unset($_SESSION['signup_error']);
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
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
    <h1>Sign Up</h1>
    <form action="signup.php" method="POST">
      <div class="form-group">
        <i class="fas fa-user input-icon"></i> <!-- Icon for username -->
        <input type="text" id="username" name="username" placeholder="Username" required>
      </div>
      <div class="form-group">
        <i class="fas fa-envelope input-icon"></i><!-- Icon for email -->
        <input type="email" id="email" name="email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <i class="fas fa-lock input-icon"></i> <!-- Icon for password -->
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="button" class="show-password-btn" id="show-password-btn" onclick="togglePasswordVisibility()">
          <i class="far fa-eye"></i> <!-- Eye icon for showing password -->
        </button>
      </div>
      <button class="signup" type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="index.php">Login</a></p>
  </div>
  <script>
    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const passwordBtn = document.getElementById('show-password-btn');
      
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordBtn.innerHTML = '<i class="far fa-eye-slash"></i>'; <!-- Change eye icon to open eye -->
      } else {
        passwordField.type = 'password';
        passwordBtn.innerHTML = '<i class="far fa-eye"></i>'; 
      }
    }
  </script>
</body>
</html>
