<?php 
include 'db_connection.php';

    $username=$email=$password=$confirm_password="";
    $username_error=$email_error=$password_error=$confirm_password_error="";
    $haserror=false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirm_password=$_POST['confirm_password'];

    //validate username
    if(empty($username)){
        $username_error="username is required";
        $haserror=true;
    }
    //validate email
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $email_error="Email format is not valid";
        $haserror=true;
    }
    //validata password
    if(strlen($password)<6){
        $password_error="password must have at least 6 characters";
        $haserror=true;
    }
    //validate confirm password
    if($confirm_password!=$password){
        $confirm_password_error="password and Confirm Password do not match";
        $haserror=true;
    }
    try {
        if(!$haserror){
            $stmt = $conn->prepare("INSERT INTO users (username,email, password,confirm_password) VALUES (:username,:email, :password,:confirm_password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':confirm_password', $confirm_password);
            $stmt->execute();
            header("location:/WEB2-p1/login.php");
        }
    } catch (PDOException $e) {
        $email_error=$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    .divider:after,
    .divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
    }
    .h-custom {
    height: calc(100% - 73px);
    }
    @media (max-width: 450px) {
    .h-custom {
    height: 100%;
    }
    }
    </style>
</head>
<body>


    <section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
        
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="POST">
            <!-- username input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="username">usename</label>
                <input type="text" id="username" class="form-control form-control-lg"
                placeholder="Enter a valid username" name="username" value="<?= $username?>"/>
                <span class="text-danger"><?= $username_error ?></span>
                
            </div>
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example3">Email address</label>
                <input type="email" id="form3Example3" class="form-control form-control-lg"
                placeholder="Enter a valid email address" name="email" value="<?= $email ?>" />
                <span class="text-danger"><?= $email_error ?></span>
                
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="form3Example4">Password</label>
                <input type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Enter password" name="password" value="<?= $password?>"/>
                <span class="text-danger"><?= $password_error ?></span>
               
            </div>

             <!--Confoirm Password input -->
             <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" class="form-control form-control-lg"
                placeholder="Enter Confirm password" name="confirm_password" value="<?= $confirm_password?>"/>
                <span class="text-danger"><?= $confirm_password_error ?></span>
                
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <!-- Checkbox -->
                <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                    Remember me
                </label>
                </div>
                
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
                <div class="offset-sm-4 col-sm-4 d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>

                <p class="small fw-bold mt-2 pt-1 mb-0">You have an account? <a href="login.php"
                    class="link-danger">Login</a></p>
            </div>

            </form>
        </div>
        </div>
    </div>

    <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
        Copyright © 2024. All rights reserved.
        </div>
        <!-- Copyright -->

    </div>
    </section>
    
</body>
</html>