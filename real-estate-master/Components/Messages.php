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
<ul class="navbar-nav" style = "margin-right:900px;">
<li class="first-element-nav"><a href="HomePage.php"><i class="fa fa-home"></i></a>
    <li><a href="#Buy" onclick = "location.href = '../Components/BuyPage.php'">Buy</a></li>
    <div class="line-between"></div>
    <li><a href="#Add property" id="add-property" onclick = "location.href = '../Components/SellPage.php'">Sell</a></li>
    <div class="line-between"></div>
    <li ><a href="#Aboutus" onclick = "location.href = '../Components/about_us.php'">About us</a></li>
</ul>
<ul class="navbar-nav">
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
    echo "<li class = 'nav-item'><a href = '#Login' id = 'login_signup'>Login</a></li>";
    echo "<li class = 'nav-item slash'  id = 'login_signup'>/</li>";
    echo "<li class = 'nav-item'><a href = '#Signup' id = 'login_signup'>Signup</a></li>";
}

class receiver
{
    public $receiverusername;
    public $id;
    public function __construct($receiverusername,$id)
    {
        $this->receiverusername = $receiverusername;
        $this->id = $id; 
    }
}
$conn = mysqli_connect('localhost','root','','real_estate');
$query="SELECT username,id FROM user where id IN  (SELECT senderId FROM chat WHERE receiverId = '".$_SESSION["id"]."')";
$allReceivers = array();
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($allReceivers,new receiver($row['username'],$row['id']));
    }
}
$payload = json_encode($allReceivers);

?>
</ul>
</nav>
<h1 style = "position:absolute;">Messages</h1>
<div id="container" style = "height:50%;width:50%;margin-top:150px;margin-left:45vw;">

</div>
</body>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
var receivers = <?php echo $payload ?>;
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
function render(receiversobj)
{
  Object.keys(receiversobj).forEach((x)=>
  {
    var containerAll = document.getElementById("container");
    var receiverButton = document.createElement("a");
    var br = document.createElement("br");
    var receiverName = document.createTextNode(receiversobj[x].receiverusername);
    receiverButton.appendChild(receiverName);
    containerAll.appendChild(br);
    receiverButton.style.marginTop = "1vw";
    //receiverButton.style.display = "flex";
    //receiverButton.style.flexDirection = "column";
    //receiverButton.style.align = "middle";
    receiverButton.id = "receiverButton";
    //receiverButton.class = "btn";
    receiverButton.style.backgroundColor =  "#4CAF50";
    receiverButton.style.border = "0";
    receiverButton.style.borderRadius = "2px";
    receiverButton.style.color = "white";
    receiverButton.style.padding = "5px 8px";
    receiverButton.style.cursor="pointer";
    receiverButton.style.marginBottom="10px";
    receiverButton.value = receiversobj[x].receiverusername;
    receiverButton.onclick = function()
    {
        receiverButton.href = "MessagingPageFromMessages.php?id="+receiversobj[x].id+"&username="+receiversobj[x].receiverusername;
    };
    containerAll.appendChild(receiverButton);
});
}
render(receivers);

</script>
<style>
html
{
    box-sizing: border-box;
}

*,
*:before,
*:after {
    box-sizing: inherit;
}
body
{
    background-color: White;
    font-family: Arial, Helvetica, sans-serif;
    display: flex;
    justify-content: center;
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

a
{
    color: white;
    text-decoration: none;
}

#login_signup
{
    color: #4caf50;
    font-weight: bold;
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
}
.navBar
{
    width:100%;
    position: fixed;
}
h1
{
    margin-top:70px;
    color:#4caf50;
}
h2,h3,h4,h5,h6
{
    font-family: "Amaranth", sans-serif;
    margin: 0;
}
.dropbtn
{
    background-color:black;
    border:none;
    color: #4caf50;
    font-weight: bold;
    cursor: pointer;
    font-size: 16px;
}
.dropdown
{
    float: left;
    overflow: hidden;
}

.dropdown
{
    cursor: pointer;
    font-size: 16px;  
    border: none;
    outline: none;
    color: white;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
}

.dropdown-content
{
    display: none;
    position: fixed;
    background-color: #f9f9f9;
    min-width: 120px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a
{
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover
{
    background-color: #ddd;
}

.show 
{
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
h1
{
    margin-top:70px;
    color:#4caf50;
}
.first-element-nav
{
  padding-left:8vw;
  padding-right:1vw;
}  
</style>
</html>