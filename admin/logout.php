<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("location:index.php"); // Redirecting To Home Page
}
?>