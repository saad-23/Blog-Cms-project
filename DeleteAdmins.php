<?php
require_once "includes/Database.php";
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

if (isset($_GET['id'])) 
{
	$SearchQueryParameter = $_GET['id'];
	$sql = "DELETE FROM admins WHERE id = '{$SearchQueryParameter}' ";
	$execute = $conn->query($sql);
	if ($execute) 
	{
		$_SESSION['SuccessMessage'] = "Admin deleted successfully";
		redirect_to("Admins.php");
	}
	else
	{
		$_SESSION['ErrorMessage'] = "Something went wrong! Try again";
		redirect_to("Admins.php");
	}
}

?>