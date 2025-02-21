<?php
include "../controller/functions.php";
include "../partials/header.php";
include "../config/db.php";


// Checks if the user is logged in and redirects to the dashboard
if (isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recover the data from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // First, checks if the password match (local validation)
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        
        // Protect against SQL Injection
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);

        // Checks if the email already exists in the DB
        $checkEmailQuery = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $checkResult = mysqli_query($conn, $checkEmailQuery);
        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $error = "Email already registered. Please use another one.";
        } else {
            
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert a new user in the DB
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$passwordHash')";
            
            if (mysqli_query($conn, $sql)) {
                
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<div class="container">
    <h2 style="text-align:center">Register</h2>
    <p style="color:red"><?php echo $error; ?></p>
    
    <!-- Registration Box -->
    <div class="register-box">
        <form method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" placeholder="Enter your username" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password:</label>
                <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p class="register-link">
            <a href="../index.php">Already have an account? Login here</a>
        </p>
    </div>
</div>

<?php
?>
