<?php
$conn = mysqli_connect('localhost','root','','real_estate');
$query = "SELECT * FROM property WHERE id = '".$_GET["id"]."'";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $addressid = $row['addressId'];
    }
}
$size = $_POST['Size'];
$price = $_POST['Price'];
$description = $_POST['Description'];
$id = $_GET["id"];
$queryproperty = "UPDATE property SET size = '$size', price = '$price',
                  description = '$description' WHERE id = $id";
mysqli_query($conn, $queryproperty);
$city = $_POST['City'];
$country = $_POST['Country'];
$district = $_POST['District'];
$buildingNumber = $_POST['BuildingNumber'];
$streetName = $_POST['StreetName'];
$floor = $_POST['Floor'];
$apartmentNumber = $_POST['ApartmentNumber'];
$queryaddress = "UPDATE address SET city = '$city', country = '$country',
                  district = '$district', buildingNumber = '$buildingNumber',
                  streetName = '$streetName', floor = '$floor', apartmentNumber = '$apartmentNumber'
                  WHERE id = $addressid";
mysqli_query($conn, $queryaddress);
mysqli_close($conn);
header("Location: PropertyPage.php?id=$id");
?>