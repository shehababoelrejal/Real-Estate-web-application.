<?php
session_start();
$conn = mysqli_connect('localhost','root','','real_estate');
$query = "Delete From user WHERE username = '".$_SESSION["username"]."'";
mysqli_query($conn, $query);
mysqli_close($conn);
session_unset();
header("Location: HomePage.php");
?>