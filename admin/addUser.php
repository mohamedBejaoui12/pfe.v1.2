<?php
include 'fonction.php';
$conn = pdo_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $location = $_POST['location'];
    $subjects = $_POST['subjects'];
    $description = $_POST['description'];
    $numeroTel = $_POST['numeroTel'];

  
    $img = file_get_contents($_FILES['img']['tmp_name']);

    $sql = "INSERT INTO teachers (fullName, location, subjects,numeroTel, description, img) VALUES (:fullName, :location, :subjects,:numeroTel, :description, :img)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':subjects', $subjects);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':numeroTel', $numeroTel);
    $stmt->bindParam(':img', $img, PDO::PARAM_LOB);
    try {
        $stmt->execute();
        header('location:admin.php');
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
htmlHeader('HOME PAGE');
?>

<div class="container px-5 resCont">
    <h2 class="my-5">Ajouter un Professeur</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullName" name="fullName" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="mb-3">
            <label for="subjects" class="form-label">subjects:</label>
            <input type="text" class="form-control" id="subjects" name="subjects" required>
        </div>
        <div class="mb-3">
            <label for="numeroTel" class="form-label">Numero Telephone:</label>
            <input type="text" class="form-control" id="numeroTel" name="numeroTel" pattern="[0-9]{1,8}" title="Please enter up to 8 numeric characters." required>

        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">Image:</label>
            <input type="file" class="form-control" id="img" name="img" required>
        </div>
        <button type="submit" class="btn btn-dark" style="width: 100%;">Ajouter</button>
    </form>
</div>

<?php
htmlFooter();
?>
