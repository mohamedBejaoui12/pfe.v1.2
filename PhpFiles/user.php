<?php
include "connect.php"; // Include your database connection file
session_start();

if(empty($_SESSION['login'])){
    header('location:login.php');
}

// Set the number of rows per page
$rowsPerPage = 5;

// Initialize variables for search
$search = '';
$searchCondition = '';

// Check if search query is provided
if(isset($_GET['search'])){
    $search = $_GET['search'];
    // Construct the search condition for SQL query
    $searchCondition = "WHERE fullName LIKE '%$search%' OR subjects LIKE '%$search%'";
}

try {
    $userID = $_SESSION['id'];
    
    // Count total number of rows based on search condition
    $countSql = "SELECT COUNT(*) AS count FROM teachers $searchCondition";
    $countStm = $con->prepare($countSql);
    $countStm->execute();
    $rowCount = $countStm->fetchColumn();
    
    // Calculate total number of pages
    $totalPages = ceil($rowCount / $rowsPerPage);
    
    // Get current page number
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    
    // Calculate the starting row for the current page
    $startRow = ($currentPage - 1) * $rowsPerPage;
    
    // Fetch data for the current page based on search condition
    $sql = "SELECT * FROM teachers $searchCondition LIMIT :startRow, :rowsPerPage";
    $stm = $con->prepare($sql);
    $stm->bindValue(':startRow', $startRow, PDO::PARAM_INT);
    $stm->bindValue(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
    $stm->execute();
    $userData = $stm->fetchAll();
} catch(PDOException $e) {
    echo "error".$e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>All Teachers</title>

    <style>
        a{
            text-decoration: none;
            color:#18335D;
            font-weight: bold;
        }
        a:hover{
            color:#18335D;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top sticky-top" style="background-color: rgb(226, 119, 36);">
    <div class="container-fluid" style="max-width: 1240px;">
        <a class="navbar-brand me-4" href="#" style="font-size: 22px; font-weight: bold;">Our Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="#" style="margin: 0 10px; font-size: 18px; font-weight: 600;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="profile.php" style="margin: 0 15px; font-size: 18px; font-weight: 400;">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php" style="margin: 0 15px; font-size: 18px; font-weight: 400;">Sign Out</a>
                </li>
            </ul>
        </div>
   
        <form class="d-flex ms-auto" role="search" method="GET" action="teachers.php" style="margin-right: 20px;">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" style="color: rgb(226, 119, 36);font-size: 18px; font-weight: 500;text-align: left;" value="<?php echo $search; ?>">
            <button class="btn" style="color: rgb(226, 119, 36);font-size: 18px; font-weight: 500;background-color: white;" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container mt-5" style="max-width: 1040px;">
    <div>
        <h1 style="color: #18335D; font-weight: bold;margin-bottom: 30px;">Teachers</h1>
    </div>
    <?php
    if($userData){
        foreach($userData as $row){
            $imageData = base64_encode($row["img"]);
            $src = 'data:image/jpeg;base64,'.$imageData;
            echo '
            <div class="card mb-3 card-link" style="max-width:1040px;">
            <div class="row g-0">
            <div class="col-md-3">
            <img src="' .$src .'" class="img-fluid rounded-start" alt="Teacher Image">
        </div>
                <div class="col-md-9 d-flex justify-content-center align-items-center">
                    <div class="card-body">
                        <h3 class="card-title my-3" style="color:#18335D;font-weight: bold;">'.$row['fullName'].'</h3>
                        <h5 class="card-title my-3">'.$row['subjects'].'</h5>
                        <a href="description.php?id='. $row['id'] .'" >More Info <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

            ';
        }
    }
    ?>
    <!-- Pagination links -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for($page = 1; $page <= $totalPages; $page++): ?>
                <li class="page-item <?php if($page == $currentPage) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>&search=<?php echo $search; ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
