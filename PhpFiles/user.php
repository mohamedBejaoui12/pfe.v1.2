<?php
include "connect.php"; // Include your database connection file
session_start();

if(empty($_SESSION['login'])){
    header('location:login.php');
}
try{


$userID = $_SESSION['id'];
$sql = "SELECT * FROM teachers";
$stm = $con->prepare($sql);
$stm->execute();
$userData = $stm->fetchAll();
}catch(PDOException $e){
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
    <title>Teachers</title>
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
                    <a class="nav-link text-white" href="#" style="margin: 0 15px; font-size: 18px; font-weight: 400;">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" style="margin: 0 15px; font-size: 18px; font-weight: 400;">Sign Out</a>
                </li>
            </ul>
        </div>
        <form class="d-flex ms-auto" role="search" style="margin-right: 20px;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="color: rgb(226, 119, 36);">
            <button class="btn" style="color: rgb(226, 119, 36);font-size: 18px; font-weight: 500;background-color: white;" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container mt-5" style="max-width: 1040px;">
    <div><h1 style="color: #18335D; font-weight: bold;margin-bottom: 30px;">Teachers</h1></div>
    <?php
    if($userData){
        foreach($userData as $row){
            // Assuming you have 'img' column in your teachers table which stores the image as BLOB
            $imageData = base64_encode($row["img"]);
            $src = 'data:image/jpeg;base64,'.$imageData;
            echo '
            <div class="card mb-4" style="width: 100%;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="' .$src .'" class="img-fluid rounded-start" alt="Teacher Image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title" style="color:#18335D;font-weight: bold;">'.$row['fullName'].'</h3>
                            <h5 class="card-title">'.$row['subjects'].'</h5>
                            <p class="card-text">'.$row['description'].'</p>
                            <p class="card-text"><small class="text-body-secondary">'.$row['numeroTel'].'</small></p>
                            <p class="card-text"><small class="text-body-secondary">'.$row['location'].'</small></p>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
