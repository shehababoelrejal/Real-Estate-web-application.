<!DOCTYPE <!DOCTYPE html>
<html>
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
session_start();
$isLogedIn=0;
$username = $imgFile = $passwordErr = $description = $emailErr = $nameErr = $email = $password = $mobileno = $country = $city = $region = $address = $size = $price ="";
$isAdmin = 0;
class property
{
  public $price;
  public $size;
  public $description;
  public $img;
  public $id;
  public $sold;

  public function __construct($price,$size,$description,$img,$id,$sold)
  {
    $this->price = $price;
    $this->size = $size;
    $this->description = $description;
    $this->img = $img;
    $this->id = $id;
    $this->sold = $sold;
  }
}
  $conn = mysqli_connect('localhost','root','','real_estate');
  if(!$conn)
  {
    die("connection failed:".mysqli_connect_error());
  }
  $selectQuery="select * from property";
  $result = mysqli_query($conn,$selectQuery);
  $allProperties = array();
  if(mysqli_num_rows($result)>0)
  {
    while($row = mysqli_fetch_assoc($result))
    {
      array_push($allProperties,new property($row['price'],$row['size'],$row['description'],base64_encode($row['photo']), $row['id'],$row['isAvailable']));
    }
  }
    else
    {
      echo "0 results";
    }
$payload = json_encode($allProperties);
if(!empty($_SESSION)){
  $sessionUsername = $_SESSION['username'];
  $isAdminQuery="select * from user where username = '$sessionUsername' ";
  $resultIsAdmin = mysqli_query($conn,$isAdminQuery);
  if(mysqli_num_rows($resultIsAdmin) == 1){
    $rowAdmin = mysqli_fetch_assoc($resultIsAdmin);
    if($rowAdmin['userTypeId'] == 1){
      $isAdmin = 1;
    }
  }
}

if (isset($_POST["submit"])) {
 
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

 }

?>
<body>
<ul class = "NavigationBar">
<li class="first-element-nav"><a href="HomePage.php"><i class="fa fa-home"></i></a>
<li class="nav-element"><a class="nav-element" href="#Buy" onclick = "location.href = '../Components/BuyPage.php'">Buy</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Add property" id="add-property"  >Sell</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Aboutus" onclick = "location.href = '../Components/about_us.php'">About us</a></li>



<div class="login-signup">
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
  echo "<li><a href = '#Login' id='login'>Login /</a></li>";
  echo "<li><a href = 'SignupPage.php' id='Signup'> Signup</a></li>";
}
?>
</div>

</ul>

<div class = "container2">
    <div class = "form">
          <h4>Describe it!</h4>
         <input type ="text" onkeydown="filterSearch()" onKeypress="filterSearch()" placeholder="Description" id="search-input">
        
       
        
    </div>
</div>

<div id = "container3"> 

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
<div id="myModalmsg" class="modalmsg">
  <div class="modal-contentmsg">
    <span class="closemsg">&times;</span>
      <div class="container">
        <header class="header">
            <h1>Messages</h1>
        </header>
        <main>
            <div class="userSettings">
                <label for="userName">Username:</label>
                <input id="userName" type="text" placeholder="Username" maxlength="32" value="<?php echo $_SESSION['username']; ?>">
            </div>
            <div class="chat">
                <div id="chatOutput"></div>
                <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128">
                <button id="chatSend">Send</button>
            </div>
        </main>
    </div>
    </div>
    </div>
</body>
<style>
   body{
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    background-color: white;
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

/* p
{
display: inline;
color: white;

} */

#login
{
color: #4caf50;
font-weight: bold;

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
.container2
{
    border-width: 1px;
    width: 100%;
    height: 80px;
    background-color: rgb(255, 255, 255);
    display: flex;
    padding-top: 30px;
    
   
}
#search-input{
    width:25vw;
    height:35px;

    }
.search-button{
    width:50px;
    height:40px;
    background-image:url(../assets/pic4.jpg);
}


.form{
    margin:auto;
    position: absolute;
    text-align: center;
    top: 85px;
    left:3%;
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
  
 
#container3
{
   
    display: flex;
   justify-content: space-around;
   flex-wrap: wrap;
}
.pic
{
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    width: 300px;
    height: 500px;
    border: 1px gray;
   
    padding-top: 15px;
}
#home
{
    width: 100%;
    height: 40%;
}
.square {
    border-style: solid ;
    border-color: grey;
    border-width: 1px;
    display: inline-block;
    height: 150px;
    width: 300px;
    background-color: whitesmoke ;
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
.line-between{
border-right:1px solid white;
margin-left:10px;
margin-right:10px;
}
a:hover
{
    color: #4caf50;
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


  h1,
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














  .modalmsg {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-contentmsg {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}

/* The Close Button */
.closemsg {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.closemsg:hover,
.closemsg:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

















  .dropbtn{
  background-color:#101010;
  border:none;
  color: #4caf50;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
}
.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
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













.userSettings {
    margin-bottom: 20px;
    margin-left:300px;
    position:absolute;
    left:-1000;
}

.chat {
    margin-left:300px;
    max-width: 400px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}

.chat #chatOutput {
    overflow-y: scroll;
    height: 280px;
    width: 100%;
    border: 1px solid #777;
}

.chat #chatOutput p {
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #bbb;
    word-break: break-all;
}

.chat #chatInput {
    width: 75%;
}

.chat #chatSend {
    width: 25%;
}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
var houses = <?php echo $payload ?>;
var isLogedIn = <?php echo $isLogedIn ?>;
var result="";
// var houses = [{houseName:"Villa 1", 
//               price:200000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic2.jpg"
//               },
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 3", 
//               price:400000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic1.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               {houseName:"Villa 2", 
//               price:300000, 
//               address:"20 Omar Ibn Elkhatab Street, Sheraton Helioplis",
//               img: "../assets/pic3.jpg"},
//               ];
function filterSearch() {
  var search = document.getElementById("search-input").value.toUpperCase();
  
  if(search == ""){
   
    render(houses);
  }
  else{
  results="";
       result = houses.filter(function(x){
        return x.description.toUpperCase().includes(search);

      });
      
    
     
     
      render(result);
  }
    }  
    filterSearch();
function render(houseobj){
  var containerAll=  document.getElementById("container3");
  while(containerAll.firstChild){
        containerAll.removeChild(containerAll.firstChild);
      }
  Object.keys(houseobj).forEach((x)=>{

      if(houseobj[x].description.length>25){
        var houseDescription = houseobj[x].description.substring(0,25)+"..." ;
      } 
      else{
        var houseDescription = houseobj[x].description;
      }
      var containerAll = document.getElementById("container3");
      var price = document.createTextNode(houseobj[x].price+"$");
      var priceContainer = document.createElement("p");
      var img =document.createElement("img");
      var adContainer = document.createElement("div");
      var description = document.createTextNode(houseDescription);
      var descriptionContainer = document.createElement("p");
      var button1 =  document.createElement("button");
      button1.innerHTML = "Show more";
      var sold = document.createTextNode("SOLD");
      var soldCont = document.createElement("span");
      // button1.onclick = function()
      // {
      //   Popup(x, houseobj); 
      // }
      
      priceContainer.appendChild(price);
      descriptionContainer.appendChild(description);
      adContainer.appendChild(img);                         
      adContainer.appendChild(priceContainer);
      soldCont.appendChild(sold);
      if(houseobj[x].sold==0)
      {
        adContainer.appendChild(soldCont);
      }
      adContainer.appendChild(descriptionContainer);
      
      //adContainer.appendChild(button1);
      containerAll.appendChild(adContainer);
      adContainer.onclick = function()
      {
        window.location.href = "PropertyPage.php?id="+houseobj[x].id;
      }

      // button1.style.marginLeft = "210px";
      // button1.style.backgroundColor =  "#4CAF50";
      // button1.style.border = "0";
      // button1.style.borderRadius = "2px";
      // button1.style.color = "white";
      // button1.style.transitionDuration = "0.4s";
      // button1.style.padding = "5px 5px";


      soldCont.style.paddingLeft = "210px";
      soldCont.style.color = "red";
      soldCont.style.fontWeight = "Bold";
      soldCont.style.position = "absolute";


      
      img.style.borderTopLeftRadius = "5%";
      img.style.borderTopRightRadius = "5%";
      img.src="data:image/jpeg;base64," + houseobj[x].img;
      img.style.width= "300px";
      img.style.height= "200px";
      priceContainer.style.fontWeight= "bold";
      priceContainer.style.paddingLeft= "10px";
      descriptionContainer.style.paddingLeft="10px";
      adContainer.style.margin="20px";
      adContainer.style.marginBottom="70px";
      adContainer.style.width="300px";
      adContainer.style.height="300px";
      adContainer.style.backgroundColor="white";
      adContainer.style.border="1px solid lightgrey";
      adContainer.style.borderRadius="5%";
      adContainer.style.cursor="pointer";

  });
}
function Popup(x, houseobj)
{
  var myDialog = document.createElement("dialog");
  var button = document.createElement("button");
  button.innerHTML = "Close";
  var price = document.createTextNode(houseobj[x].price+"$");
  var priceContainer = document.createElement("p");
  var img =document.createElement("img");
  var adContainer = document.createElement("div");
  var address = document.createTextNode(houseobj[x].address);
  var addressContainer = document.createElement("p");
  var pricetext = document.createTextNode("Price: ");
  var addresstext = document.createTextNode("Address: ");
  button.onclick = function()
  {
      myDialog.style.display = "none";
  }
  window.onclick = function(event)
  {
      if (event.target == myDialog)
      {
          myDialog.style.display = "none";
      }
  }

  img.src = houseobj[x].img;
  img.style.marginLeft = "7vw";
  myDialog.style.borderWidth = "1px";
  myDialog.style.borderColor = "green";
  myDialog.style.height = "27vw";
  myDialog.style.width = "36vw";
  button.style.marginLeft = "32vw";
  button.style.marginBottom = "1vw";
  


  document.body.appendChild(myDialog);
  priceContainer.appendChild(pricetext);
  priceContainer.appendChild(price);
  addressContainer.appendChild(addresstext); 
  addressContainer.appendChild(address);   
  adContainer.appendChild(img);                         
  adContainer.appendChild(priceContainer);
  adContainer.appendChild(addressContainer);


  myDialog.appendChild(button);
  myDialog.appendChild(adContainer);
  myDialog.showModal();
}
 

  
  
  if(isLogedIn ==0){
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
  }}





      // var modalMsg= document.getElementById('myModalmsg');
      // if(isLogedIn == 1){
      // var btnMsg = document.getElementById("messages");
      // var spanMsg = document.getElementsByClassName("closemsg")[0];
      // btnMsg.onclick = function() {
      //   modalMsg.style.display = "block";
      // }
      // spanMsg.onclick = function() {
      //   modalMsg.style.display = "none";
      // }
      // window.onclick = function(event) {
      //   if (event.target == modalMsg) {
      //     modalMsg.style.display = "none";
      //   }
      //   }
      // }



      function accountDrop() {
        document.getElementById("myDropdown").classList.toggle("show");
      }

      // Close the dropdown if the user clicks outside of it
      window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById("myDropdown");
          if (myDropdown.classList.contains('show')) {
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



  //     $(document).ready(function() {
  //     var chatInterval = 250; //refresh interval in ms
  //     var $userName = $("#userName");
  //     var $chatOutput = $("#chatOutput");
  //     var $chatInput = $("#chatInput");
  //     var $chatSend = $("#chatSend");

  //     function sendMessage() {
  //         var userNameString = $userName.val();
  //         var chatInputString = $chatInput.val();

  //         $.get("./write.php", {
  //             username: userNameString,
  //             text: chatInputString
  //         });

  //         $userName.val("");
  //         retrieveMessages();
  //     }

  //     function retrieveMessages() {
  //         $.get("./read.php", function(data) {
  //             $chatOutput.html(data); //Paste content into chat output
  //         });
  //     }

  //     $chatSend.click(function() {
  //         sendMessage();
  //     });

  //     setInterval(function() {
  //         retrieveMessages();
  //     }, chatInterval);
  // });
</script>
</html>