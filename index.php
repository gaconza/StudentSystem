<?php
include "controller/functions.php";
include "partials/header.php";
include "config/db.php";

// Verificar se o usuário já está logado e redirecionar para o dashboard
if (isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os dados do formulário com proteção contra SQL Injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Consultar o banco de dados para verificar se o usuário existe
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    // Verificar se a consulta retornou resultados
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        // Verificar a senha
        if (password_verify($password, $user['password'])) {
            // Sessão de login bem-sucedida
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
    
    <!-- Caixa de Login -->
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
