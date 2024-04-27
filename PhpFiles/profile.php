<?php
include 'connect.php';
session_start();
if(empty($_SESSION['login'])){
    header('location:login.php');
    exit(); // Add exit() after header redirect to stop further execution
}
else{
    $userId = $_SESSION['id']; // Change $userID to $userId for consistency
    $sql3 = "SELECT * FROM user WHERE id = $userId"; // Update query variable name
    $stm3 = $con->prepare($sql3);
    $stm3->execute();
    $userData = $stm3->fetch();

    // Correct variable name to $userId
    $userId = $_SESSION['id'];
    $sql = "SELECT * FROM user WHERE id = $userId"; 
    $stm = $con->prepare($sql);
    $stm->execute();
    $row = $stm->fetch();
    if(isset($_POST['save'])){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $age=$_POST['age'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Correct variable name to $password
        // Update query variable name to $sql2
        $sql2 = "UPDATE user SET firstName='$firstName', lastName='$lastName',age=$age, email='$email', password='$password' WHERE id = $userId";
        $stm2 = $con->prepare($sql2); // Update prepared statement variable name
        $stm2->execute();
        if($stm2){
            echo '<div class="alert alert-info text-center w-50 m-auto">Updated successfully</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      .userName{
            font-size: 18px;
            text-transform: capitalize;}
       .btn{
        background-color: rgb(226, 119, 36);
        color: white;
        font-size: 15px;
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
                    <a class="nav-link active text-white" aria-current="page" href="user.php" style="margin: 0 10px; font-size: 18px; font-weight: 600;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="profile.php" style="margin: 0 15px; font-size: 18px; font-weight: 400;">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php" style="margin: 0 15px; font-size: 18px; font-weight: 400;">Sign Out</a>
                </li>
            </ul>
        </div>
        <!-- Search form with method GET -->
        <form class="d-flex ms-auto" role="search" method="GET" action="teachers.php" style="margin-right: 20px;">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" style="color: rgb(226, 119, 36);" value="">
            <button class="btn" style="color: rgb(226, 119, 36);font-size: 18px; font-weight: 500;background-color: white;" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Profile</h3>
                    <form method="post" action="profile.php">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row['firstName']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row['lastName']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age" value="<?php echo $row['age']?>" required>
                        </div>
                        <!-- <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select class="form-control" id="niveauScolaire" name="niveauScolaire">
                                <option value="L'enseignement Primaire">L'enseignement Primaire</option>
                                <option value="L'enseignement Préparatoire">L'enseignement Préparatoire</option>
                                <option value="L'enseignement Secondaire">L'enseignement Secondaire</option>
                                <option value="License">License</option>
                                <option value="Master">Master</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']?>" required>
                        </div>                         
                        <button type="submit" class="btn btn-block mt-3" name="save">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
