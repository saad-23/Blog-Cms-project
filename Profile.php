<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

if (isset($_GET['username'])) 
{
    $username = $_GET['username'];
    $sql = "SELECT * FROM admins WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":username",$username);
    $execute = $stmt->execute();
    $res = $stmt->rowCount();
    if ($res == 1) 
    {
        $admin_rows = $stmt->fetch();
    }
    else
    {
        $_SESSION['ErrorMessage'] = "Bad request!";
        redirect_to("Blog.php");
    }

}
else
{
    redirect_to('Blog.php');
}


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
    <title>Profile Page</title>
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
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline" action="Blog.php">
                        <div class="form-group">
                            <input type="text" name="search" placeholder="Search here" class="form-control mr-2">
                            <input type="submit" class="btn btn-primary" name="searchButton" value="Go">
                        </div>
                    </form>
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
                    <h1><i class="fas fa-user text-info"></i> Profile Page</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Ends -->

    <!-- Main Section starts -->
    <section class="container" style="min-height: 430px;">
        <div class="row">
            <div class="col-md-3">
                <img src="images/<?php echo isset($admin_rows['image']) ? $admin_rows['image'] : ''; ?>" 
                class="img-fluid d-block" width="200px">
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3>
                            <?php echo isset($admin_rows['headline']) ? $admin_rows['headline'] : ''; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php echo isset($admin_rows['bio']) ? $admin_rows['bio'] : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main section Ends -->
    
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