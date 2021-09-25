<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

if (isset($_SESSION['user_id'])) 
{
    redirect_to("Posts.php");
}

if (isset($_POST['submit'])) 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) 
    {
        $_SESSION['ErrorMessage'] = "Please fill out all the fields";
        redirect_to("Login.php");
    }
    else
    {
        $found_account = loginAttempt($username,$password);
        if($found_account) 
        {
            $_SESSION['user_id'] = $found_account['id'];
            $_SESSION['username'] = $found_account['username'];
            $_SESSION['admin_name'] = $found_account['admin_name'];

            $_SESSION['SuccessMessage'] = "Welcome {$_SESSION['username']} to Dashboard";

            if (isset($_SESSION['tracking_url'])) 
            {
                redirect_to($_SESSION['tracking_url']);
            }
            else
            {
                redirect_to("Dashboard.php");
            }
                        
        }
        else
        {
            $_SESSION['ErrorMessage'] = "Invalid username/Password";
            redirect_to("Login.php");
                        
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Blog Cms site | Login Page</title>
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
                    
                </div>
            </div>
        </div>
    </header>
    <!-- Header Ends -->
    <!-- Main Section starts -->
    <section class="container py-3 mb-4">
        <div class="row">
            <div class="offset-md-3 col-md-6" style="min-height: 400px;">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();

                ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Welcome Back !</h4>
                    </div>
                    <div class="card-body bg-dark">
                        <form action="Login.php" method="POST">
                            <div class="form-group">
                                <label for="username" class="FieldInfo">Username:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control">
                                </div>     
                            </div>
                            <div class="form-group">
                                <label for="password" class="FieldInfo">Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control">
                                </div>     
                            </div>
                            <div>
                                <input type="submit" name="submit" value="Login" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Section Ends -->
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