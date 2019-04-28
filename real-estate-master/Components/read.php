<?php
require("./_connect.php");
session_start();
$db = new mysqli($db_host,$db_user, $db_password, $db_name);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$receiverId = $_SESSION['receiverId'];
$query="SELECT * FROM chat Where senderId = '".$_SESSION["id"]."' AND receiverId = '$receiverId' ORDER BY id ASC";
//echo $query;
if ($db->real_query($query))
 {
    $res = $db->use_result();
    while ($row = $res->fetch_assoc())
    {
        $username=$_SESSION["username"];
        $text=$row["text"];
        $time=date('G:i', strtotime($row["time"])); 
        echo "<p>$time | $username: $text</p>\n";
    }
}
$query3="SELECT username FROM user where id = (SELECT receiverId FROM chat WHERE senderId = '".$_SESSION["id"]."')";
if ($db->real_query($query3))
 {
    $res3 = $db->use_result();
    while ($row3 = $res3->fetch_assoc())
    {
        $username3 = $row3["username"];
    }
}
$query2="SELECT * FROM chat Where receiverId = '".$_SESSION["id"]."' AND  senderId = '$receiverId' ORDER BY id ASC";

if ($db->real_query($query2))
 {
    
    $res2 = $db->use_result();
    while ($row2 = $res2->fetch_assoc())
    {
        $username2 = $_SESSION["receiverUsername"];
        $text2=$row2["text"];
        $time2=date('G:i', strtotime($row2["time"]));
        echo "<p>$time2 | $username2: $text2</p>\n";
    }
}
else
{
    echo "An error occured";
    echo $db->errno;
}
$db->close();
?>