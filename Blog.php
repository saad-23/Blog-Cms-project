<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";
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
    <title>Blog Page</title>
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
                <h1>Complete Responsive CMS</h1>
                <h1 class="lead">Complete Blog Site by Saad Zaib</h1>
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();

                ?>
                <?php

// Query when search button is active

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

//  Query when pagination link is active

                    else if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                        if ($page < 1) 
                        {
                            $showPostFrom = 0;
                        }
                        else
                        {
                            $showPostFrom = ($page * 4) - 4;
                        }
                        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 
                        {$showPostFrom},4 ";
                        $stmt = $conn->query($sql);
                    }

// Query when category is active in url

                    else if(isset($_GET['category']))
                    {
                        $url_category = $_GET['category'];
                        $sql = "SELECT * FROM posts WHERE category = :cat ORDER BY id DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":cat",$url_category);
                        $stmt->execute();
                    }

// Default Query

					else
					{
						$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,4";
						$stmt = $conn->query($sql);
					}
                   
                    while($records = $stmt->fetch())
                    {

                ?>
                <div class="card my-3">
                    <img src="uploads/<?php echo $records['image']; ?>" style="max-height: 450px;" class="img-fluid card-img-top">
                    <div class="card-body">
                        <h1 class="card-title"><?php  echo htmlentities($records['title']); ?>
                        </h1>
                        <small class="text-muted">
                            <?php  echo "Category: "?>
                            <a class="badge badge-info" href="Blog.php?category=<?php echo htmlentities($records['category']);  ?>"><?php echo htmlentities($records['category']);  ?>
                                
                            </a>
                            & Written by 
                            <a class="badge badge-secondary" href="Profile.php?username=<?php echo htmlentities($records['author']); ?>"><?php echo htmlentities($records['author']); ?>
                                
                            </a>
                            <?php echo " on ".$records['datetime']; ?>
                        </small>
                        <span class="badge badge-dark" style="float: right;">Comments 
                            <?php echo commentsOnPost($records['id'],"on");    ?>
                        </span>
                        <hr>
                        <p class="card-text">
                            <?php if(strlen($records['post']) > 150) 
                            {$records['post'] = substr($records['post'],0,150)."..."; } 
                            echo htmlentities($records['post']);  
                            ?>
                        </p>

                        <span style="float: right;">
                            <a href="FullPost.php?id=<?php echo $records['id']; ?>" class="btn btn-info">Read more >></a>
                        </span>
                    </div>

                </div>
                <?php } ?>

                <nav>
                    <ul class="pagination pagination-md">
                        <?php

                            if (isset($page)) 
                            {
                                if($page > 1) 
                                {
                                  ?>
                                   <li class="page-item">  
                                    <a href="Blog.php?page=<?php echo $page-1; ?>" class="page-link">&laquo;</a>
                                   </li>
                                
                        <?php   }
                            }
                         
                             $sql = "SELECT * FROM posts";
                             $stmt = $conn->query($sql);
                             $TotalPosts = $stmt->rowCount();
                             $PostPagination = ceil($TotalPosts / 4);
                            for ($i=1; $i<=$PostPagination; $i++) 
                            { 
                                if (isset($page)) 
                                {
                                    if ($i == $page) 
                                    {
                                        $active = "active";
                                    }
                                    else
                                    {
                                        $active = "";
                                    }
                                
                        ?>
                                <li class="page-item <?php echo $active; ?>">
                                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                </li>
                        <?php 
                                }
                            }

                            if (isset($page) && !empty($page)) 
                            {
                                if($PostPagination > $page) 
                                {
                                  ?>
                                   <li class="page-item">  
                                    <a href="Blog.php?page=<?php echo $page+1; ?>" class="page-link">&raquo;</a>
                                   </li>
                                
                       <?php    }
                            }
                          ?>
                    </ul>
                </nav>

            </div>
<!-- Side Area Section -->
            <div class="col-md-4">
                <div class="card mt-4">
                    <div class="card-header bg-info text-light">
                        <h3>How to start a Blog!!</h3>
                    </div>
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