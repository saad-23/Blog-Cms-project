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
    <title>Dashboard For Admins</title>
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
                    <h1><i class="fas fa-cog text-info"></i>Dashboard</h1>
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
        <?php
                echo ErrorMessage();
                echo SuccessMessage();

        ?>
        <div class="row">
        	
<!-- Left side area starts -->

            <div class="col-lg-2">
            	<div class="card text-center text-white bg-dark mb-3">
            		<div class="card-body">
            			<h1 class="lead">Posts</h1>
            			<h4 class="display-5">
            				<i class="fab fa-readme text-warning"></i>
            			<?php
            				TotalRecords("posts");

            			?>
            			</h4>
            		</div>
            	</div>
            	<div class="card text-center text-white bg-dark mb-3">
            		<div class="card-body">
            			<h1 class="lead">Admins</h1>
            			<h4 class="display-5">
            				<i class="fas fa-users text-info"></i>
            			<?php
            				TotalRecords("admins");

            			?>
            			</h4>
            		</div>
            	</div>
            	<div class="card text-center text-white bg-dark mb-3">
            		<div class="card-body">
            			<h1 class="lead">Categories</h1>
            			<h4 class="display-5">
            				<i class="fas fa-folder text-primary"></i>
            			<?php
            				TotalRecords("category");

            			?>
            			</h4>
            		</div>
            	</div>
            	<div class="card text-center text-white bg-dark mb-3">
            		<div class="card-body">
            			<h1 class="lead">Comments</h1>
            			<h4 class="display-5">
            				<i class="fas fa-comments text-success"></i>
            			<?php
            				TotalRecords("comments");
            			?>
            			</h4>
            		</div>
            	</div>    
            </div>
<!-- Left side area Ends -->

<!-- Right side area Starts -->
			<div class="col-lg-10">
				<h1>Top Posts</h1>
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Title</th>
							<th>Date Time</th>
							<th>Author</th>
							<th>Comments</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
						<?php 
                    
	                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
	                    $stmt = $conn->query($sql);
	                    $sr = 0;
	                    while($posts = $stmt->fetch())
	                    {
	                    	$sr++;
	                     ?>
						<tr>
							<td><?php echo $sr;  ?></td>
							<td><?php  echo htmlentities($posts['title']); ?></td>
							<td><?php  echo htmlentities($posts['datetime']); ?></td>
							<td><?php  echo htmlentities($posts['author']); ?></td>
							<td>
								
                                <?php 
                                    $ApprovePostComments =  commentsOnPost($posts['id'],"on");
                                    if ($ApprovePostComments > 0) 
                                    {
                                       echo "<span class='badge badge-success'>
                                               {$ApprovePostComments}
                                            </span>";
                                    } 

                                     $DisApprovePostComments =  commentsOnPost($posts['id'],"off");
                                    if ($DisApprovePostComments > 0) 
                                    {
                                       echo " <span class='badge badge-danger'>
                                               {$DisApprovePostComments}
                                            </span>";
                                    } 

                                ?>                        
                                		
							</td>
							<td><a class="btn btn-info" href="FullPost.php?id=<?php echo $posts['id']; ?>">Preview</a></td>
						</tr>
						<?php

						}
						?>
					</tbody>
				</table>
			</div>

<!-- Right side area Ends -->

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