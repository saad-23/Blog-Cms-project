<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

$_SESSION['tracking_url'] = $_SERVER['PHP_SELF'];
confirmLogin();



if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $admin_name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    date_default_timezone_set("Asia/Karachi");
    $currentTime = time();
    $datetime = strftime('%B-%d-%Y , %H:%M:%S',$currentTime);
    $addedby = $_SESSION['username'];

    

    if(empty($username) || empty($password) || empty($confirm_password))
    {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        redirect_to("Admins.php");

    }
    elseif(strlen($password) < 4)
    {
        $_SESSION["ErrorMessage"] = "Pasword should be greater than 3 characters";
        redirect_to("Admins.php");
    }
    elseif($password !== $confirm_password)
    {
        $_SESSION["ErrorMessage"] = "Password and Confirm Password should match";
        redirect_to("Admins.php");
    }
    elseif(checkUsernameExists($username))
    {
        $_SESSION["ErrorMessage"] = "Username already exists, !try another one";
        redirect_to("Admins.php");
    }
    else
    {
        // Insert query for adding category in database table
        $sql = "INSERT INTO admins (username,password,admin_name,addedby,datetime)";
        $sql .= "VALUES (:username,:password,:admin_name,:addedby,:datetime)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':admin_name',$admin_name);
        $stmt->bindParam(':addedby',$addedby);
        $stmt->bindParam(':datetime',$datetime);
        
        $execute = $stmt->execute();
        
        if($execute)
        {
            $_SESSION["SuccessMessage"] = "New Admin with name of {$admin_name} added successfully..";
            redirect_to("Admins.php");
        }
        else
        {
            $_SESSION["ErrorMessage"] = "Something went wrong!Try again";
            redirect_to("Admins.php");
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
    <title>Blog Cms site | Admin Page</title>
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
                        <a href="MyProfile.php" class="nav-link"><i class="fas fa-user"></i> My Profile</a>
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
                    <h1><i class="fas fa-user text-info"></i> Manage Admins</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Ends -->

    <!-- Main section -->

    <section class="container py-2 mb-3" style="min-height: 400px;">
        <div class="row">
            <div class="offset-lg-1 col-lg-10">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();

                    
                ?>
               <form action="Admins.php" method="post">
                    <div class="card bg-secondary text-light">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"  class="form-control">
                                <small class="text-muted">*Optional</small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password"  class="form-control">
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

<!-- Existing Admins Section -->
                 <hr>
               <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sr No.</th>
                            <th>Date Time</th>
                            <th>Username</th>
                            <th>Admin Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM admins ORDER BY id desc";
                            $execute = $conn->query($sql);
                            $sr_no = 0;
                            while($dataRows = $execute->fetch())
                            {
                            $sr_no++;
                        ?>
                        <tr>
                            <td><?php echo $sr_no; ?></td>
                            <td><?php  echo htmlentities($dataRows['datetime']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['username']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['admin_name']);  ?></td>
                            <td><?php  echo htmlentities($dataRows['addedby']);  ?></td>
                            <td><a href="DeleteAdmins.php?id=<?php echo $dataRows['id']; ?>" class="btn btn-danger">Delete</a></td>
                           
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
