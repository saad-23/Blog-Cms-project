<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

$_SESSION['tracking_url'] = $_SERVER['PHP_SELF'];
confirmLogin();


$adminId = $_SESSION['user_id'];

$fetch_sql = "SELECT * FROM admins WHERE id = '{$adminId}' ";
$fetch_stmt = $conn->query($fetch_sql);
$admin_data = $fetch_stmt->fetch();



if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $headline = $_POST['headline'];
    $bio = $_POST['bio'];
    $image = $_FILES['image']['name'];
    $target = "images/".basename($_FILES['image']['name']);
    
    if (empty($headline)) 
    {
        $_SESSION["ErrorMessage"] = "Headline should not be empty";
        redirect_to("MyProfile.php");
    }
    elseif(strlen($headline) > 12)
    {
        $_SESSION["ErrorMessage"] = "Headline should be less than 12 characters";
        redirect_to("MyProfile.php");
    }
    elseif(strlen($bio) > 500)
    {
        $_SESSION["ErrorMessage"] = "Bio  should be less than 500 characters";
        redirect_to("MyProfile.php");
    }
    else
    {
        // Update query for Updating admin data in database table

       
        if(!empty($image))
        {
             $sql = "UPDATE admins SET 
             admin_name = '{$name}',
             headline = '{$headline}', 
             bio = '{$bio}', 
             image = '{$image}' 
             WHERE id = {$adminId}";
        }
        else
        {
             $sql = "UPDATE admins SET 
             admin_name = '{$name}',
             headline = '{$headline}', 
             bio = '{$bio}' 
             WHERE id = {$adminId}";
        }

        $execute = $conn->query($sql);
        move_uploaded_file($_FILES['image']['tmp_name'],$target);
        
        if($execute)
        {
            $_SESSION["SuccessMessage"] = "Details updated successfully..";
            redirect_to("MyProfile.php");
        }
        else
        {
            $_SESSION["ErrorMessage"] = "Something went wrong!Try again";
            redirect_to("MyProfile.php");
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Blog Cms site | My Profile</title>
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
    <header class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user text-info"></i> @<?php echo $admin_data['username']; ?></h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Ends -->

    <!-- Main section -->

    <section class="container py-2 mb-3" style="min-height: 400px;">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header text-light bg-dark">
                        <h3><?php echo $admin_data['admin_name']; ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="images/<?php echo $admin_data['image']; ?>" class="img-fluid d-block">
                        <p class="mt-2"><?php echo $admin_data['bio']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();

                    
                ?>
               <form action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light">
                        <div class="card-header bg-secondary text-light">
                            <h3>Edit Profile</h3>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Enter Admin Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="headline">Headline</label>
                                <input type="text" name="headline" id="headline" placeholder="Headline" class="form-control">
                                <small class="text-muted">Add a Professional headline like Engineer at 'ABC' </small>
                                <span class="text-danger">Not more than 12 characters</span>
                            </div>
                            <div class="form-group">
                                <label for="desc">Bio</label>
                                <textarea class="form-control" name="bio" placeholder="Bio" rows="8" cols="80"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                   <input type="file" name="image" id="image"  class="form-control">
                                   <label for="image" class="custom-file-label">Choose Image</label>
                                </div>  
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"> Back to Dashboard</i></a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block"> <i class="fas fa-check"></i> Publish</button>
                                </div>
                            </div>
                        </div>
                    </div>
               </form>
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




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
</body>

</html>
