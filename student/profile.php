 <?php
    include '../assets//config.php';
   
    if(isset(($_GET['check_profile']))){  
        $auser_id=$_GET['alumni_id']; 
        $alumni=mysqli_query($conn, "SELECT * FROM `alumni` WHERE user_id='$auser_id'") or die('query failed');
        if(mysqli_num_rows($alumni) > 0){
            while($row = mysqli_fetch_assoc($alumni)){ 
                $bio=$row['bio'];  
                $scl=$row['scl']; 
                $clg=$row['clg']; 
                $graduation_year=$row['graduation_year']; 
                $current_work=$row['current_work']; 
                $company=$row['company']; 
                $past_work=$row['past_work']; 
                $user=mysqli_query($conn, "SELECT * FROM `users` WHERE user_id='$auser_id'") or die('query failed');
                if(mysqli_num_rows($user) > 0){
                    $rowc= mysqli_fetch_assoc($user);
                    $auser_name=$rowc['name'];
                    $auser_image=$rowc['user_image'];
                    $auser_dept=$rowc['department'];
                    $auser_batch=$rowc['batch']; 
                    $auser_email=$rowc['email'];
                    $auser_type=$rowc['user_type'];
                     
                }  
                
         }
        }

        if($auser_type!="student"){ 
            $alumni=mysqli_query($conn, "SELECT * FROM `alumni` WHERE user_id='$auser_id'") or die('query failed');
            if(mysqli_num_rows($alumni) > 0){
                while($row = mysqli_fetch_assoc($alumni)){ 
                    $bio=$row['bio'];  
                    $scl=$row['scl']; 
                    $clg=$row['clg']; 
                    $graduation_year=$row['graduation_year']; 
                    $current_work=$row['current_work']; 
                    $company=$row['company']; 
                    $past_work=$row['past_work']; 
                    
             }
            }
            }
    
    }else{
        $user=mysqli_query($conn, "SELECT * FROM `users` WHERE user_id='$user_id'") or die('query failed');
        if(mysqli_num_rows($user) > 0){
            $rowc= mysqli_fetch_assoc($user);
            $auser_id=$rowc['user_id'];
            $auser_name=$rowc['name'];
            $auser_image=$rowc['user_image'];
            $auser_dept=$rowc['department'];
            $auser_batch=$rowc['batch']; 
            $auser_email=$rowc['email'];
            $auser_type=$rowc['user_type'];
             
        }  
if($auser_type!="student"){ 
$alumni=mysqli_query($conn, "SELECT * FROM `alumni` WHERE user_id='$auser_id'") or die('query failed');
if(mysqli_num_rows($alumni) > 0){
    while($row = mysqli_fetch_assoc($alumni)){ 
        $bio=$row['bio'];  
        $scl=$row['scl']; 
        $clg=$row['clg']; 
        $graduation_year=$row['graduation_year']; 
        $current_work=$row['current_work']; 
        $company=$row['company']; 
        $past_work=$row['past_work']; 
        
 }
}
}
    }
   
    ?>
 <style>
     .mainsection {
         padding-left: 0rem;
         padding-top: 9rem;
     }
 </style>
 <div class="container">
     <!-- Account page navigation-->
     <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="https://www.bootdey.com/snippets/view/bs5-edit-profile-account-details" target="__blank">Profile</a>
        
    </nav>
    <hr class="mt-0 mb-4">
     <div class="main-body">
         <div class="row gutters-sm">
             <div class="col-md-5 mb-3">
                 <div class="card">
                     <div class="card-body">
                         <div class="d-flex flex-column align-items-center text-center mt-4 mb-4 pt-1">
                             <img src="../images//<?php echo $auser_image;?>" alt="Admin" class="rounded-circle" width="150">
                             <div class="mt-3">
                                 <h4> <?php echo $auser_name; ?></h4>
                             </div> 
                             <div class="col-sm-4 text-secondary">
                             <?php if( $auser_id==$user_id){ ?>  
                                <a href="../assets/userchangepass.php" style="text-decoration: none;">Change Password</a> 
                                 <hr> 
                           <?php }?>  
                                 <hr>  
                             </div> 
                             <?php if($auser_type!="student"){ ?>
                                
                                <h6 class="text-muted-sm"> <?php echo $bio; ?></h6>

                                <?php }?>
                             <div>
                             
                             </div>

                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-md-7" style="padding-top: 1px;">
                 <div class="card mb-3">
                     <div class="card-body">
                     <div class="row"> 
                             <div class="col-sm-9 text-secondary">
                                  About
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Full Name</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $auser_name; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Email</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $auser_email; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Department</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $auser_dept; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Batch</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $auser_batch; ?>
                             </div>
                         </div> 
                         <hr>   
                         
                         <div class="d-flex justify-content-end">
                         <?php if($user_type=="student" && $auser_id==$user_id){ ?>
                                 
                                <a href="usereditprofile.php" style="text-decoration: none;">Edit Profile</a> 

                         <?php }?> 

                         </div>

                     </div>
                 </div>
             </div>

<!-- ----------------------------------------------carrier------------------------------ -->
<?php if($auser_type!="student"){ ?>
             <div class="row col-md-12" >
                 <div class="card mb-3">
                     <div class="card-body">
                     <div class="row"> 
                             <div class="col-sm-9 text-secondary">
                                  Carrier
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Currently working as</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                             <?php echo $current_work; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Company</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $company; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Past Work</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $past_work; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">Graduation Year</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $graduation_year; ?>
                             </div>
                         </div> 
                         <hr> 
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">School</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $scl; ?>
                             </div>
                         </div>
                         <hr>
                         <div class="row">
                             <div class="col-sm-3">
                                 <h6 class="mb-0">College</h6>
                             </div>
                             <div class="col-sm-9 text-secondary">
                                 <?php echo $clg; ?>
                             </div>
                         </div>
                         <hr>

                         <div class="d-flex justify-content-end">
                             <?php if($auser_id==$user_id){ ?>
                                    <a href="usereditprofile.php?user_id=<?php echo $user_id; ?>" style="text-decoration: none;">Edit Profile</a>
                             <?php }?> 
                           
                         </div>

                     </div>
                 </div>
             </div>

<?php } ?>
         </div>
      
     </div>
 </div>