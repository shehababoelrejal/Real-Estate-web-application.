<!DOCTYPE <!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"
/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<head>
</head>
<script>
function redirectto()
{
  window.location.replace("HomePage.php");
}

</script>
<?php
$isLogedIn=0;
$username = $imgFile = $passwordErr = $description = $emailErr = $nameErr = $email = $password = $mobileno = $mobilenoErr =  $country = $city = $region = $address = $size = $price ="";
if (isset($_POST["submit"]))
{
  switch($_POST['submit'])
  {
    case 'Create Account':
    $conn = mysqli_connect('localhost','root','','real_estate');
    $usercheck = $_POST['username'];
    $querycheck = "SELECT username FROM user where username = '$usercheck'";
    $result = mysqli_query($conn,$querycheck);
    if (!preg_match('/^[a-zA-Z\d].{7,33}$/',$_POST["username"]))
    {
      $nameErr = "Only letters,numbers and white space allowed also min of 8 characters and max of 32 characters"; 
    }
    else if(mysqli_num_rows($result)>0)
    {
      $nameErr = "Username already taken"; 
    }

    else if (!preg_match("/^[0-9]*$/",$_POST["mobileno"]))
    {
      $mobilenoErr = "Only numbers allowed"; 
    }
    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    {
      $emailErr = "Invalid email format"; 
    }
    else if (!preg_match("/^.{7,}$/" , $_POST["password"]))
    {
      $passwordErr = "minimum 6 character";
    }

    else if ($_POST["password"]!= $_POST["confirmPassword"])
    {
      $passwordErr = "passwords not matching"; 
    }
    else
    {
      $conn = mysqli_connect('localhost','root','','real_estate');
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
      $password_hash = md5($password);
      if(!$conn)
      {
        die("connection failed:".mysqli_connect_error());
      }
      $insertQuery = "Insert into user (name,telephone,dob,username,email,password,userTypeid)
      values ('$name','$telephone','$dob','$username','$email','$password_hash',2)";
      mysqli_query($conn, $insertQuery);
    
    }
    mysqli_close($conn);
    break;

case 'Login': 
  session_start();
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
<ul class="navbar-nav">
<?php


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
    echo "<li><a href = '#Login' id ='login' class = 'login_signup'>Login</a></li>";
    echo "<li class = 'slash' class= 'login_signup'>/</li>";
    echo "<li><a href = '#Signup' id='Signup' class= 'login_signup'>Signup</a></li>";
}
?>
</ul>
</nav>
 <div class="main">
 <h2>Register your acccount</h2>
            <form method="post">
              <h5>Full Name <span class = "validation">*</h5>
              
              <input
                type="text"
                name="fullname"
                required=""
                
              />
              <h5>Username <span class = "validation">* <?php echo $nameErr; ?></span></h5>
              
              <input
                type="text"
                name="username"
                required=""
                
              />
              <h5>Email <span class = "validation">* <?php echo $emailErr; ?></span></h5>
              <input
                type="text"
                name="email"
                required=""
              />
              <h5>Mobile Number <span class = "validation">* <?php echo $mobilenoErr; ?></span></h5>
              <input
                style="margin-top:5px;margin-bottom:15px;"
                type="number"
                name="mobileno"
                required=""
              />
              <h5>Date of Birth <span class = "validation">*</span></h5>
              <p></p>
              <input
               type="date"
               name="bday"
               required=""
               />
               <p></p>
              <h5>Password <span class = "validation">* <?php echo $passwordErr; ?></span></h5>
              <input
                type="password"
                name="password"
                required=""
              />
              <h5>Confirm password <span class = "validation">* <?php echo $passwordErr; ?></span></h5>
              <input
                type="password"
                name="confirmPassword"
                required=""
              />
              <input name="submit"type="submit" value="Create Account" />
            </form>
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
 
 <style>
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

 body
{
    /* overflow-x: hidden; */ 
    background-color: white;
    font-family: Arial, Helvetica, sans-serif;
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
  .main {
    width: 50%;
    margin: 0 auto 0 auto;
    background: #fff;
    padding: 30px 64px;
   padding-top:100px;
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
  .validation
  {
    color:red;
  }
  .first-element-nav
{

  padding-right:1vw;
}  
 </style>
 <script>
 var isLogedIn = <?php echo $isLogedIn ?>;
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
function logedInPrivelages()
{
  document.getElementById("add-property").onclick = ()=>{
  if(isLogedIn == 1)
  {
    location.href = "../Components/SellPage.php";
  }
  else
  {
    alert("Please Login firstly");
  }
}
}
logedInPrivelages();
 </script>