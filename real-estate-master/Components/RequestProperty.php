<?php
 session_start();
 $conn = mysqli_connect('localhost','root','','real_estate');
 $propertyId =$_GET['id'];
 $buyerId= $_SESSION['id'];
 $checkQuery = "Select * from propertyuser where buyerId = $buyerId AND propertyId = $propertyId";
 $result=mysqli_query($conn,$checkQuery);
 
 
 if(mysqli_num_rows($result)!=0){
   header("Location: PropertyPage.php?id=".$propertyId."&case=1");

 }
else{
 $reqQuery = "insert into propertyuser (buyerId,propertyId) values ($buyerId,$propertyId)";
 $getOwnerQuery = "select * from property where id ='$propertyId'";
 $result= mysqli_query($conn,$getOwnerQuery);
    if(mysqli_num_rows($result)){
        while($rows=mysqli_fetch_assoc($result)){
            $ownerId = $rows['ownerId'];
            $description = $rows['description'];
        }
        
    }
    if(strlen($description > 20)){
        substr($description,0,19);
        $description=$description."...";
    }
  
 mysqli_query($conn,$reqQuery);

 $query="INSERT INTO chat (senderId, receiverId, text) VALUES ($buyerId,$ownerId, 'Sent a request for property with this description:''". $description."')";
 mysqli_query($conn,$query);
 header("Location: PropertyPage.php?id=".$propertyId."&case=0");
}
mysqli_close($conn);

 ?>