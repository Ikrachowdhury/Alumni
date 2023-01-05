<?php
include '../assets//config.php';
session_start();  

if(isset(($_GET['addmember']))){
     $user_id=$_GET['user_id']; 
     mysqli_query($conn, "UPDATE `users` SET checked = '1' WHERE user_id= '$user_id'") or die('query failed'); 
     header('location:adminmanageapplicant.php');
 

} 
if(isset(($_GET['deletemember']))){ 
     $duser_id=$_GET['user_id'];
     mysqli_query($conn, "DELETE FROM `users` WHERE user_id ='$duser_id'") or die('query failed');
     header('location:adminmanageapplicant.php');
 }
?>