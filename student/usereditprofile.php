<?php
session_start(); 
if($_SESSION['is_login']!=1){
    header('location:../assets/login.php');
  }
$user_email=$_SESSION['user_email'];
$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];  

?> 
<!DOCTYPE html>
<html lang="en">
<head> 
    <!-- ------------------------------------------all link and css-------------------------------------------- -->
     <?php include '../assets//linkheader.php';?>   
    
    
    <title>user Structure</title>
</head>
<body> 
<div class="container-scroller">
<!-------------------------------- header and sidebar---------------------- -->
<div class="header"> 
<?php include '../assets//nav.php';?>  
</div>
<!---------------------------------------------totall page-------------------------------------------- -->
 
<div class="maindiv">  
<!--------------------------------------- Discover page body---- -->
<div class="mainsection"> 
    
    <div><?php include 'editProfile.php'; ?></div> 
    
     


</div>

</div>
</div>  
</body>
</html>