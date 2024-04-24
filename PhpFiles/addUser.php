<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="phpstyle.css">
    <title>Add</title>
</head>

<body>

    <div class="form">

        <div class="card2">
            <div class="card">
            
                <div class="card-header">
                    <h4>Sign Up</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="number" class="form-control" id="age" name="age" placeholder="Age" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <select class="form-control" id="niveauScolaire" name="niveauScolaire" required>
                                    <option value="" disabled selected>Select a level</option>
                                    <option value="L'enseignement Primaire">L'enseignement Primaire</option>
                                    <option value="L'enseignement Préparatoire">L'enseignement Préparatoire</option>
                                    <option value="L'enseignement Secondaire">L'enseignement Secondaire</option>
                                    <option value="License">License</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="background-color:rgb(226, 119, 36);border:none; width:100%" name="login">Sign UP</button>
                        <p>already have an account? <a class="link" href="login.php">log in</a></p>
                    </form>
                    <div class="card-header">
                   <a href="../index.html"><i class="fa-solid fa-arrow-left" style="color: rgb(226, 119, 36);font-size: 25px;"></i></a>
                </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    include "connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['age']) && isset($_POST['niveauScolaire'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $age = $_POST['age'];
            $niveauScolaire = $_POST['niveauScolaire'];

            $stmt = $con->prepare("INSERT INTO user (firstName, lastName, age, niveauScolaire, email, password) VALUES (:firstName, :lastName, :age, :niveauScolaire, :email, :password)");
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':niveauScolaire', $niveauScolaire);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            try {
                $stmt->execute();
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "All fields are required.";
        }
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
