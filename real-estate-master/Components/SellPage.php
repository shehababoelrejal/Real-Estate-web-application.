<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"
  />
  <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<?php
session_start();
$isLogedIn = 0;
$countryErr = $cityErr = $imageErr = $addressErr = $sizeErr = $priceErr = $descriptionErr = $addressError = "";
if (isset($_POST["submit"]))
{
  switch($_POST['submit'])
  {
    case 'Add Property':
    if ( !preg_match ("/^[a-zA-Z\s]+$/",$_POST["city"]))
    {
      $cityErr = "Only letters only allowed"; 
    }
    else
    {
      $conn = mysqli_connect('localhost','root','','real_estate');
      $country = $_POST['country'];
      $country = mysqli_real_escape_string($conn,$country);
      $city = $_POST["city"];
      $city = mysqli_real_escape_string($conn,$city);
      $imgFile = addslashes(file_get_contents($_FILES["insertImage"]["tmp_name"]));
      $address = $_POST['address'];
      $address = mysqli_real_escape_string($conn,$address);
      $size = $_POST['size'];
      $size = mysqli_real_escape_string($conn,$size);
      $price = $_POST['price'];
      $price = mysqli_real_escape_string($conn,$price);
      $description = $_POST["description"];
      $description = mysqli_real_escape_string($conn,$description);
      $addressArr = explode(",",$address);
      $buildingNum = $addressArr[0];
      $buildingNum = mysqli_real_escape_string($conn,$buildingNum);    
      $street = $addressArr[1];
      $street = mysqli_real_escape_string($conn , $street);
      $district = $addressArr[2];
      $district = mysqli_real_escape_string($conn , $district);
      $floor = $addressArr[3];
      $floor = mysqli_real_escape_string($conn , $floor);
      $apartment = $addressArr[4];
      $apartment = mysqli_real_escape_string($conn , $apartment);


      $insertAddressQuery = "insert into address (country,city,district,buildingNumber,streetName,floor,apartmentNumber)
      values ('$country','$city','$district','$buildingNum','$street','$floor','$apartment') ";
      $checkAddress = "Select * from address where country = '$country' AND city = '$city' AND district = '$district' And
      buildingNumber = '$buildingNum' AND streetName = '$street' AND  floor = '$floor' AND apartmentNumber = '$apartment'  ";
      $result = mysqli_query($conn,$checkAddress);
      if(mysqli_num_rows($result)>0){
      //do nothing
      
      }
      else{
      mysqli_query($conn,$insertAddressQuery);
      }
      $submitPropertyQuery = "insert into property (price , isAvailable , locationId , size , description,ownerId , photo , addressId) 
      values ('$price', 1 , 1 , '$size' , '$description','" .$_SESSION['id'] ."', '$imgFile' , 
      (select id from address where country = '$country' AND city = '$city' AND district = '$district' And
      buildingNumber = '$buildingNum' AND streetName = '$street' AND  floor = '$floor' AND apartmentNumber = '$apartment'))";
      mysqli_query($conn,$submitPropertyQuery);
      mysqli_close($conn);
      break;
    }
  }
}
?>
<body>
<ul class = "NavigationBar">
<li class="first-element-nav"><a href="HomePage.php"><i class="fa fa-home"></i></a>
<li class="nav-element"><a class="nav-element" href="#Buy" onclick = "location.href = '../Components/BuyPage.php'">Buy</a></li>
<div class="line-between"></div>
<li  ><a class="nav-element" href="#Add property" id="add-property" >Sell</a></li>
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
  echo "<li><a href = '#Signup' id='Signup'> Signup</a></li>";
}
?>



</div>
</ul>
<div id="addProperty" class="add-property"> 
               <div class="propertyAdd">
                 <h2>Add Your Property</h2>
                 <form method="post" enctype="multipart/form-data">   
                  <h5>Country <span class = "validation">* </span></h5>
                  <p></p>
                  <select name="country">
                         <option value="">Country...</option>
                         <option value="Albania">Albania</option>
                         <option value="Algeria">Algeria</option>
                         <option value="Angola">Angola</option>               
                         <option value="Argentina">Argentina</option>
                         <option value="Armenia">Armenia</option>  
                         <option value="Australia">Australia</option>
                         <option value="Austria">Austria</option>
                         <option value="Azerbaijan">Azerbaijan</option>
                         <option value="Bahrain">Bahrain</option>
                         <option value="Belarus">Belarus</option>
                         <option value="Belgium">Belgium</option>
                         <option value="Botswana">Botswana</option>
                         <option value="Brazil">Brazil</option>
                         <option value="Bulgaria">Bulgaria</option>
                         <option value="Burkina Faso">Burkina Faso</option>
                         <option value="Burundi">Burundi</option>
                         <option value="Cambodia">Cambodia</option>
                         <option value="Cameroon">Cameroon</option>
                         <option value="Canada">Canada</option>
                         <option value="Chad">Chad</option>
                         <option value="Channel Islands">Channel Islands</option>
                         <option value="Chile">Chile</option>
                         <option value="China">China</option>
                         <option value="Colombia">Colombia</option>
                         <option value="Comoros">Comoros</option>
                         <option value="Congo">Congo</option>
                         <option value="Costa Rica">Costa Rica</option>
                         <option value="Cote DIvoire">Cote D'Ivoire</option>
                         <option value="Croatia">Croatia</option>
                         <option value="Cuba">Cuba</option>
                         <option value="Curaco">Curacao</option>
                         <option value="Cyprus">Cyprus</option>
                         <option value="Czech Republic">Czech Republic</option>
                         <option value="Denmark">Denmark</option>
                         <option value="Dominica">Dominica</option>
                         <option value="Ecuador">Ecuador</option>
                         <option value="Egypt">Egypt</option>
                         <option value="Estonia">Estonia</option>
                         <option value="Ethiopia">Ethiopia</option>
                         <option value="Finland">Finland</option>
                         <option value="France">France</option>
                         <option value="Gabon">Gabon</option>
                         <option value="Gambia">Gambia</option>
                         <option value="Georgia">Georgia</option>
                         <option value="Germany">Germany</option>
                         <option value="Ghana">Ghana</option>
                         <option value="Greece">Greece</option>
                         <option value="Greenland">Greenland</option>
                         <option value="Honduras">Honduras</option>
                         <option value="Hong Kong">Hong Kong</option>
                         <option value="Hungary">Hungary</option>
                         <option value="Iceland">Iceland</option>
                         <option value="India">India</option>
                         <option value="Indonesia">Indonesia</option>
                         <option value="Iran">Iran</option>
                         <option value="Iraq">Iraq</option>
                         <option value="Ireland">Ireland</option>
                         <option value="Italy">Italy</option>
                         <option value="Jamaica">Jamaica</option>
                         <option value="Japan">Japan</option>
                         <option value="Jordan">Jordan</option>
                         <option value="Kazakhstan">Kazakhstan</option>
                         <option value="Kenya">Kenya</option>
                         <option value="Korea North">Korea North</option>
                         <option value="Korea Sout">Korea South</option>
                         <option value="Kuwait">Kuwait</option>
                         <option value="Latvia">Latvia</option>
                         <option value="Lebanon">Lebanon</option>
                         <option value="Liberia">Liberia</option>
                         <option value="Libya">Libya</option>
                         <option value="Luxembourg">Luxembourg</option>
                         <option value="Macedonia">Macedonia</option>
                         <option value="Madagascar">Madagascar</option>
                         <option value="Malaysia">Malaysia</option>
                         <option value="Malawi">Malawi</option>
                         <option value="Maldives">Maldives</option>
                         <option value="Mali">Mali</option>
                         <option value="Malta">Malta</option>
                         <option value="Marshall Islands">Marshall Islands</option>
                         <option value="Martinique">Martinique</option>
                         <option value="Mayotte">Mayotte</option>
                         <option value="Mexico">Mexico</option>
                         <option value="Morocco">Morocco</option>
                         <option value="Nambia">Nambia</option>
                         <option value="Nauru">Nauru</option>
                         <option value="Nepal">Nepal</option>
                         <option value="Netherland Antilles">Netherland Antilles</option>
                         <option value="Netherlands">Netherlands (Holland, Europe)</option>
                         <option value="Nevis">Nevis</option>
                         <option value="New Caledonia">New Caledonia</option>
                         <option value="New Zealand">New Zealand</option>
                         <option value="Nicaragua">Nicaragua</option>
                         <option value="Niger">Niger</option>
                         <option value="Nigeria">Nigeria</option>
                         <option value="Niue">Niue</option>
                         <option value="Norfolk Island">Norfolk Island</option>
                         <option value="Norway">Norway</option>
                         <option value="Oman">Oman</option>
                         <option value="Pakistan">Pakistan</option>
                         <option value="Palau Island">Palau Island</option>
                         <option value="Palestine">Palestine</option>
                         <option value="Panama">Panama</option>
                         <option value="Paraguay">Paraguay</option>
                         <option value="Peru">Peru</option>
                         <option value="Poland">Poland</option>
                         <option value="Portugal">Portugal</option>
                         <option value="Puerto Rico">Puerto Rico</option>
                         <option value="Qatar">Qatar</option>
                         <option value="Republic of Montenegro">Republic of Montenegro</option>
                         <option value="Republic of Serbia">Republic of Serbia</option>
                         <option value="Romania">Romania</option>
                         <option value="Russia">Russia</option>
                         <option value="Saudi Arabia">Saudi Arabia</option>
                         <option value="Senegal">Senegal</option>
                         <option value="Serbia">Serbia</option>
                         <option value="Slovakia">Slovakia</option>
                         <option value="Slovenia">Slovenia</option>
                         <option value="South Africa">South Africa</option>
                         <option value="Spain">Spain</option>
                         <option value="Sri Lanka">Sri Lanka</option>
                         <option value="Sudan">Sudan</option>
                         <option value="Suriname">Suriname</option>
                         <option value="Swaziland">Swaziland</option>
                         <option value="Sweden">Sweden</option>
                         <option value="Switzerland">Switzerland</option>
                         <option value="Syria">Syria</option>
                         <option value="Taiwan">Taiwan</option>
                         <option value="Tajikistan">Tajikistan</option>
                         <option value="Tanzania">Tanzania</option>
                         <option value="Thailand">Thailand</option>
                         <option value="Togo">Togo</option>
                         <option value="Tunisia">Tunisia</option>
                         <option value="Turkey">Turkey</option>
                         <option value="Uganda">Uganda</option>
                         <option value="Ukraine">Ukraine</option>
                         <option value="United Arab Erimates">United Arab Emirates</option>
                         <option value="United Kingdom">United Kingdom</option>
                         <option value="United States of America">United States of America</option>
                         <option value="Uraguay">Uruguay</option>
                         <option value="Uzbekistan">Uzbekistan</option>
                         <option value="Vietnam">Vietnam</option>
                         <option value="Yemen">Yemen</option>
                         <option value="Zambia">Zambia</option>
                         <option value="Zimbabwe">Zimbabwe</option>
                         </select>
                    <p></p>
                   <h5>City <span class = "validation">*  <?php echo $cityErr; ?></span></h5>
                   
                   <input type="text" name="city"
                     required="" 
                   />
                   <h5>Address<span class = "validation">* </span></h5>
                   <input  type="text" placeholder="Apartment, suite, unit, building, floor, etc.."
                   required=""
                   name="address"
                   />
                   <h5>Size<span class = "validation">* <?php echo $sizeErr; ?> </span></h5>
                   <p></p>
                   <input
                   style = "margin-top:5px;margin-bottom:15px;"
                     type="number"
                     name="size"
                     required=""
                     
                   />
                   <h5>Price<span class = "validation">* <?php echo $priceErr; ?> </span></h5>
                   <input
                   style = "margin-top:5px;margin-bottom:15px;"
                   type="number"
                   name="price"
                   required=""
                    />
                 <h5>Description<span class = "validation">* <?php echo $descriptionErr; ?></span></h5>
                  <input  type="text"
                    required=""
                    name="description"
                    maxlength="200"
                  />
                  <h5>Upload image<span class = "validation">* </span></h5>
                  <input required="" type = "file" name="insertImage" id ="insertImage" class="imageBtn" >

                 <input name="submit"type="submit" id="submit" value="Add Property" />
             </form>
         </div>
       </div>
      </div>
   </div>
 </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
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
function validateImage()
{
  $(document).ready(function()
  {
    $('#submit').click(function()
    {
      var image_name = $('#insertImage').val();
      var extension = $('#insertImage').val().split('.').pop().toLowerCase();
      if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
      {  
        alert('Invalid Image File');
        $('#insertImage').val('');
       
        return false;
      }  
    });  
  });  
}
validateImage();


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
</script>
<style>
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
  background:white;
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
.propertyAdd
{
    width: 50%;
    margin: 0 auto 0 auto;
    background: #fff;
    padding: 30px 64px;
}
.imageBtn{
  margin:20px;
  margin-left:0px
}
.propertyAdd h2
{
    color: #4caf50;
    font-size: 26px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 500;
}

.propertyAdd form input[type="text"],
.propertyAdd form input[type="password"]
{
    width: 94%;
    padding: 10px;
    font-size: 14px;
    border: none;
    border-bottom: 2px solid #e6e6e6;
    outline: none;
    color: #d8d5d5;
    margin-bottom: 20px;
}
.propertyAdd h5
{
    font-family: "Lato", sans-serif !important;
    color: #4caf50;
    margin-bottom: 8px;
    font-size: 15px;
}
.propertyAdd form input[type="text"]:hover,
.propertyAdd form input[type="password"]:hover
{
    border-bottom: 2px solid #b384fb;
    color: #000;
    transition: 0.5s all;
}
.propertyAdd form input[type="text"]:focus,
.propertyAdd form input[type="password"]:focus
{
    border-bottom: 2px solid #b384fb;
    color: #000;
    transition: 0.5s all;
}
.propertyAdd form input[type="submit"]
{
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
.propertyAdd form input[type="submit"]:hover
{
    background: rgb(206, 206, 206);
    color: #000;
    border-bottom: 5px solid rgb(168, 168, 168);
    transition: 0.5s all;
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
.validation
{
  color:red;
}

</style>
</html>