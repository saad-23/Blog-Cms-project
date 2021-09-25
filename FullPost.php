<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

$SearchQueryParameter = $_GET['id'];

if(isset($_POST['submit']))
{
    $name = $_POST['CommenterName'];
    $email = $_POST['CommenterEmail'];
    $comment = $_POST['CommenterThoughts'];
    date_default_timezone_set("Asia/Karachi");
    $currentTime = time();
    $datetime = strftime('%B-%d-%Y , %H:%M:%S',$currentTime);

    

    if(empty($name) || empty($email) || empty($comment))
    {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        redirect_to("FullPost.php?id={$SearchQueryParameter}");

    }
    elseif(strlen($cat_title) > 500)
    {
        $_SESSION["ErrorMessage"] = "Comment should be less than 500 characters";
        redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }
    else
    {
        // Insert query for adding Comment in database table
        $sql ="INSERT INTO comments (name,email,comment,datetime,approvedby,status,post_id)";
        $sql .= "VALUES (:name,:email,:comment,:datetime,'pending','off',:postIdFromUrl)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':comment',$comment);
        $stmt->bindParam(':datetime',$datetime);
        $stmt->bindParam(':postIdFromUrl',$SearchQueryParameter);
        $execute = $stmt->execute();
        
        if($execute)
        {
            $_SESSION["SuccessMessage"] = "Comment submitted successfully..";
            redirect_to("FullPost.php?id={$SearchQueryParameter}");
        }
        else
        {
            $_SESSION["ErrorMessage"] = "Something went wrong!Try again";
            redirect_to("FullPost.php?id={$SearchQueryParameter}");
        }



    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Full Post Page</title>
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
    <div class="container my-2">
        <div class="row">
            <div class="col-md-8">
                 <?php
                    echo ErrorMessage();
                    echo SuccessMessage();

                    
                ?>
                <h1>Complete Responsive CMS</h1>
                <h1 class="lead">Complete Blog Site by Saad Zaib</h1>
                <?php
					if(isset($_GET['searchButton']))
					{
						$search = $_GET['search'];
						$sql = "SELECT * FROM posts WHERE 
						   title LIKE :search 
						OR category LIKE :search
						OR datetime LIKE :search
						OR post LIKE :search";
						$stmt = $conn->prepare($sql);
						$stmt->bindValue(':search','%'.$search.'%');
						$stmt->execute();
					}
					else
					{
                        if(!isset($_GET['id']))
                        {
                           $_SESSION['ErrorMessage'] = "Bad Request !";
                           redirect_to("Blog.php");
                        }

                        $UserId = $_GET['id'];
						$sql = "SELECT * FROM posts WHERE id = '{$UserId}'";
						$stmt = $conn->query($sql);
					}
                   
                    while($records = $stmt->fetch())
                    {

                ?>
                <div class="card my-3">
                    <img src="uploads/<?php echo $records['image']; ?>" style="max-height: 450px;" class="img-fluid card-img-top">
                    <div class="card-body">
                        <h1 class="card-title"><?php  echo htmlentities($records['title']); ?></h1>
                        <small class="text-muted">
                            <?php  echo "Category: "?>
                            <a class="badge badge-info" href="Blog.php?category=<?php echo htmlentities($records['category']);  ?>"><?php echo htmlentities($records['category']);  ?>
                                
                            </a>
                            & Written by 
                            <a class="badge badge-secondary" href="Profile.php?username=<?php echo htmlentities($records['author']); ?>"><?php echo htmlentities($records['author']); ?>
                                
                            </a>
                            <?php echo " on ".$records['datetime']; ?>
                        </small>
                        <hr>
                        <p class="card-text">
                            <?php 
                            echo htmlentities($records['post']);  
                            ?>
                        </p>

                       
                    </div>

                </div>
                <?php } ?>

<!-- Comments section starts -->

    <!-- Fetching All comments -->
                
                <span class="FieldInfo">Comments</span>

                <?php
                    $sql = "SELECT * FROM comments WHERE post_id = '{$SearchQueryParameter}' AND status = 'on' ";
                    $stmt = $conn->query($sql);
                    while($DataRows = $stmt->fetch())
                    {
                        $CommenterName = $DataRows['name'];
                        $CommentDate = $DataRows['datetime'];
                        $Comment = $DataRows['comment'];
                
                ?>

                <div>
                    <div class="media CommentBlock">
                        <img src="images/avatar.png" class="img-fluid align-self-start" width="70px">
                        <div class="media-body ml-2">
                            <h6 class="lead">Name: <?php echo $CommenterName ?></h6>
                            <p class="small">Date: <?php echo $CommentDate ?></p>
                            <p>Comment: <?php echo $Comment ?></p>
                        </div>
                    </div>
                </div>
                <hr>

                <?php  
                    }
                ?>
    <!-- Fetching comments end -->
                <div>
                   <form action="FullPost.php?id=<?php echo $SearchQueryParameter;  ?>" method="POST">
                      <div class="card mb-3">
                        <div class="card-header">
                            <h5>Share your thought about this post</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="CommenterName" placeholder="Name" class="form-control">
                                </div>     
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="CommenterEmail" placeholder="Email" class="form-control">
                                </div>     
                            </div>

                            <div class="form-group">
                                <textarea name="CommenterThoughts" class="form-control" rows="8" cols="80"></textarea>
                            </div>
                            <div>
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                      </div>  
                   </form>
                </div>
<!-- Comments Section End -->

            </div>

<!-- Side Area Section -->
            <div class="col-md-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="images/startBlog.jpg" class="img-fluid d-block">
                        <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis ipsum consectetur pariatur odit ab quae dolore doloremque adipisci optio, asperiores velit voluptate ut perferendis unde voluptates nam, quo excepturi deserunt.</p>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light text-center">
                        <h2 class="lead">Sign Up!</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block text-center">Join the Forum</button>
                        <button type="button" class="btn btn-danger btn-block text-center">Login</button>
                        <div class="input-group mt-3">
                            <input type="text" name="email" placeholder="Enter Email" class="form-control">
                            <div class="input-group-append">
                                <input type="button" name="subscribe" value="Subscribe now" class="btn btn-primary btn-sm text-center text-white">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-light">
                        <h2>Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                            $sql = "SELECT * FROM category ORDER BY id DESC";
                            $stmt = $conn->query($sql);
                            while($rows = $stmt->fetch())
                            {

                        ?>
                              <a href="Blog.php?category=<?php echo $rows['title']; ?>"><span class="text-primary"><?php echo $rows['title']; ?></span></a><br>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-light">
                        <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php

                            $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,4";
                            $stmt = $conn->query($sql);
                            while($rec_posts = $stmt->fetch())
                            {

                        ?>
                        <div class="media">
                            <img src="uploads/<?php echo $rec_posts['image']; ?>" 
                            class="img-fluid d-block" width="70px">
                            <div class="media-body ml-2">
                                <a href="FullPost.php?id=<?php  echo $rec_posts['id']; ?>"><h6><?php  echo htmlentities($rec_posts['title']); ?></h6></a>
                                <p class="small"><?php  echo htmlentities($rec_posts['datetime']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
<!-- Side area section -->

        </div>
    </div>
<!-- Header Ends -->


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