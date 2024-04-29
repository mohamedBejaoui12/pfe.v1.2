<?php
include "fonction.php";
$conn = pdo_connect();

if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    $sql_delete = "DELETE FROM teachers WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    if ($stmt_delete->execute([$delete_id])) {
        echo "<script>alert('Record deleted successfully.'); window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting record'); window.location.href = 'admin.php';</script>";
    }
}
?>
