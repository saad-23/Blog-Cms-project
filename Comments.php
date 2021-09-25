<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

$_SESSION['tracking_url'] = $_SERVER['PHP_SELF'];
confirmLogin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Blog Cms site | Comments Page</title>
</head>
<body>
    <!-- Navbar -->
    <div style="height: 10px;background-color: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand">saadzaib1123@gmail.com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapsecms">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapsecms">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="Logout.php" class="nav-link"><i class="fas fa-user-times"></i> logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px;background-color: #27aae1;"></div>

    <!-- Navbar Ends -->
    
    <!-- Header -->
    <header class="bg-dark text-white my-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-comments text-info"></i> Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Ends -->
    <!-- Main section of comments start -->
    <section class="container py-3 mb-2">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();

                ?>
<!-- Un-approved comments section -->
                <h2>Un-approved comments</h2>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>Date Time</th>
                            <th>Content</th>
                            <th colspan="2" class="text-center">Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM comments WHERE status = 'off' ORDER BY id desc";
                            $execute = $conn->query($sql);
                            $sr_no = 0;
                            while($dataRows = $execute->fetch())
                            {
                            $sr_no++;
                        ?>
                        <tr>
                            <td><?php echo $sr_no; ?></td>
                            <td><?php  echo htmlentities($dataRows['name']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['datetime']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['comment']);  ?></td>
                            <td><a href="ApproveComments.php?id=<?php echo $dataRows['id']; ?>" class="btn btn-success">Approve</a></td>
                            <td><a href="DeleteComments.php?id=<?php echo $dataRows['id']; ?>" class="btn btn-danger">Delete</a></td>
                            <td><a href="FullPost.php?id=<?php echo $dataRows['post_id']; ?>" class="btn btn-info">Live Preview</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>

<!-- Approved Comments section  -->
                <h2>Approved comments</h2>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>Date Time</th>
                            <th>Content</th>
                            <th colspan="2" class="text-center">Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM comments WHERE status = 'on' ORDER BY id desc";
                            $execute = $conn->query($sql);
                            $sr_no = 0;
                            while($dataRows = $execute->fetch())
                            {
                            $sr_no++;
                        ?>
                        <tr>
                            <td><?php echo $sr_no; ?></td>
                            <td><?php  echo htmlentities($dataRows['name']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['datetime']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['comment']);  ?></td>
                            <td><a href="DisApproveComments.php?id=<?php echo $dataRows['id']; ?>" class="btn btn-warning">Dis-Approve</a></td>
                            <td><a href="DeleteComments.php?id=<?php echo $dataRows['id']; ?>" class="btn btn-danger">Delete</a></td>
                            <td><a href="FullPost.php?id=<?php echo $dataRows['post_id']; ?>" class="btn btn-info">Live Preview</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Main section of comments Ends -->
    <!-- Footer  -->
    <div style="height: 10px;background-color: #27aae1;"></div>
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-center">Theme by | Saad Zaib | &copy; --------</p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height: 10px;background-color: #27aae1;"></div>
    <!-- Footer Ends -->


    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>