<?php
 
session_start();
if($_SESSION['is_login']!=1){
header('location:../assets/login.php');
}
 $user_id=$_SESSION['user_id'];  
  
 ?>jhjhj
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
 
<div class="maindiv p-0"> 
     
<!--------------------------------------- Discover page body---- -->
<div class="mainsection">   
    <div><?php include 'forumpost.php'; ?></div> 
 
 

</div>
</div>  
</body>
</html>