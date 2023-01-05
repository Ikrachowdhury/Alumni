<?php
session_start();
if(!$_SESSION['is_login']){
    header('location:../assets/login.php');
}
$user_id=$_SESSION['user_id']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

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
 
    <div><?php include '../assets/changepass.php'; ?></div> 
 
</div>

</div>
</div>  
</body>
</html>