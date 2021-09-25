<?php
require_once "Database.php";


function redirect_to($location_name)
{
    header("location:".$location_name);
    exit();
}

function checkUsernameExists($username)
{
    global $conn;
    
    $sql = "SELECT username FROM admins WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":username",$username);
    $stmt->execute();
    $result = $stmt->rowcount();
    if($result == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function loginAttempt($username,$password)
{
    global $conn;
    
    $sql = "SELECT * FROM admins WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":username",$username);
    $stmt->bindValue(":password",$password);
    $stmt->execute();
    $result = $stmt->rowCount();
    if($result == 1)
    {
       return $found_account = $stmt->fetch();
       
    }
    else
    {
        return null;
    }
}

function confirmLogin()
{
    if (isset($_SESSION['user_id'])) 
    {
        return true;
    }
    else
    {
        $_SESSION['ErrorMessage'] = "Login required !";
        redirect_to("Login.php");
    }
}


function TotalRecords($tableName)
{
    global $conn;
    // $sql = "SELECT COUNT(*) FROM {$tableName}"; // Alternate Method
    $sql = "SELECT * FROM {$tableName}";
    $stmt = $conn->query($sql);
    $TotalRecords = $stmt->rowCount();
    // $totalRecords = array_shift($totalRows);  // Alternate Method
    echo $TotalRecords;
    
}

function commentsOnPost($post_id,$status)
{
    global $conn;
    $sql = "SELECT * FROM comments WHERE post_id = '{$post_id}' AND 
    status = '{$status}' ";
    $stmt = $conn->query($sql);
    $totalComments = $stmt->rowCount();
    // $totalComments = array_shift($totalRows);
    return $totalComments;

}

?>