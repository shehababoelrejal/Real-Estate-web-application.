<?php
$conn = mysqli_connect('localhost','root','','real_estate');
$query = "SELECT * FROM property WHERE id = '".$_GET["id"]."'";
$result = mysqli_query($conn,$query);
$id = $_GET["id"];
$queryavailable = "UPDATE property SET isAvailable = 0 WHERE id = $id";
mysqli_query($conn, $queryavailable);
mysqli_close($conn);
header("Location: PropertyPage.php?id=$id");
?>