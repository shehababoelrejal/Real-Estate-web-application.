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
<li  ><a class="nav-element" href="#Add property" id="add-property"  >Sell</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Aboutus" onclick = "location.href = '../Components/about_us.php'">About us</a></li>
<div class="login-signup">

<script>
function redirectto()
{
  window.location.replace("HomePage.php");
}
</script>

<?php
session_start();
$isLogedIn=0;
$username = $imgFile = $passwordErr = $description = $emailErr = $nameErr = $email = $password = $mobileno = $country = $city = $region = $address = $size = $price ="";
$isAdmin = 0;
if(isset($_GET['case']))
{
  $case = $_GET['case'];
  if($case==1)
  {
    echo "<script> alert('You have already requested this property!'); </script>";
  }
}
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
      $ownerId = $row['ownerId'];
      $id = $_GET["id"];
      $isAvailable = $row['isAvailable'];
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

if (isset($_POST["submit"]))
{
  switch($_POST['submit'])
  {
    case 'Create Account':
    $conn = mysqli_connect('localhost','root','','real_estate');
    if (!preg_match("/^[a-zA-Z\d ]*$/",$_POST["username"]))
    {
      $nameErr = "Only letters,numbers and white space allowed"; 
    }
    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    {
      $emailErr = "Invalid email format"; 
    }
    else if ($_POST["password"]!= $_POST["confirmPassword"])
    {
      $passwordErr = "passwords not matching"; 
    }
    else
    {
      $name = $_POST["fullname"];
      $name = mysqli_real_escape_string($conn,$name);
      $username = $_POST["username"];
      $username = mysqli_real_escape_string($conn,$username);
      $telephone = $_POST['mobileno'];
      $telephone = mysqli_real_escape_string($conn,$telephone);
      $dob = $_POST['bday'];
      $dob = mysqli_real_escape_string($conn,$dob);
      $email = $_POST["email"];
      $email = mysqli_real_escape_string($conn,$email);
      $password = $_POST["password"];
      $password = mysqli_real_escape_string($conn,$password);
      if(!$conn)
      {
        die("connection failed:".mysqli_connect_error());
      }
      $insertQuery = "Insert into user (name,telephone,dob,username,email,password,userTypeid)
      values ('$name','$telephone','$dob','$username','$email','$password',2)";
      mysqli_query($conn, $insertQuery);
    
    }
    mysqli_close($conn);
    break;

case 'Login': 
  
  $connlogin = mysqli_connect('localhost','root','','real_estate');
  $usernamelogin = $_POST['usernameloginf'];
  $passwordlogin = $_POST['passwordloginf'];
  $password_login_hash = md5($passwordlogin);

  $querylogin="SELECT * FROM user WHERE username='$usernamelogin' AND password='$password_login_hash'";
  $resultlogin = mysqli_query($connlogin,$querylogin);
  $count=mysqli_num_rows($resultlogin);
  if($count==1)
  {
    $rowlogin = mysqli_fetch_assoc($resultlogin);
    if ($rowlogin['username'] == $usernamelogin && $rowlogin['password'] == $password_login_hash)
    { 
      $_SESSION['username']= $usernamelogin;
      $_SESSION['id'] = $rowlogin['id'];
      $usernamehtml = $_SESSION['username'];
      header("Location:Homepage.php");
      return true;
    }
    else
    {
      echo "<script>";
      echo "redirectto();";
      echo "alert('Invalid Username or Password');";
      echo "</script>";
      return false;
    }
  }
  else
  {
    echo "<script>";
    echo "redirectto();";
    echo "alert('Invalid Username or Password');";
    echo "</script>";
    return false;
  }
  mysqli_close($connlogin);
  break;
 }
}
?>
</div>
</ul>

<div id = "container2">
        <div id="myModal" class="modal">
        <!-- Modal content -->
          <div class="modal-content">
            <div class="content">
          <div class="main">
            <span class="close">&times;</span>

            <h2>Register your acccount</h2>
            <form method="post">
              <h5>Full Name <span>* <?php echo $nameErr; ?></span></h5>
              
              <input
                type="text"
                name="fullname"
                required=""
                
              />
              <h5>Username <span>* <?php echo $nameErr; ?></span></h5>
              
              <input
                type="text"
                name="username"
                required=""
                
              />
              <h5>Email <span>* <?php echo $emailErr; ?></span></h5>
              <input
                type="text"
                name="email"
                required=""
              />
              <h5>Mobile Number <span>* <?php echo $emailErr; ?></span></h5>
              <input
                type="text"
                name="mobileno"
                required=""
              />
              <h5>Date of Birth <span>* <?php echo $emailErr; ?></span></h5>
              <p></p>
              <input
               type="date"
               name="bday"
               />
               <p></p>
              <h5>Password <span>* <?php echo $passwordErr; ?></span></h5>
              <input
                type="password"
                name="password"
                required=""
              />
              <h5>Confirm password <span>* <?php echo $passwordErr; ?></span></h5>
              <input
                type="password"
                name="confirmPassword"
                required=""
              />
              <input name="submit"type="submit" value="Create Account" />
            </form>
          </div>
        </div>
       </div>
    </div>
 </div>
 <div id="myModallogin" class="modallogin">
        <!-- Modal content -->
          <div class="modal-contentlogin"> 
          <div class="contentlogin">
          <div class="mainlogin">
          <span class="closelogin">&times;</span>
            <h2>Login with your acccount</h2>
            <form method="post">
              <h5>Username <span>*</span></h5>
              <input
                type="text"
                name="usernameloginf"
                required=""
              />
              <h5>Password <span>*</span></h5>
              <input
                type="password"
                name="passwordloginf"
                required=""
              />
              <input name="submit"type="submit" value="Login" />
            </form>
          </div>
        </div>
       </div>
    </div>
</div>







<div class = "container">
<div class = "greenbox">
<label class = "Info">Property Information</label>
</div>
<div>
<img class ="image" src = 'data: image/jpg; base64, <?php echo $image ?>'>
</div>
<div>
<label class = "label" >Country: </label>
<label class = "labelvariable"><?php echo $country ?></label>
</div>
<div>
<label class = "label">City: </label>
<label class = "labelvariable"><?php echo $city ?></label>
</div>
<div>
<label class = "label">Size: </label>
<label class = "labelvariable"><?php echo $size ?></label>
</div>
<div>
<label class = "label">Price: </label>
<label class = "labelvariable"><?php echo $price ?></label>
</div>
<div>
<label class = "label">District: </label>
<label class = "labelvariable"><?php echo $district ?></label>
</div>
<div>
<label class = "label">Building Number: </label>
<label class = "labelvariable"><?php echo $buildingNumber ?></label>
</div>
<div>
<label class = "label">Street Name: </label>
<label class = "labelvariable"><?php echo $streetName ?></label>
</div>
<div>
<label class = "label">Floor: </label>
<label class = "labelvariable"><?php echo $floor ?></label>
</div>
<div>
<label class = "label">Apartment Number: </label>
<label class = "labelvariable"><?php echo $apartmentNumber ?></label>
</div>
<div>
<label class = "label">Description: </label>
<label class = "labelvariable"><?php echo $description ?></label>
</div>
<?php
if($isAvailable == 0)
{
  echo "<div>";
  echo "<label class = 'label' style = 'color:red;font-weight:bold;'>SOLD</label>";
  echo "</div>";
}
?>
<?php
if(!empty($_SESSION))
{
  if($ownerId == $_SESSION['id'])
  {
    echo "<div class = 'buttons'>";
    echo "<a href = 'EditPropertyPage.php?id=". $id."' class = 'Editbtn'>Edit Property</a>";
    echo "<a href = 'DeleteProperty.php?id=". $id."' class = 'Deletebtn'>Delete Property</a>";
    echo "<a href = 'MarkSoldPage.php?id=". $id."' class = 'Deletebtn'>Mark as Sold</a>";
    echo "</div>";
  }
  else
  {

  }
}
?>
<div class="req-info">
<?php
if(!empty($_SESSION))
{
echo "<a style ='margin-right:5px;'class = 'Editbtn' href='ShowProfile.php?id=". $ownerId."'>Owner Information</a>";


if($isAvailable != 0 && $ownerId != $_SESSION['id'])
{
  echo "<a href = 'RequestProperty.php?id=".$id."' class = 'req-btn' id = 'req'>Request to buy</a>";
}
}
?>
</div>

</div>
</body>
<script>
var isLogedIn = <?php echo $isLogedIn ?>;
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
function PropertyKeys(){

}
function logedInPrivelages(){
document.getElementById("add-property").onclick = ()=>{
 
if(isLogedIn == 1){
  location.href = "../Components/SellPage.php";
}
else{
  alert("Please Login firstly");
}
}}
logedInPrivelages();
if(isLogedIn == 1){
function logedInPrivelages1()
{
    document.getElementById("req").onclick = ()=>
    { 
        if(isLogedIn == 1)
        {
            location.href = "MessagingPage.php?id=<?php echo $username;?>";
        }
        else
        {
            alert("Please Login firstly");
        }
    }
}
logedInPrivelages1();
} 





var modal = document.getElementById('myModal');
  var span = document.getElementsByClassName("close")[0];
  if(isLogedIn ==0){
  var btn = document.getElementById("Signup");
  btn.onclick = function() {
      modal.style.display = "block";
  }}
  span.onclick = function() {
      modal.style.display = "none";
  }
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
  
  if(isLogedIn == 0)
  {
    var modallog = document.getElementById('myModallogin');
    var btnlog = document.getElementById("login");
    var spanlog = document.getElementsByClassName("closelogin")[0];
    btnlog.onclick = function() {
        modallog.style.display = "block";
    }
    spanlog.onclick = function() {
        modallog.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modallog) {
            modallog.style.display = "none";
        }
      }
  }

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
  
  background-color:#4CAF50;
  padding:5px 8px;
  color:white;
  border:0;
  margin-left:30vw;
}
.req-btn
{
  
  background-color:#4CAF50;
  padding:5px 8px;
  color:white;
  border:0;
  
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
    width:300px;
    height:200px;
    //border-radius:50%;
}

.container
{
    width:100%;
    height:100%;
   
   padding-bottom:50px;
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
.modallogin {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 10px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-contentlogin {
   
    margin: auto;
    width: 50%;
}
.closelogin {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.closelogin:hover,
.closelogin:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
  .contentlogin{
    padding: 60px 0;
  }

  .mainlogin {
    width: 50%;
    margin: 0 auto 0 auto;
    background: #fff;
    padding: 30px 64px;
   
  }

  .mainlogin h2 {
    color: #4caf50;
    font-size: 26px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 500;
  }

  .mainlogin form input[type="text"],
  .mainlogin form input[type="password"] {
    width: 94%;
    padding: 10px;
    font-size: 14px;
    border: none;
    border-bottom: 2px solid #e6e6e6;
    outline: none;
    color: #d8d5d5;
    margin-bottom: 20px;
  }
  .mainlogin h5 {
    font-family: "Lato", sans-serif !important;
    color: #4caf50;
    margin-bottom: 8px;
    font-size: 15px;
  }
  .mainlogin form input[type="text"]:hover,
  .mainlogin form input[type="password"]:hover {
    border-bottom: 2px solid #b384fb;
    color: #000;
    transition: 0.5s all;
  }
  .mainlogin form input[type="text"]:focus,
  .mainlogin form input[type="password"]:focus {
    border-bottom: 2px solid #b384fb;
    color: #000;
    transition: 0.5s all;
  }

  .mainlogin form input[type="submit"] {
    background: #4caf50;
    color: #ffffff;
    text-align: center;
    padding: 14px 0;
    border: none;
    border-bottom: 5px solid rgb(61, 151, 64);
    font-size: 17px;
    outline: none;
    width: 100%;
    cursor: pointer;
    margin-bottom: 0px;
  }
  .mainlogin form input[type="submit"]:hover {
    background: rgb(206, 206, 206);
    color: #000;
    border-bottom: 5px solid rgb(168, 168, 168);
    transition: 0.5s all;
  }
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 10px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-content {
   
    margin: auto;
    width: 50%;
}
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
h1{
  color:#4caf50;
}


  h2,
  h3,
  h4,
  h5,
  h6 {
    font-family: "Amaranth", sans-serif;
    margin: 0;
  }

  ul {
    margin: 0;
    padding: 0;
  }
  label {
    margin: 0;
  }
  /*-- main --*/
  .content {
    padding: 60px 0;
  }

  .main {
    width: 50%;
    margin: 0 auto 0 auto;
    background: #fff;
    padding: 30px 64px;
   
  }

  .main h2 {
    color: #4caf50;
    font-size: 26px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 500;
  }

  .main form input[type="text"],
  .main form input[type="password"] {
    width: 94%;
    padding: 10px;
    font-size: 14px;
    border: none;
    border-bottom: 2px solid #e6e6e6;
    outline: none;
    color: #d8d5d5;
    margin-bottom: 20px;
  }
  .main h5 {
    font-family: "Lato", sans-serif !important;
    color: #4caf50;
    margin-bottom: 8px;
    font-size: 15px;
  }
  .main form input[type="text"]:hover,
  .main form input[type="password"]:hover {
    border-bottom: 2px solid #b384fb;
    color: #000;
    transition: 0.5s all;
  }
  .main form input[type="text"]:focus,
  .main form input[type="password"]:focus {
    border-bottom: 2px solid #b384fb;
    color: #000;
    transition: 0.5s all;
  }

  .main form input[type="submit"] {
    background: #4caf50;
    color: #ffffff;
    text-align: center;
    padding: 14px 0;
    border: none;
    border-bottom: 5px solid rgb(61, 151, 64);
    font-size: 17px;
    outline: none;
    width: 100%;
    cursor: pointer;
    margin-bottom: 0px;
  }
  .main form input[type="submit"]:hover {
    background: rgb(206, 206, 206);
    color: #000;
    border-bottom: 5px solid rgb(168, 168, 168);
    transition: 0.5s all;
  }

</style>
</html>