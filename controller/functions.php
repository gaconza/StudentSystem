
<?php
include dirname(__DIR__) . '/config/db.php';

// Função para definir a classe ativa no menu de navegação
function setActiveClass($page) {
    $current_page = basename($_SERVER['PHP_SELF']);  // Obtém o nome da página atual
    return $current_page == $page ? 'active' : '';  // Retorna 'active' se for a página atual
}
//Função para testar se o email já existe no BD
function email_exists($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}
//Função para testar se o usuário está logado
function is_user_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
if (isset($_POST['add_student'])) {
    $studentID = mysqli_real_escape_string($conn, $_POST['studentID']);
    $studentName = mysqli_real_escape_string($conn, $_POST['studentName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validação básica (adapte conforme necessário)
    if (!empty($studentID) && !empty($studentName) && !empty($email)) {
        // Inserção no banco de dados
        $query = "INSERT INTO students (studentID, studentName, email) 
                  VALUES ('$studentID', '$studentName', '$email')";
        
        if (mysqli_query($conn, $query)) {
            // Sucesso
            $_SESSION['message'] = "Student added successfully!";
            header("Location: ../view/dashboard.php");  // Redireciona para o dashboard
            exit();
        } else {
            // Erro
            $_SESSION['message'] = "Error adding student: " . mysqli_error($conn);
            header("Location: ../view/dashboard.php");  // Redireciona para o dashboard
            exit();
        }
    } else {
        $_SESSION['message'] = "Please fill all fields.";
        header("Location: ../view/dashboard.php");  // Redireciona para o dashboard
        exit();
    }
}

if (isset($_GET['delete_student_id'])) {
    $studentID = mysqli_real_escape_string($conn, $_GET['delete_student_id']);
    
    // Exclui o estudante do banco de dados
    $query = "DELETE FROM students WHERE studentID = '$studentID'";
    
    if (mysqli_query($conn, $query)) {
        // Sucesso
        $_SESSION['message'] = "Student deleted successfully!";
        header("Location: ../view/dashboard.php");  // Redireciona para o dashboard
        exit();
    } else {
        // Erro
        $_SESSION['message'] = "Error deleting student: " . mysqli_error($conn);
        header("Location: ../view/dashboard.php");  // Redireciona para o dashboard
        exit();
    }
}
?>
