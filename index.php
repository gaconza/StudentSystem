<?php
include "controller/functions.php";
include "partials/header.php";
include "config/db.php";

// Checks if the user is logged in and redirects to the dashboard
if (isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recover the data from the form with protection against SQL Injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    // Checks if the query returned results
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $user['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<div class="container">
    <h2 style="text-align:center">Welcome to the Student System</h2>
    <p style="color:red"><?php echo $error; ?></p>
    
    <!-- Login Box -->
    <div class="login-box">
        <form method="POST">
            <div class="input-group">
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" formaction="view/dashboard.php">Login</button>
        </form>
        <p class="register-link">
            <a href="view/register.php">Don't have an account? Register here</a>
        </p>
    </div>
</div>

<?php
?>
