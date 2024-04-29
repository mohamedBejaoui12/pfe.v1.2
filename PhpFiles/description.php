<?php
include 'connect.php';
session_start();
$errors = [];
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM teachers WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

    if(!$result){
        $errors[] = "Teacher not found.";
    } else {
        $imageData = base64_encode($result["img"]);
        $src = 'data:image/jpeg;base64,'.$imageData;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Description</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./userStyle.css">
    <style>
        section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 100px auto;
            width: 70%;
            gap: 10px;
        }
        .img_container {
            width: 60%;
            height: 500px;
            cursor: pointer;
            overflow: hidden;        }
        .img_container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .text_container h1 {
            font-size: 50px;
            margin-bottom: 20px;
        }
        .text_container h3 {
            font-size: 23px;
            margin: 5px 0px;
        }
        .text_container p {
            font-size: 18px;
            margin: 10px 0px;
        }
        .cont {
            width: 200px;
        }
        h1{
            color: #18335D;
            font-weight: 700;
            margin-bottom: 32px;
        }
        h3{
            margin-bottom: 15px;
        }
        span{
            color: rgb(226, 119, 36);
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
        
        <form class="d-flex ms-auto" role="search" method="GET" action="teachers.php" style="margin-right: 20px;">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" style="color: rgb(226, 119, 36);font-size: 18px; font-weight: 500;text-align: left;">
            <button class="btn" style="color: rgb(226, 119, 36);font-size: 18px; font-weight: 500;background-color: white;margin-left: 10px;" type="submit">Search</button>
        </form>
    </div>
</nav>
    <section style="border: none;">
        <div class="img_container">
            <?php if(isset($src)): ?>
                <img src="<?php echo $src ?>" alt="Teacher image"/>
            <?php endif; ?>
        </div>
        <div class="container">
            <?php if(isset($result)): ?>
                <h1><?php echo $result['fullName']; ?></h1>
                <h3> <span>Location :</span>   <?php echo $result['location']; ?></h3>
                <h3> <span>Subjects :</span>   <?php echo $result['subjects']; ?></h3>
                <h3> <span>Telephone :</span>   <?php echo $result['numeroTel']; ?></h3>
                <p style="font-size: 18px;"><?php echo $result['description']; ?></p>
            <?php endif; ?>
            <?php foreach($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>