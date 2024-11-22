<?php
    include 'db_connection.php';
    $username_error=$password_error="";


    if($_SERVER['REQUEST_METHOD']=="POST"){
        $username=$_POST['username'];
        $password=$_POST['password'];


    $stmt= $conn->prepare('SELECT username , password From users WHERE username=? AND password=?');
    $stmt->execute([$username,$password]);
    $count=$stmt->rowCount();
    echo $count;
    if($count >0){
        setcookie("user",$username,strtotime("+1 year"));
        header("Location:index.php");
        exit();
    }
    else{
        $username_error="please check your name";
        $password_error="please check your password";
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
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form3Example3">username</label>
                <input type="text" id="form3Example3" class="form-control form-control-lg"
                placeholder="Enter a valid name "name="username"   />
                <span class="text-danger"><?= $username_error ?></span>

            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="form3Example4">Password</label>
                <input type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Enter password"  name="password" />
                <span class="text-danger"><?= $password_error ?></span>

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
                <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php"
                    class="link-danger">Register</a></p>
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