<?php
session_start();
$conn = mysqli_connect('localhost','root','','real_estate');
$query = "Delete From property Where id = '".$_GET["id"]."'";
mysqli_query($conn, $query);
mysqli_close($conn);
header("Location: HomePage.php");
?>