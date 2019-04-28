<?php
session_start();
$conn = mysqli_connect('localhost','root','','real_estate');
$username = $_POST['UserName'];
$name = $_POST['FullName'];
$telephone = $_POST['TelePhone'];
$dob = $_POST['DoB'];
$email = $_POST['Email'];
$query = "UPDATE user SET username = '$username', name = '$name',
        telephone = '$telephone', dob = '$dob', email = '$email' 
        WHERE username = '".$_SESSION["username"]."'";
$_SESSION["username"] = $username;
mysqli_query($conn, $query);
mysqli_close($conn);
header("Location: ProfilePage.php");
?>