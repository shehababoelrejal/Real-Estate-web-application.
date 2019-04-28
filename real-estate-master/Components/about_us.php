<!DOCTYPE <!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"
/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
</head>
<body>

<nav class="navBar navbar navbar-expand-lg nav_bar">
<ul class="navbar-nav mr-auto" style = "padding-left: 100px;">
<li class="first-element-nav"><a href="HomePage.php"><i class="fa fa-home"></i></a>
<li><a href="#Buy" onclick = "location.href = '../Components/BuyPage.php'">Buy</a></li>
<div class="line-between"></div>
<li><a href="#Add property" id="add-property" >Sell</a></li>
<div class="line-between"></div>
<li ><a href="#Aboutus" onclick = "location.href = '../Components/about_us.php'">About us</a></li>
</ul>

<script>
function redirectto()
{
  window.location.replace("HomePage.php");
}
</script>

<ul class="navbar-nav">
<?php
session_start();
$isLogedIn=0;
$username = $imgFile = $passwordErr = $description = $emailErr = $nameErr = $email = $password = $mobileno = $country = $city = $region = $address = $size = $price ="";
$isAdmin = 0;
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
    echo "<li><a href = '#Login' id='login' class = 'login_signup'>Login</a></li>";
    echo "<li class = 'slash' class = 'login_signup'>/</li>";
    echo "<li><a href = 'SignupPage.php' id='Signup' class = 'login_signup'>Signup</a></li>";
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
  $querylogin="SELECT * FROM user WHERE username='$usernamelogin' AND password='$passwordlogin'";
  $resultlogin = mysqli_query($connlogin,$querylogin);
  $count=mysqli_num_rows($resultlogin);
  if($count==1)
  {
    $rowlogin = mysqli_fetch_assoc($resultlogin);
    if ($rowlogin['username'] == $usernamelogin && $rowlogin['password'] == $passwordlogin)
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
</ul>
</nav>



<div class = "about">

    <img src = "../assets/10.jpg" alt = "pond-villa" id = "about_img">
    <div class = "word_img"> ABOUT US </div> 
    
</div>   

<br>
<br>
<br>
<br>

<div class = "kalam_about">
<h3 class = "mission"> The Mission </h3>
<p class = "mission1"> We focus on relevant innovation from idea to delivery. 
    Our business is based on integration and attention to details that brings value.
    Every business decision will support the development and business.
    Work sincerely to build, develop and maintain the best real estate professional network and to employ multinational work standards
    to deliver excellence to our clients, shareholders, business partners, employees and society. </p>
    <br>
    <h3 class = "vision"> The Vision</h3>
    <p class = "vision1"> Leading the way, delivering genuine value, and innovative integrated real estate solutions.
        To build and maintain the largest real estate business network in Egypt, the Middle East, 
        and worldwide guided with our professional work standards and code of ethics. We  believes in creating FEEL GOOD NEIGHBORHOODS.
        Neighborhoods in which the surrounding community works together to be the best they can be.
    </p>
<br>
<h3 class= "values"> OUR CORE VALUES: </h3>
<ol class = values1>
    <li> Diligence: Our eagerness to learn is our path to perfection.</li>   
    <li> Decency: Our transparency and ethics are the route to lasting relationships with our partners.</li>
    <li> Distinction: Our commitment to excellence in everything we do.</li>
    <li> Development: Our growth is a result of our belief in efficiency and continuous improvement.</li>
    <li> Diversity: Our versatility and exposure are what make us different.</li>
</ol>
</div>
 <div id="myModallogin" class="modallogin">
        <!-- Modal content -->
          <div class="modal-contentlogin"> 
          <div class="contentlogin">
          <div class="mainlogin">
          <span class="closelogin">&times;</span>
            <h2>Login with your acccount</h2>
            <form method="post">
              <h5>Username <span>* <?php echo $nameErr; ?></span></h5>
              <input
                type="text"
                name="usernameloginf"
                required=""
              />
              <h5>Password <span>* <?php echo $passwordErr; ?></span></h5>
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

</body>

<script>
var isLogedIn = <?php echo $isLogedIn?>;
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
body
{
    /* overflow-x: hidden; */ 
    background-color: rgb(226, 226, 226);
    font-family: Arial, Helvetica, sans-serif;
}
.first-element-nav
{
  padding-right:1vw;
}  
.nav_bar
{
    background-color: black;
}
.line-between
{
    border-right:1px solid white;
    margin-left:10px;
    margin-right:10px;
}

.login_signup
{
    color: #4caf50;
    text-decoration: none;
    font-weight: bold;
}

a
{
  color: white;
}
a:hover
{
    color: #4caf50;
    text-decoration: none;
}

.slash
{
    margin-left: 10px; 
    margin-right: 10px;
    color: #4caf50;
}
.navBar{
    width:100%;
    position: fixed;
}
.about
{

width:100%;
height:410px ;
text-align: center;
margin: auto;
}
#about_img
{
    width: 100%;
    height: 100%;
}
.word_img
{
    color:white;
    font-family: Arial;
    font-size: 30px;
    padding: 10px 10px;
    background-color:rgba(0, 0, 0, 0.6); 
    
}
 
.mission , 
.mission1
{
    padding-left: 30px; 

    
}

.vision , 
.vision1
{
    padding-left: 30px; 

}
.values 
{
    padding-left: 30px; 

}
.values1
{
   padding-left: 50px;
   padding-top: 10px; 
}
h1,h2,h3,h4,h5,h6
{
    font-family: "Amaranth", sans-serif;
    margin: 0;
}
.dropbtn{
  background-color:black;
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
  position: fixed;
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
  #container2
{
    background-color: rgb(226, 226, 226);
    display: flex;
    padding-top: 30px;
    justify-content: space-around;
    flex-wrap: wrap;
    overflow: auto;
}

 </style>   
 </html>