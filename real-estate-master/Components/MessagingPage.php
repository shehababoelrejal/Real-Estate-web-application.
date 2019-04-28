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
?>
</ul>
</nav>
<div class="container">
    <header class="header">
        <h1>Messaging with <?php echo $_SESSION["receiverUsername"]; ?> </h1>
    </header>
    <main>
        <div class="userSettings">
            <input id="userName" type="text" placeholder="Username" maxlength="32" value="<?php echo $_SESSION["id"]; ?>">
            <input id="userNametwo" type="text" placeholder="Usernametwo" maxlength="32" value="<?php echo $_SESSION["receiverId"]; ?>">
        </div>
        <div class="chat">
            <div id="chatOutput"></div>
            <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128">
            <button id="chatSend">Send</button>
        </div>
    </main>
</div>
</body>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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




$(document).ready(function()
{
    var chatInterval = 250; //refresh interval in ms
    var $senderId = $("#userName");
    var $receiverId = $("#userNametwo");
    var $chatOutput = $("#chatOutput");
    var $chatInput = $("#chatInput");
    var $chatSend = $("#chatSend");
    
    function sendMessage()
    {
        var userNameString = $senderId.val();
        var userNameStringtwo = $receiverId.val();
        console.log(userNameStringtwo);
        var chatInputString = $chatInput.val();

        $.get("./write.php", {
            username: userNameString,
            usernametwo: userNameStringtwo,
            text: chatInputString
        });
        retrieveMessages();
    }

    function retrieveMessages()
    {
        $.get("./read.php", function(data) 
        {
            $chatOutput.html(data); //Paste content into chat output
        });
    }

    $chatSend.click(function()
    {
        sendMessage();
    });

    setInterval(function()
    {
        retrieveMessages();
    }, chatInterval);
    });
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
.userSettings
{
    margin-top:500px;
    margin-bottom: 20px;
    margin-left:300px;
    position:absolute;
    left:-1000;
}

.chat
{
    margin-left:500px;
    max-width: 400px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}

.chat #chatOutput
{
    overflow-y: scroll;
    height: 400px;
    width: 100%;
    border: 1px solid #777;
}

.chat #chatOutput p
{
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #bbb;
    word-break: break-all;
}

.chat #chatInput
{
    width: 75%;
}

.chat #chatSend
{
    width: 25%;
}
.first-element-nav
{
  padding-left:8vw;
  padding-right:1vw;
}  
</style>
</html>