<?php

include '../assets/config.php';
if (isset($_POST['submit'])) {
  
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']); 
    $job_tittle = mysqli_real_escape_string($conn, $_POST['job_tittle']); 
    $job_company = mysqli_real_escape_string($conn, $_POST['job_company']); 
    $job_location = mysqli_real_escape_string($conn, $_POST['job_location']); 
    
     
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../images//' . $image;
 
    
    $post_time = date("m.d.Y"); 

    if ($image_size > 3145728) {
        $message[] =  'Image size is too large ,please provide new picture less than 3MB';
    
    
    }  else {
        move_uploaded_file($image_tmp_name, $image_folder);
        $create_post = mysqli_query($conn, "INSERT INTO `job`(user_id,job_tittle,job_company,job_location,job_description,job_image,post_time) VALUES('$user_id', '$job_tittle', '$job_company','$job_location','$job_description', '$image', '$post_time')") or die('query failed');
        $message[] =  'Post created successfully!';
    }
}
//-------------------------------delete post wor-------------------------
if(isset(($_GET['djob_id']))){ 
    $djob_id=$_GET['djob_id'];
    mysqli_query($conn, "DELETE FROM `job` WHERE job_id ='$djob_id'") or die('query failed');
}


?>
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

<div class="container">
    
        <!-- <div class="row " style="margin-top: 80px;"> 
            <div class="col-md-6">
                <div class="d-flex mb-2">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary " type="submit">Search</button>
                </div>

            </div> -->

        <?php 
        if($user_type!="student"){?>
        <div class="row " style="margin-top: 80px;"> 
        <div class="col-md-12 text-center">
        <!-- <div class="col-md-6 d-flex flex-row-reverse"> -->
                <button type="button" class="btn btn-primary btn-sm  " data-bs-toggle="modal" data-bs-target="#myModal">+Post a Job Opportunity</button>
            </div> 
        </div>

        <?php
         }else{?>
           <div class="row " style="margin-top: 80px;"></div>
        <?php }
        ?>
           
<!-- -------------------------------------job card------------------------------------------ -->

<?php
     $job = mysqli_query($conn, "SELECT * FROM `job` ORDER BY job_id DESC") or die('query failed');
     if(mysqli_num_rows($job) > 0){ 
        $cardnumber=0;
        while($row = mysqli_fetch_assoc($job)){
            $job_id=$row['job_id'];
            $job_description=$row['job_description'];
            $job_tittle=$row['job_tittle'];
            $job_location=$row['job_location']; 
            $job_company=$row['job_company']; 
            $job_image=$row['job_image']; 
            $post_time=$row['post_time'];
            $puser_id=$row['user_id'];

            $puser = mysqli_query($conn, "SELECT name FROM `users` WHERE user_id='$puser_id'") or die('query failed');
            if(mysqli_num_rows($puser) > 0){
                $rowc= mysqli_fetch_assoc($puser);
                $user_name=$rowc['name']; 
                 
            }  ?>

    <div class="card mt-3 mb-3" id="jobcard" style="border: 1px solid grey;">
     <?php  if($user_type!="student"&&  $puser_id==$user_id){?>
            <div class="card-header d-flex flex-row-reverse">
            <a href="alljobpost.php?  djob_id=<?php echo $job_id; ?>  " class="text-danger" data-original-title="Delete"><i class="far fa-trash-alt"></i></a>
            </div>
    <?php }?>

            <div class="card-body">
                <h5 class="card-title text-center"><?php echo $job_tittle; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted text-center mt-1"><i class="fa-solid fa-building"></i> <?php echo $job_company; ?> <i class="fa-solid fa-location-dot"></i> <?php echo $job_location; ?></h6>
                <hr>
                <p class="card-text" style="text-align: justify;"><?php echo $job_description; ?></p>

                <div class="d-flex justify-content-between">
                    <h6>Posted By: <?php echo $user_name ."::". $post_time;; ?></h6>  

                    <button class="btn btn-primary btn-sm " data-bs-toggle="collapse" data-bs-target="#card<?php echo $cardnumber; ?>" aria-expanded="false" aria-controls="collapseOne">Read More</button>
                </div>
                 
                <div id="card<?php echo $cardnumber; ?>" class="collapse"  data-bs-parent="#jobcard">
                <hr>
      <div class="card-body text-center">  
                        <?php if($job_image!=null) {?>
                            <img class="py-3" src="../images//<?php echo  $job_image; ?>" width="50%" height="auto" />
                            <?php }
                            else{?> 
                             <h6 class="text-muted"> !No more info is provided</h6>
                           <?php } ?>
                         
      </div>
    </div>  

            </div>
        </div> 

<?php
     $cardnumber++;   }
     }
 
 ?>
          
 
     <!-- ------------------------------------------------------------------------------------------->

<!-- --------------------------------------------------create job hover area-------------- ------------------------------------>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="tittle" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
      <div class="modal-header"> 
      <h3  class="modal-title " id="tittle"><i class="fa-solid fa-pencil"></i> Create Job</h3> 
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
                        <input id="name" type="text" class="form-control" name="job_tittle" value="" required autofocus>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label   class="mb-2"><b>Company:</b> <sup class="star-color">*</sup></label>
                        <input id="name" type="text" class="form-control" name="job_company" value="" required autofocus>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label   class="mb-2"><b>Location:</b> <sup class="star-color">*</sup></label>
                        <input id="name" type="text" class="form-control" name="job_location" value="" required autofocus>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="post_caption" class="mb-2"><b>Description:</b> <sup class="star-color">*</sup></label>
                        <textarea name="job_description" class="form-control form-control-lg mb-4" rows="4"></textarea>
                    </div>
                    <div class="col-sm-12 form-group mb-3">
                        <label for="photo" class="mb-2"><b>Photo:</b></label>
                        <input class="form-control" type="file" accept="image/jpg, image/jpeg, image/png" name="image">
                    </div>
                    
                    <div class="align-items-center d-flex">
                        <button type="submit" name="submit" class="btn btn-sm btn-primary ms-auto"><i class="fas fa-check"></i> Post</button>
                    </div>

                </form>
          
    </div>
    </div>
    </div>
</div>
    <!-- ---------------------------------------------------------------- -->
    </div>


