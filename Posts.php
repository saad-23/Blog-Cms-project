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
    <title>Posts Page</title>
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
    <header class="bg-dark text-white py-3 my-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-blog text-info"></i>Blog Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"> Add New Post</i>
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"> Add New Category</i>
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"> Add New Admin</i>
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"> Approve Comments</i>
                    </a>
                </div>
                
            </div>
        </div>
    </header>
    <!-- Header Ends -->

    <!-- Main Section -->

    <section class="container my-3 py-2">
        <div class="row">
            <div class="col-md-12">
            <?php
                echo ErrorMessage();
                echo SuccessMessage();

            ?>
                <table class="table table-striped table-hover table-responsive">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date & time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    
                    $sql = "SELECT * FROM posts";
                    $stmt = $conn->query($sql);
                    $sr = 1;
                    while($row = $stmt->fetch())
                    {

                     ?>
                        <tr>
                            <td><?php  echo $sr++; ?></td>
                            <td><?php 
                                if(strlen($row['title']) > 20) { $row['title'] = substr($row['title'],0,15).'...';}
                                echo  $row["title"]; ?>
                            </td>
                            <td><?php  echo $row["category"]; ?></td>
                            <td><?php  echo $row["datetime"]; ?></td>
                            <td><?php  echo $row["author"]; ?></td>
                            <td><img src="uploads/<?php  echo $row["image"];?>" width="150px;" height="50px;">  </td>
                            <td>
                                
                                 <?php 
                                    $ApprovePostComments =  commentsOnPost($row['id'],"on");
                                    if ($ApprovePostComments > 0) 
                                    {
                                       echo "<a href='Comments.php'><span class='badge badge-success'>
                                               {$ApprovePostComments}
                                            </span></a>";
                                    } 

                                     $DisApprovePostComments =  commentsOnPost($row['id'],"off");
                                    if ($DisApprovePostComments > 0) 
                                    {
                                       echo "<a href='Comments.php'><span class='badge badge-danger'>
                                               {$DisApprovePostComments}
                                            </span></a>";
                                    } 


                                ?>    

                            </td>
                            <td>
                                <a href="EditPost.php?id=<?php echo $row['id'];  ?>" class="btn btn-warning">Edit</a>
                                <a href="DeletePost.php?id=<?php echo $row['id'];  ?>" class="btn btn-danger">Delete</a>

                            </td>
                            <td>
                                <a href="FullPost.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn btn-info">Live Preview</a>
                            </td>

                        </tr>
                    <?php  
                    } 
                    ?>
                    </tbody>
                </table>
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