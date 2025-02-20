<?php
session_start();

include '../config/db.php';
include '../partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/FS2/StudentSystem/style.css">
    <script>
        // Função de confirmação para excluir
        function confirmDelete(studentID) {
            if (confirm("Are you sure you want to delete this student?")) {
                window.location.href = "../controller/functions.php?delete_student_id=" + studentID;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 style="text-align:center">Student Dashboard</h2>
        
        <!-- Tabela de Estudantes -->
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT studentID, studentName, email FROM students ORDER BY studentID DESC";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['studentID'] . "</td>";
                        echo "<td>" . $row['studentName'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td><button class='delete-btn' onclick='confirmDelete(" . $row['studentID'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No students found</td></tr>";
                }
                ?>
                
                <!-- Formulário para adicionar um novo estudante -->
                <form action="../controller/functions.php" method="POST">
                    <tr>
                        <td><input type="text" name="studentID" required></td>
                        <td><input type="text" name="studentName" required></td>
                        <td><input type="email" name="email" required></td>
                        <td><button type="submit" name="add_student">Add Student</button></td>
                    </tr>
                </form>
            </tbody>
        </table>
        <form action="../logout.php" method="POST">
<button type="submit" class="button">Logoff</button>
    </div>
</body>
</html>



