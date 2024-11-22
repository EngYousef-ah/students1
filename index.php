<?php
session_start();
include 'db_connection.php';
try {
    if (!empty($_COOKIE['user'])) {
        $stmt2 = $conn->prepare('SELECT id FROM users WHERE username = ?');
        $stmt2->execute([$_COOKIE['user']]);
        $userid = $stmt2->fetchColumn();

        if ($userid) {
            $stmt = $conn->prepare("SELECT * FROM clients WHERE userid = ?");
            $stmt->execute([$userid]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $results = [];
        }
    } else {
        $results = [];
    }
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html,
        body,
        .intro {
            height: 100%;
        }

        .gradient-custom-1 {
            background: #cd9cf2;
            background: -webkit-linear-gradient(to top, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1));
            background: linear-gradient(to top, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1));
        }

        table td,
        table th {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        tbody td {
            font-weight: 500;
            color: #999999;
        }
    </style>
</head>

<body>
    <!--Start NavBar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent ">
        <div class="container bg-white">
            <a class="navbar-brand" href="#home">
                <h1 class="text-dark">Students</h1>
            </a>

            <button class="navbar-toggler shadow-none border-0 " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon bg-dark"></span>
            </button>
            <div class="sidebar offcanvas offcanvas-start bg-dark" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header text-white border-bottom ">
                    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Studens</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>


                <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0 bg-white">
                    <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active text-dark nv" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-dark nv" href="create.php">Add Student Details</a>
                        </li>

                    </ul>
                    <?php
                    if (empty($_COOKIE['user'])) { ?>
                        <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                            <a href="register.php" id="signAndLogout"
                                class="text-white text-decoration-none px-3 py-1  rounded-4"
                                style="background-color : #151415;">Register</a>
                        </div>
                        <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">

                            <a href="login.php" id="signAndLogout"
                                class="text-white text-decoration-none px-4 py-1 mx-3 rounded-4"
                                style="background-color : #151415;">Login</a>
                        <?php
                    } else { ?>
                            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                                <a href="logout.php" id="signAndLogout"
                                    class="text-white text-decoration-none px-3 py-1  rounded-4"
                                    style="background-color : #151415;">Logout</a>
                            </div>
                        <?php  }
                        ?>

                        </div>
                </div>
            </div>
    </nav>
    <!--End NavBar-->



    <!-- Start table students-->
    <section class="intro">
        <div class="gradient-custom-1 h-100">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="table-responsive bg-white">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Edit / Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $result): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($result['id']); ?></td>
                                                <td><?= htmlspecialchars($result['name']); ?></td>
                                                <td><?= htmlspecialchars($result['email']); ?></td>
                                                <td><?= htmlspecialchars($result['phone']); ?></td>
                                                <td><?= htmlspecialchars($result['address']); ?></td>
                                                <td><?= htmlspecialchars($result['created_at']); ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?= htmlspecialchars($result['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="delete.php?id=<?= htmlspecialchars($result['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php if (empty($_COOKIE['user'])): ?>
                                    <p class="text-center text-muted mt-3">You must create an account and log in to view results specific to each user.</p>
                                <?php elseif(empty($results) && !empty($_COOKIE['user'])): ?>
                                    <p class="text-center text-muted mt-3">No records found for this user.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End table students-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>