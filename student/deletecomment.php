<?php
include '../assets//config.php';
if(isset(($_GET['deleteComment']))){
     $comment_id=$_GET['comment_id']; 
      mysqli_query($conn, "DELETE FROM `comment_reply` WHERE  comment_id = '$comment_id'") or die('query failed');
      mysqli_query($conn, "DELETE FROM `comment` WHERE  comment_id = '$comment_id'") or die('query failed'); 
      header('location:userfeed.php');
  

} 
if(isset(($_GET['deleteReplyComment']))){
    $comment_id=$_GET['comment_id'];
    $reply_id=$_GET['reply_id'];  
     mysqli_query($conn, "DELETE FROM `comment_reply` WHERE  comment_id = '$comment_id' AND reply_id='$reply_id'") or die('query failed'); 
     header('location:userfeed.php');
 

} 
?>