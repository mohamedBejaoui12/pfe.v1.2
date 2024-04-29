<?php
include "fonction.php";
$conn = pdo_connect();

if(isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];
    $sql_select = "SELECT * FROM teachers WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->execute([$update_id]);
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);
    $existing_img = $row['img']; 
    
    if(isset($_POST['update'])) {
        
        $fullName = $_POST['fullName'];
        $location = $_POST['location'];
        $subjects = $_POST['subjects'];
        $description = $_POST['description'];
        $numeroTel = $_POST['numeroTel'];
        
        
        if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name'])) {
            $img = file_get_contents($_FILES['img']['tmp_name']);
        } else {
            
            $img = $existing_img;
        }

        $sql_update = "UPDATE teachers SET fullName=?, location=?, subjects=?, numeroTel=?, description=?, img=? WHERE id=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':fullName', $fullName);
        $stmt_update->bindParam(':location', $location);
        $stmt_update->bindParam(':subjects', $subjects);
        $stmt_update->bindParam(':description', $description);
        $stmt_update->bindParam(':numeroTel', $numeroTel);
        $stmt_update->bindParam(':img', $img, PDO::PARAM_LOB);
        $stmt_update->execute([$fullName, $location, $subjects, $numeroTel, $description, $img, $update_id]);
        
        header("Location: admin.php"); 
        exit();
    }
    htmlHeader('HOME PAGE');
    
    ?>
    
    <div class="container px-5 resCont">
        <h2 class="my-5">Update Teacher</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name:</label>
                <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo $row['fullName']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['location']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="subjects" class="form-label">Subjects:</label>
                <input type="text" class="form-control" id="subjects" name="subjects" value="<?php echo $row['subjects']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="numeroTel" class="form-label">Numero Telephone:</label>
                <input type="text" class="form-control" id="numeroTel" name="numeroTel" pattern="[0-9]{1,8}" title="Please enter up to 8 numeric characters." value="<?php echo $row['numeroTel']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="5"><?php echo $row['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Image:</label>
                <input type="file" class="form-control" id="img" name="img">
            </div>
            <input type="submit" name="update" value="Update" class="btn btn-dark" style="width: 100%;">
        </form>
    </div>
<?php
    htmlFooter();
    exit();
} else {
    header("Location: admin.php"); 
    exit();
}
?>
