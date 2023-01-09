<?php

include '../assets//config.php'; 
$isclicked=false;

if(isset($_POST['submit'])){
    $isclicked=true;

    $post_tittle = mysqli_real_escape_string($conn, $_POST['post_tittle']);
    if($post_tittle ==null){ 
        echo '<script>alert("Must provide a valid search key")</script>'; 
        $isclicked=false;
        
    }  
} 
if (isset($_POST['postsubmit'])) {
  
    $post_description = mysqli_real_escape_string($conn, $_POST['post_description']); 
    $post_tittle = mysqli_real_escape_string($conn, $_POST['post_tittle']);
     
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../images//' . $image;
 
    
    $post_time = date("m.d.Y"); 

    if ($image_size > 3145728) {
        $message[] =  'Image size is too large ,please provide new picture less than 3MB';
    
    
    }  else {
        move_uploaded_file($image_tmp_name, $image_folder);
        $create_post = mysqli_query($conn, "INSERT INTO `post`(user_id,post_title,post_caption,post_picture,post_time) VALUES('$user_id', '$post_tittle','$post_description', '$image', '$post_time')") or die('query failed');
        $message[] =  'Post created successfully!';
    }
}

if(isset(($_GET['dpost_id']))){ 
    $dpost_id=$_GET['dpost_id'];
    mysqli_query($conn, "DELETE FROM `post` WHERE post_id ='$dpost_id'") or die('query failed');
}


//-----------------------------------------chosing from action to sort the list of forum------------------------------------
if(isset(($_GET['most_reply']))){
    $sort_type="most_reply"; 

}else if(isset(($_GET['most_view']))){
    $sort_type="most_view";

}else if(isset(($_GET['no_reply']))){
    $sort_type="no_reply";

}else{
    $sort_type="latest";
}
//-----------------------------------------------------------------------------------------------------------------------------

//-------------------------------------------------for basic card body-----------------------------------------------------------
function forumcardbody($post_id,$user_id,$puser_id,$user_image,$user_name,$post_caption,$post_time,$post_tittle,$numberof_view,$numberof_reply){?>
 <div class="card mb-2">
                    <div class="card-body p-2 p-sm-3">
                        <div class="d-flex"> 
                    <a href="#"><img src="../images//<?php echo $user_image; ?>" class="mr-3 rounded-circle" width="40" alt="User" /></a><span class="text-muted "> <?php echo $user_name; ?></span>
                    <?php  if($puser_id==$user_id){?>
                    <a href="allforumpost.php?  dpost_id=<?php echo $post_id; ?>  " class="text-danger ms-auto" data-original-title="Delete"><i class="far fa-trash-alt"></i></a>
                    <?php }?>
                    </div>
                     <div class="media-body">
                                <a  href="../student/userfeed.php?  selectedpost_id=<?php echo $post_id; ?>  " class="fw-bolder"><?php echo $post_tittle; ?></a></h6>
                                <p class="text-secondary">
                                    <?php echo  $post_caption; ?>
                                </p>
                                <p class="text-muted"><a href="javascript:void(0)">drewdan</a> replied <span class="text-secondary font-weight-bold">13 minutes ago</span></p>
                            </div>
                            <div class="text-muted small text-center align-self-center">
                                <span class="d-none d-sm-inline-block"><i class="far fa-eye"></i><?php echo $numberof_view; ?></span>
                                <span><i class="far fa-comment ml-2"></i> <?php echo $numberof_reply; ?></span>
                            </div>
                        </div>
                    </div> 

<?php }
//---------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------for sort based query for forum sorting----------------------------------------
function forumBasedOnSort($post,$conn,$user_id){  
     if(mysqli_num_rows($post) > 0){
    while($row = mysqli_fetch_assoc($post)){
        $post_id= $row['post_id']; 
        $post_tittle=$row['post_title'];
        $post_caption=$row['post_caption']; 
        $post_time=$row['post_time'];
        $numberof_view=$row['numberof_view'];
        $numberof_reply =$row['numberof_reply'];
        $puser_id=$row['user_id'];
        $user=mysqli_query($conn, "SELECT * FROM `users` WHERE user_id='$puser_id'") or die('query failed');
        if(mysqli_num_rows($user) > 0){
            $rowc= mysqli_fetch_assoc($user);
            $user_name=$rowc['name'];
            $user_image=$rowc['user_image'];
             
        } 
        forumcardbody($post_id,$user_id,$puser_id,$user_image,$user_name,$post_caption,$post_time,$post_tittle,$numberof_view,$numberof_reply);
 }
}

 
   
     } ?>
<!-- --------------------------------------------------------------------------------------------------------------------- -->



<!-- ------------------------------------------error or successfull messege---------------------- -->

<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
  <div class="message">
     <span>' . $message . '</span>
     <i  class="fa-solid fa-xmark" style="font-size:20px" onclick="this.parentElement.remove();"></i>
  </div>
  ';
    }
}
?>

<!-- -------------------------------------------------------------------------------------------------- -->

<!-- --------------------------------------------------total body-------------------------------------- -->
<div class="main-body  p-0">
    <div class="inner-wrapper">
        <!-- Inner sidebar -->
        <div class="inner-sidebar">
            <!-- Inner sidebar header -->
            <div class="inner-sidebar-header justify-content-center">
                <button class="btn btn-primary has-icon btn-block" type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                    <svg xmlns="" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    NEW DISCUSSION
                </button> 
            </div>
            <!-- /Inner sidebar header -->

            <!-- Inner sidebar body -->
            <div class="inner-sidebar-body p-0">
                <div class="p-3 h-100" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: -16px;">
                        <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 16px;">
                                        <nav class="nav nav-pills nav-gap-y-1 flex-column"> 

                                        <a href="allforumpost.php"  class="nav-link nav-link-faded has-icon">Latest</a> 
                                        <a href="allforumpost.php?most_view=1" class="nav-link nav-link-faded has-icon">Most viewed</a>
                                        <a href="allforumpost.php?most_reply=1" class="nav-link nav-link-faded has-icon">Most Replies</a>
                                        <a href="allforumpost.php?no_reply=1" class="nav-link nav-link-faded has-icon">No replies yet</a>

                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div>
                </div>
            </div>
            <!-- /Inner sidebar body -->
        </div>
        <!-- /Inner sidebar -->

        <!-- Inner main -->
        <div class="inner-main">
            <!-- Inner main header -->
            <div class="inner-main-header d-flex"> 
                <select class="custom-select custom-select-sm w-auto me-auto mr-1">
                    <option selected="0">Latest</option> 
                    <option value="1">Most viewed</option>
                    <option value="2">No Replies Yet</option>
                    <option value="3">Most replied</option>
                </select>
                <form action="allforumpost.php" class="d-flex" method="post">
                <span class="input-icon input-icon-sm ml-auto  ">
                    <input type="text" name="post_tittle" class="form-control form-control-sm bg-gray-200 border-gray-200 shadow-none mb-4 mt-4 flex-shrink-1 " placeholder="Search forum" />
                </span>
                <div>
                <button class="btn btn-sm mt-4" name="submit" type="sumbit" > Enter</button>
                </div>
                 
                </form>
            </div>
            <!-- /Inner main header -->

            <!-- Inner main body -->

            <!-- Forum List -->
            <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">


            <!-- ----------------------------------if seached a thread result is shown--------------------- -->
          <?php  if($isclicked){ 
             $post = mysqli_query($conn, "SELECT * FROM `post`  WHERE  post_title LIKE '%$post_tittle%'") or die('query failed');
         if(mysqli_num_rows($post) > 0){
            while($row = mysqli_fetch_assoc($post)){
                $post_id= $row['post_id']; 
                $post_tittle=$row['post_title'];
                $post_caption=$row['post_caption']; 
                $post_time=$row['post_time']; 
                $puser_id=$row['user_id'];
                $numberof_view=$row['numberof_view'];
                $numberof_reply =$row['numberof_reply'];
                $user=mysqli_query($conn, "SELECT * FROM `users` WHERE user_id='$puser_id'") or die('query failed');
                if(mysqli_num_rows($user) > 0){
                    $rowc= mysqli_fetch_assoc($user);
                    $user_name=$rowc['name'];
                    $user_image=$rowc['user_image'];
                     
                } 
                forumcardbody($post_id,$user_id,$puser_id,$user_image,$user_name,$post_caption,$post_time,$post_tittle,$numberof_view,$numberof_reply);
         }
      }else{
         echo ' <div class="heading">
         <div class="mt-3 bg-light text-center" >
             <h2>NO Forum Topic Exist with such Tittle</h2>
    </div>
    </div>';
      }
    
   //-------------------------------end of searching result shown---------------------------
    
//------------------------------------------if no searching ---------------------------------

}else{  

    if($sort_type=="most_reply"){
        $post = mysqli_query($conn, " SELECT * FROM `post` ORDER BY numberof_reply DESC ") or die('query failed');
        forumBasedOnSort($post,$conn,$user_id); 

    }else if($sort_type=="no_reply"){
        $post = mysqli_query($conn, " SELECT * FROM `post` WHERE numberof_reply='0'") or die('query failed');
        forumBasedOnSort($post,$conn,$user_id);
      

    }else if($sort_type=="most_view"){
        $post = mysqli_query($conn, " SELECT * FROM `post` ORDER BY numberof_view DESC ") or die('query failed');
        forumBasedOnSort($post,$conn,$user_id); 

    }else{
        $post = mysqli_query($conn, " SELECT * FROM `post` ORDER BY post_id DESC ") or die('query failed');
        forumBasedOnSort($post,$conn,$user_id);
    }
     
  

    }?>
  
 

            <!-- /Inner main body -->
        </div>
        <!-- /Inner main -->
    </div>

 <!-- --------------------------------------------------create discussion hover area-------------- ------------------------------------>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="tittle" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
      <div class="modal-header"> 
      <h3  class="modal-title " id="tittle"><i class="fa-solid fa-pencil"></i> New Querie</h3> 
      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
 
        
            <div class="card card-body px-5">  
                <!---------------------------------------form for post------------------------------------ -->
                <form class="row" action="" method="post" name="postform" enctype="multipart/form-data" autocomplete="off">
                
                    <div class="col-sm-12 form-group">
                        <label   class="mb-2"><b>Tittle:</b> <sup class="star-color">*</sup></label>
                        <input id="name" type="text" class="form-control" name="post_tittle" value="" required autofocus>
                    </div>
               
                    <div class="col-sm-12 form-group">
                        <label for="post_caption" class="mb-2"><b>Description:</b> <sup class="star-color">*</sup></label>
                        <textarea name="post_description" class="form-control form-control-lg mb-4" rows="4"></textarea>
                    </div> 
                    <div class="col-sm-12 form-group mb-3">
                        <label for="photo" class="mb-2"><b>Photo:</b></label>
                        <input class="form-control" type="file" accept="image/jpg, image/jpeg, image/png" name="image">
                    </div>
                    
                    <div class="align-items-center d-flex">
                        <button type="submit" name="postsubmit" class="btn btn-sm btn-primary ms-auto"><i class="fas fa-check"></i> Post</button>
                    </div>

                </form>
          
    </div>
    </div>
    </div>
</div>
    <!-- ---------------------------------------------------------------- -->
    </div>
</div> 
<!-- -----------------------------------------end of totall body-------------------------------------- -->

<style type="text/css">
body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.inner-wrapper {
    position: relative;
    height: calc(100vh - 3.5rem);
    transition: transform 0.3s;
}
@media (min-width: 992px) {
    .sticky-navbar .inner-wrapper {
        height: calc(100vh - 3.5rem - 48px);
    }
}

.inner-main,
.inner-sidebar {
    position: absolute;
    top: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
}
.inner-sidebar {
    left: 0;
    width: 235px;
    border-right: 1px solid #cbd5e0;
    background-color: #fff;
    z-index: 1;
}
.inner-main {
    right: 0;
    left: 235px;
}
.inner-main-footer,
.inner-main-header,
.inner-sidebar-footer,
.inner-sidebar-header {
    height: 3.5rem;
    border-bottom: 1px solid #cbd5e0;
    display: flex;
    align-items: center;
    padding: 0 1rem;
    flex-shrink: 0;
}
.inner-main-body,
.inner-sidebar-body {
    padding: 1rem;
    overflow-y: auto;
    position: relative;
    flex: 1 1 auto;
}
.inner-main-body .sticky-top,
.inner-sidebar-body .sticky-top {
    z-index: 999;
}
.inner-main-footer,
.inner-main-header {
    background-color: #fff;
}
.inner-main-footer,
.inner-sidebar-footer {
    border-top: 1px solid #cbd5e0;
    border-bottom: 0;
    height: auto;
    min-height: 3.5rem;
}
@media (max-width: 767.98px) {
    .inner-sidebar {
        left: -235px;
    }
    .inner-main {
        left: 0;
    }
    .inner-expand .main-body {
        overflow: hidden;
    }
    .inner-expand .inner-wrapper {
        transform: translate3d(235px, 0, 0);
    }
}

.nav .show>.nav-link.nav-link-faded, .nav-link.nav-link-faded.active, .nav-link.nav-link-faded:active, .nav-pills .nav-link.nav-link-faded.active, .navbar-nav .show>.nav-link.nav-link-faded {
    color: #3367b5;
    background-color: #c9d8f0;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #467bcb;
}
.nav-link.has-icon {
    display: flex;
    align-items: center;
}
.nav-link.active {
    color: #467bcb;
}
.nav-pills .nav-link {
    border-radius: .25rem;
}
.nav-link {
    color: #4a5568;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}
.main-body{
    margin-top: 60px;
}
</style>

<script type="text/javascript">

</script>
 