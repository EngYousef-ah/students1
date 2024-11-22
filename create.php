<?php
include 'db_connection.php';
if ( empty($_COOKIE['user'])) {
    header("Location: /WEB2-p1/login.php");
    exit;
}
$stmt2 = $conn->prepare('SELECT id FROM users WHERE username = ?');
$stmt2->execute([$_COOKIE['user']]);
$userid = $stmt2->fetchColumn();
$name = $email = $phone = $address = "";
$errorMessage = $successMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errorMessage = "All fields are required.";
            break;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format.";
            break;
        }
        $stmt = $conn->prepare("INSERT INTO clients (name, email, phone, address, userid) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$name, $email, $phone, $address, $userid]);
        if (!$result) {
            $errorMessage = "Database error: " . $stmt->errorInfo()[2];
            break;
        }
        $successMessage = "Client added successfully.";
        header("Location: /WEB2-p1/index.php");
        exit;
    } while (false);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myshop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Student</h2>
        <?php 
            if(!empty($errorMessage)){
                echo "
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong?>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            }
        ?>
        <form method="post">
            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Name</label>
                <div class=" col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Email</label>
                <div class=" col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">phone</label>
                <div class=" col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Address</label>
                <div class=" col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address ?>">
                </div>
            </div>

            <?php
                if(!empty($successMessage)){
                    echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong?>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
                }
            
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="/web2-p1/index.php" class="btn btn-outline-primary" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
  
    
</body>
</html>