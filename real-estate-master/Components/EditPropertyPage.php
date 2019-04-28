<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"
  />
  <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<body>
<ul class = "NavigationBar">
<li class="first-element-nav"><a class="nav-element" href="#Buy" onclick = "location.href = '../Components/BuyPage.php'">Buy</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Add property" id="add-property" onclick = "location.href = '../Components/SellPage.php'" >Sell</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Aboutus" onclick = "location.href = '../Components/about_us.php'">About us</a></li>
<div class="login-signup">


<?php
session_start();
if(!empty($_SESSION))
{
  echo "<div class='dropdown'>";
  echo "<button class='dropbtn' onclick='accountDrop()'>".$_SESSION['username']." ";
  echo "<i class='fa fa-caret-down'></i>";
  echo "</button>";
  echo "<div class='dropdown-content' id='myDropdown'>";
  echo "<a href='ProfilePage.php'>Account</a>";
  echo "<a href='#' id ='messages'>Messages</a>";
  echo "<form action = 'signout.php'>";
  echo "<li><button class= 'Signout' id='signout'> Signout</button></li>";
  echo "</form>";
  $isLogedIn = 1;
  json_encode($isLogedIn);
  echo "</div>";
  echo "</div>";
}
else
{
  echo "<li><a href = '#Login' id='login'>Login /</a></li>";
  echo "<li><a href = '#Signup' id='Signup'> Signup</a></li>";
}
$conn = mysqli_connect('localhost','root','','real_estate');
$query = "SELECT * FROM property WHERE id = '".$_GET["id"]."'";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
      $size = $row['size'];
      $price = $row['price'];
      $description = $row['description'];
      $image = base64_encode($row['photo']);
      $addressid = $row['addressId'];
      $id = $_GET["id"];
    }
}
$queryaddress = "SELECT * FROM address WHERE id = $addressid";
$resultaddress = mysqli_query($conn,$queryaddress);
if(mysqli_num_rows($resultaddress)>0)
{
  while($rowaddress = mysqli_fetch_assoc($resultaddress))
  {
    $city = $rowaddress['city'];
    $country = $rowaddress['country'];
    $district = $rowaddress['district'];
    $buildingNumber = $rowaddress['buildingNumber'];
    $streetName = $rowaddress['streetName'];
    $floor = $rowaddress['floor'];
    $apartmentNumber = $rowaddress['apartmentNumber'];
  }
}
else
{
    echo "0 results";
}

?>



</div>
</ul>
<form  method = "POST" action = "EditProperty.php?id=<?php echo $id ?>">
<div class = "container">
<div class = "greenbox">
<label class = "Info">Property Information</label>
</div>
<div>
<img class ="image" src = 'data: image/jpg; base64, <?php echo $image ?>'>
</div>
<div>
<label class = "label" >Country: </label>
<input type = "text" name = "Country" value = "<?php echo $country ?>">
</div>
<div>
<label class = "label">City: </label>
<input type = "text" name = "City" value = "<?php echo $city ?>">
</div>
<div>
<label class = "label">Size: </label>
<input type = "text" name = "Size" value = "<?php echo $size ?>">
</div>
<div>
<label class = "label">Price: </label>
<input type = "text" name = "Price" value = "<?php echo $price ?>">
</div>
<div>
<label class = "label">District: </label>
<input type = "text" name = "District" value = "<?php echo $district ?>">
</div>
<div>
<label class = "label">Building Number: </label>
<input type = "text" name = "BuildingNumber" value = "<?php echo $buildingNumber ?>">
</div>
<div>
<label class = "label">Street Name: </label>
<input type = "text" name = "StreetName" value = "<?php echo $streetName ?>">
</div>
<div>
<label class = "label">Floor: </label>
<input type = "text" name = "Floor" value = "<?php echo $floor ?>">
</div>
<div>
<label class = "label">Apartment Number: </label>
<input type = "text" name = "ApartmentNumber" value = "<?php echo $apartmentNumber ?>">
</div>
<div>
<label class = "label">Description: </label>
<input type = "text" name = "Description" value = "<?php echo $description ?>">
</div>
<input type = "submit" name = "Save" class = "Savebtn" value = "Save">
</div>
</form>
</body>
<script>
function accountDrop()
{
  document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function(e)
{
  if (!e.target.matches('.dropbtn')) 
  {
    var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show'))
    {
      myDropdown.classList.remove('show');
    }
  }
}
</script>
<style>
.Savebtn
{
 
  background-color:#4CAF50;
  
  color:white;
  border:0;
  width:5vw;
  height:2vw;
  cursor:pointer;
}
.Deletebtn
{
  background-color:#4CAF50;
  padding:5px 8px;
  color:white;
  border:0;
  margin-left:1vw;
 
  position:relative;
}
.Editbtn
{
  margin-right: auto !important;
  background-color:#4CAF50;
  padding:5px 8px;
  color:white;
  border:0;
  margin-left:30vw;
}
.buttons{
  padding-bottom:20px;
}
.greenbox
{
    background-color:#4caf50;
    width:100vw;
    height:8vh;
   
    border: 1px solid grey;
   
}
.Info
{
    display:block;
    text-align:center;
    font-size:22px;
    font-size:22px;
    color:white;
    margin-top:10px;
    
}
.image
{   
    width:100px;
    height:100px;
    border-radius:50%;
   
   
   
}
.container
{
    width:100%;
    height:100%;
   
   
    background:white;
    border: 1px solid #4caf50;
    
    display: flex;
    flex-direction:column;
    align-items: center;
    justify-content: space-between;
}
.label
{
   
    margin-left:3vw;
    padding-top:10px;
    font-size:22px;
    color:#4caf50;
   
}
.labelvariable
{
    font-size:22px;
    margin-left:1vw;
   
}
.line-between{
border-right:1px solid white;
margin-left:10px;
margin-right:10px;
}
.nav-element{
    color :white;
}
.first-element-nav{
    padding-left:8vw;
}     
.login-signup{
    position: absolute;
    right:6vw;
  
    display: flex;
}
body
{
  margin: 0;
  padding: 0;
  overflow-x: hidden;
  background-color: rgb(226, 226, 226);
}
.NavigationBar
{
background-color: #101010;
border: #707070 1px;
display: flex;
font-size: 18px;
font-family: Arial;
text-align:left;
padding: 10px;
padding-right: 0px;
padding-left: 0px;
list-style-type: none;
width: 100%;
margin-block-end: 0px;

}
a
{
color: white;
text-decoration: none;
}

#login
{
color: #4caf50;
font-weight: bold;

}
#userNametwo
{
  background:transparent;
  border:none;
  padding:100px;
  color:darkgreen;
}
.Signout
{
  background:transparent;
  padding: 12px 16px;
  text-decoration: none;
  text-align: left;
  border:none;
  font-size: 16px;
  cursor:pointer;
}
#signup
{
color: #4caf50;
font-weight: bold;    
}

a:hover
{
    color: #4caf50;
}
h1,h2,h3,h4,h5,h6
{
    font-family: "Amaranth", sans-serif;
    margin: 0;
}
.dropbtn{
  background-color:#101010;
  border:none;
  color: #4caf50;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
}
.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown {
  cursor: pointer;
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 120px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.show {
  display: block;
}
.Signout
{
  background:transparent;
  padding: 12px 16px;
  text-decoration: none;
  text-align: left;
  border:none;
  font-size: 16px;
  cursor:pointer;
}

</style>
</html>