<?php
include 'fonction.php';
htmlHeader('HOME PAGE');
$conn = pdo_connect();

$limit = 5; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit; 

$sql = "SELECT * FROM teachers LIMIT $start, $limit";
$stmt = $conn->query($sql);

$total_records = $conn->query("SELECT count(*) as total FROM teachers")->fetch()['total'];
$total_pages = ceil($total_records / $limit); 
?>

<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center mt-5">
        <p>Pour ajouter un nouveau professeur, cliquez sur le bouton  :</p>
    </div>
   
    <a href="addUser.php" class="d-flex justify-content-center align-items-center" style="text-decoration: none; color: inherit;">
    <button class="btn btn-lg btn-dark mb-5" style="width: 30%; text-decoration: none; cursor: pointer;">Ajouter un Professeur</button>
</a>

    <table class="table">
        <caption style="text-align: center;">Toute Les professeur Enregistree</caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Image</th>
                <th scope="col">ID</th>
                <th scope="col">Nom Complet</th>
                <th scope="col">Location</th>
                <th scope="col">Matières</th>
                <th scope="col">Numéro de Téléphone</th>
                <th scope="col">Description</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
                <tr>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" alt="Teacher Image" style="max-width: 100px;"></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fullName']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['subjects']; ?></td>
                    <td><?php echo $row['numeroTel']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="update.php?update_id=<?php echo $row['id']; ?>"><button class="btn btn-success">Modifier</button></a></td>
                        <td><a href="delete.php?delete_id=<?php echo $row['id']; ?>"><button class="btn btn-danger">Supprimer</button></a></td>
                        
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php if ($total_pages > 1): ?>
    <div class="d-flex justify-content-center align-items-center">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo ($page - 1); ?>" class="mx-2" style='text-decoration: none;'><i class="fa-solid fa-arrow-left"></i></a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="mx-2" style='text-decoration: none;' <?php if ($page == $i) echo 'style="font-weight:bold"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo ($page + 1); ?>" class="mx-2" style='text-decoration: none;'><i class="fa-solid fa-arrow-right"></i></a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php
htmlFooter();
?>
