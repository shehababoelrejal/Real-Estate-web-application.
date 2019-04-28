<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"
  />
  <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<body>
<ul class = "NavigationBar">
<li class="first-element-nav"><a href="HomePage.php"><i class="fa fa-home"></i></a>
<li class="nav-element"><a class="nav-element" href="#Buy" onclick = "location.href = '../Components/BuyPage.php'">Buy</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Add property" id="add-property" onclick = "location.href = '../Components/SellPage.php'" >Sell</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Aboutus" onclick = "location.href = '../Components/about_us.php'">About us</a></li>
<div class="login-signup">


<?php
session_start();
class property
{
  public $price;
  public $size;
  public $address;
  public $img;
  public $id;

  public function __construct($price,$size,$address,$img,$id)
  {
    $this->price = $price;
    $this->size = $size;
    $this->address = $address;
    $this->img = $img;
    $this->id = $id;
  }
}
  $conn = mysqli_connect('localhost','root','','real_estate');
  $selectQuery="select * from property where ownerId = ".$_SESSION['id'];
  $result = mysqli_query($conn,$selectQuery);
  $allProperties = array();
  if(mysqli_num_rows($result)>0)
  {
    while($row = mysqli_fetch_assoc($result))
    {
      array_push($allProperties,new property($row['price'],$row['size'],$row['description'],base64_encode($row['photo']), $row['id']));
    }
  }
  $payload = json_encode($allProperties);
  mysqli_close($conn);
if(!empty($_SESSION))
{
  echo "<div class='dropdown'>";
  echo "<button class='dropbtn' onclick='accountDrop()'>".$_SESSION['username']." ";
  echo "<i class='fa fa-caret-down'></i>";
  echo "</button>";
  echo "<div class='dropdown-content' id='myDropdown'>";
  echo "<a href='ProfilePage.php'>Account</a>";
  echo "<a href='Messages.php' id ='messages'>Messages</a>";
  echo "<form action = 'signout.php'>";
  echo "<li><button class= 'Signout' id='signout'> Signout</button></li>";
  echo "</form>";
  $isLogedIn = 1;
  json_encode($isLogedIn);
  echo "</div>";
  echo "</div>";
}
$conn = mysqli_connect('localhost','root','','real_estate');
$query = "SELECT * FROM user WHERE username =  '".$_SESSION["username"]."'";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $username = $row['username'];
        $name = $row['name'];
        $telephone = $row['telephone'];
        $dob = $row['dob'];
        $image = base64_encode($row['photo']);
        $email = $row['email'];
    }
}
else
{
    echo "0 results";
}

?>



</div>
</ul>
<div class = "container">
<div class = "greenbox">
<label class = "Info">Account Information</label>
</div>
<div>
<label class = "label" >Full Name: </label>
<label class = "labelvariable"><?php echo $name ?></label>
</div>
<div>
<label class = "label">Username: </label>
<label class = "labelvariable"><?php echo $username ?></label>
</div>
<div>
<label class = "label">Telephone: </label>
<label class = "labelvariable"><?php echo $telephone ?></label>
</div>
<div>
<label class = "label">Date of Birth: </label>
<label class = "labelvariable"><?php echo $dob ?></label>
</div>
<div>
<label class = "label">E-mail: </label>
<label class = "labelvariable"><?php echo $email ?></label>
</div>
<div class = "buttons">
<a href = "EditProfilePage.php" class = "Editbtn">Edit Profile</a>
<a href = "DeleteProfile.php" class = "Deletebtn">Delete Profile</a>
</div>
</div>
<div id="properties">
<div class = "greenbox">
<label class = "Info">Added properties</label>
</div>
</div>
</body>
<script>
var properties=<?php echo $payload?>;
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

function render(houseobj){

Object.keys(houseobj).forEach((x)=>{

    var containerAll = document.getElementById("properties");
    var price = document.createTextNode(houseobj[x].price+"$");
    var priceContainer = document.createElement("p");
    var img =document.createElement("img");
    var adContainer = document.createElement("div");
    var address = document.createTextNode(houseobj[x].address);
    var addressContainer = document.createElement("p");
    var button1 =  document.createElement("button");
    button1.innerHTML = "Show more";


    priceContainer.appendChild(price);
    addressContainer.appendChild(address);


    adContainer.appendChild(img);
    adContainer.appendChild(priceContainer);
    adContainer.appendChild(addressContainer);

    containerAll.appendChild(adContainer);
    adContainer.onclick = function()
    {
      window.location.href = "PropertyPage.php?id="+houseobj[x].id;
    }

    img.style.borderTopLeftRadius = "5%";
    img.style.borderTopRightRadius = "5%";
    img.src="data:image/jpeg;base64," + houseobj[x].img;
    img.style.width= "300px";
    img.style.height= "200px";
    priceContainer.style.fontWeight= "bold";
    priceContainer.style.paddingLeft= "10px";
    addressContainer.style.paddingLeft="10px";
    adContainer.style.margin="20px";
    adContainer.style.marginBottom="70px";
    adContainer.style.width="300px";
    adContainer.style.height="300px";
    adContainer.style.backgroundColor="white";
    adContainer.style.border="1px solid lightgrey";
    adContainer.style.borderRadius="5%";

});
}
render(properties);


</script>
<style>
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
.first-element-nav
{
  padding-left:8vw;
  padding-right:1vw;
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
#properties{
  display: flex;
   justify-content: space-around;
   flex-wrap: wrap;
   background:white;
}

</style>
</html>