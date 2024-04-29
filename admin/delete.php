<?php
include "fonction.php";
$conn = pdo_connect();

if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    $sql_select = "SELECT fullName FROM teachers WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->execute([$delete_id]);
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);
    $fullName = $row['fullName'];
    
    echo "<script>
            var confirmDelete = confirm('Are you sure you want to delete the teacher: $fullName?');
            if(confirmDelete) {
                window.location.href = 'confirmD.php?delete_id=$delete_id';
            } else {
                window.location.href = 'admin.php';
            }
          </script>";
    
    exit();
} else {
    header("Location: admin.php"); 
    exit();
}
?>
