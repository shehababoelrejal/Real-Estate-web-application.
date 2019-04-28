<!DOCTYPE <!DOCTYPE html>

<html>
  <?php
  $username = $passwordErr = $emailErr = $nameErr = $email = $password = $mobileno = "";
  if (isset($_POST["submit"])) {
    if (!preg_match("/^[a-zA-Z\d ]*$/",$_POST["username"])) {
      $nameErr = "Only letters,numbers and white space allowed"; 
      
    }
    else if (!preg_match("/^[a-zA-Z\d ]*$/",$_POST["username"])) {
      $nameErr = "Only letters,numbers and white space allowed"; 
      
    }
    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
    else if ($_POST["password"]!= $_POST["confirmPassword"]) {
      $passwordErr = "passwords not matching"; 
    }
    else{
      $conn = mysqli_connect('localhost','root','','real_estate');
      $username = $_POST["username"];
      $username = mysqli_real_escape_string($conn,$username);
      $email = $_POST["email"];
      $email = mysqli_real_escape_string($conn,$email);      
      $password = $_POST["password"];
      $password = mysqli_real_escape_string($conn,$password);
      if(!$conn){
        die("connection failed:".mysqli_connect_error());
      }
      $insertQuery = "Insert into user (username,email,password,userTypeid)
      values ('$username','$email','$password',1)";
      mysqli_query($conn, $insertQuery);
      mysqli_close($conn);
     
    }
  }
  ?>
  <head> </head>
  <body>
    
    <a href="#Signup" id="Signup"> Signup</a>
    <div id="myModal" class="modal">
    <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <div class="content">
      <div class="main">
        <h2>Register your acccount</h2>
        <form method="post">
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
    
    <script>
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("Signup");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
  </body>
</html>
<style>
  body {
    padding: 0;
    margin: 0;
    background-color: rgb(226, 226, 226);
    font-family: "Lato", sans-serif !important;
  }
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 50px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
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

  .main {
    width: 50%;
    margin: 0 auto 0 auto;
    background: #fff;
    padding: 30px 64px;
    box-shadow: 0px 0px 5px 5px rgb(182, 182, 182);
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

