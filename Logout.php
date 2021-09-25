<?php
require_once "includes/Functions.php";
require_once "includes/Sessions.php";

session_unset();
session_destroy();
redirect_to("Login.php");



?>