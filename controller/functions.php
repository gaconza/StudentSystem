
<?php
include dirname(__DIR__) . '/config/db.php';

function setActiveClass($page) {
    $current_page = basename($_SERVER['PHP_SELF']);  
    return $current_page == $page ? 'active' : '';  
}

//Test if the user´s email already exist in the DB
function email_exists($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}
//Function to test if the user is logged in
function is_user_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
if (isset($_POST['add_student'])) {
    $studentID = mysqli_real_escape_string($conn, $_POST['studentID']);
    $studentName = mysqli_real_escape_string($conn, $_POST['studentName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validation
    if (!empty($studentID) && !empty($studentName) && !empty($email)) {
        // Insert into DB
        $query = "INSERT INTO students (studentID, studentName, email) 
                  VALUES ('$studentID', '$studentName', '$email')";
        
        if (mysqli_query($conn, $query)) {
            // Success
            $_SESSION['message'] = "Student added successfully!";
            header("Location: ../view/dashboard.php");  // Redireciona para o dashboard
            exit();
        } else {
            // Error
            $_SESSION['message'] = "Error adding student: " . mysqli_error($conn);
            header("Location: ../view/dashboard.php");  
            exit();
        }
    } else {
        $_SESSION['message'] = "Please fill all fields.";
        header("Location: ../view/dashboard.php");  
        exit();
    }
}

if (isset($_GET['delete_student_id'])) {
    $studentID = mysqli_real_escape_string($conn, $_GET['delete_student_id']);
    
    // Delete the student from the DB
    $query = "DELETE FROM students WHERE studentID = '$studentID'";
    
    if (mysqli_query($conn, $query)) {
        // Success
        $_SESSION['message'] = "Student deleted successfully!";
        header("Location: ../view/dashboard.php");  
        exit();
    } else {
        // Error
        $_SESSION['message'] = "Error deleting student: " . mysqli_error($conn);
        header("Location: ../view/dashboard.php");  
        exit();
    }
}
?>
