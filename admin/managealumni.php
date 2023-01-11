<?php

include '../assets//config.php'; 
$isclicked=false; 
$mydepartment=$_SESSION['user_dept'] ;
$user_type=$_SESSION['user_type']  ;  

if(isset($_POST['submit'])){
    $isclicked=true;

    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    if($user_name ==null){ 
        echo '<script>alert("Must provide a valid search key")</script>'; 
        $isclicked=false;
        
    }  
}  
//-----------------------------------------chosing from action to sort the list of forum------------------------------------
if(isset(($_GET['department']))){
    $department=$_GET['department'];   
}else{
    $department="$mydepartment"; 
}
//-----------------------------------------------------------------------------------------------------------------------------

//------------------------------------------- selection batch for sort by batch---------------------------------------
if(isset($_POST['batchsubmit'])){
    $department=$_POST['department']; 
    $gbatch=$_POST['batch'];   
}else{
    $gbatch="0"; 
}
//----------------------------------------------------------------admin control saection---------------------------
if(isset(($_GET['dalumni_id']))){ 
    $dalumni_id=$_GET['dalumni_id'];
    $department=$_GET['department']; 
    $gbatch=$_GET['gbatch'];
    mysqli_query($conn, "DELETE FROM `users` WHERE user_id ='$dalumni_id'") or die('query failed');
} 

if(isset(($_GET['makeadmin']))){ 
    $auser_type=$_GET['auser_type'];
    $alumni_id=$_GET['alumni_id'];
    $department=$_GET['department']; 
    $gbatch=$_GET['gbatch']; 
    if($auser_type!="admin"){  
        mysqli_query($conn,"INSERT INTO `admin`(alumni_id,admin_dept,admin_position) VALUES('$alumni_id', '$department', 'admin')")or die('query failed'); 
        mysqli_query($conn, "UPDATE `users`  SET user_type = 'admin'  WHERE user_id = '$alumni_id' ") or die('query failed');
        header('location:adminmanagealumni.php');
    } 
    header('location:adminmanagealumni.php');

}
if(isset(($_GET['makemember']))){  
    $auser_type=$_GET['auser_type'];
    $alumni_id=$_GET['alumni_id'];
    $department=$_GET['department']; 
    $gbatch=$_GET['gbatch']; 
    if($auser_type=="admin"){  
        mysqli_query($conn, "DELETE FROM `admin` WHERE alumni_id ='$alumni_id'") or die('query failed');
        mysqli_query($conn, "UPDATE `users`  SET user_type = 'alumni'  WHERE user_id = '$alumni_id' ") or die('query failed');
        header('location:adminmanagealumni.php');
    } 
    header('location:adminmanagealumni.php');

}
//--------------------------------------------------------------------------------------------------------------------

 
//---------------------------------------------for tittle header of dept batch-----------------------------------------------------------
function tittleheader($department,$gbatch){?>
    <div class="inner-main-header d-flex  justify-content-center">
        <?php if($gbatch!="0"){ ?>
                    <h3> Alumni of <?php echo $department; ?></h3><span class="text-muted"> Batch(<?php echo $gbatch; ?>)</span> 
                  </div>
        <?php }else{ ?>
            <h3> Alumni of <?php echo $department; ?></h3><span class="text-muted ">-ALl Batch</span> 
                  </div>
         <?php }}
     
//-------------------------------------------------for basic card body-----------------------------------------------------------
function  forumcardbody($user_id,$auser_id,$bio,$user_name,$user_image,$department,$batch,$mydepartment, $user_type,  $gbatch,$auser_type){ if($auser_id!=$user_id){?>
 <div class="card mb-2">
                    <div class="card-body p-2 p-sm-3">

                    <div class="d-flex flex-start  ">
                            <img class="rounded-circle shadow-1-strong me-3" src="../images//<?php echo $user_image; ?>" alt="avatar" width="90" height="90" /> 
                            <div>
                                <h6 class="fw-bold   mb-1"><?php echo $user_name; ?></h6>

                                     <?php if($department==$mydepartment &&  $auser_type=="admin"){?>
                                          <span class="text-muted small mb-0 ms-1">( <?php echo  $auser_type; ?>)</span>
                                     <?php } ?>

                                <span class="text-muted small mb-0"> <?php echo  $department; ?></span><span class="text-muted small mb-0">><?php echo  $batch; ?> batch</span>
                            </div>


                            <div class="ms-auto d-flex">
                                <?php  if($department==$mydepartment &&  $user_type=="admin"){?>
 
                                <div>
                                   <a  class="dropdown-toggle d-flex align-items-center hidden-arrow"href="#"id="navbarDropdownMenuAvatar"role="button"data-bs-toggle="dropdown"  aria-expanded="false"> <i class="fas fa-pencil-alt"></i></a> 
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar" >
                                       <li>
                                           <a class="dropdown-item" href="adminmanagealumni.php? makeadmin=1  && alumni_id=<?php echo  $auser_id ?> && department= <?php echo  $department ?> && gbatch=<?php echo  $gbatch ?> &&
                                           auser_type=<?php echo  $auser_type ?> ">Make Admin</a>
                                       </li>
                         
                                        <li>
                                            <a class="dropdown-item" href="adminmanagealumni.php? makemember=1  &&  alumni_id=<?php echo  $auser_id ?> && department= <?php echo  $department ?> && gbatch=<?php echo  $gbatch ?>  &&
                                           auser_type=<?php echo  $auser_type ?> ">Make Member</a>
                                        </li>
                                   </ul>
                                </div>

                                <div class="ms-5">
                                  <a href="adminmanagealumni.php?  dalumni_id=<?php echo  $auser_id ?> && department= <?php echo  $department ?> && gbatch=<?php echo  $gbatch ?>  " class="text-danger" data-original-title="Delete"><i class="far fa-trash-alt"></i></a>
                                </div> 
                             
                          
                    <?php }?> 

                            </div>
                    </div>

                     <div class="media-body">
                                <a  href="../student/userprofile.php?check_profile=1 && alumni_id=<?php echo $auser_id; ?>  " class=" text-muted small mb-0">    Check Profile</a></h6>
                                <p class="text-secondary">
                                    <?php echo  $bio; ?>
                                </p> 
                     </div> 
                         
                    </div> 

 </div>

<?php }}
//---------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------for sort based query for forum sorting----------------------------------------
function forumBasedOnSort($alumni,$conn,$user_id,$mydepartment, $user_type,  $gbatch){  
     if(mysqli_num_rows($alumni) > 0){
    while($row = mysqli_fetch_assoc($alumni)){
        $auser_id= $row['user_id']; 
        $bio=$row['bio']; 
        $user=mysqli_query($conn, "SELECT * FROM `users` WHERE user_id='$auser_id'") or die('query failed');
        if(mysqli_num_rows($user) > 0){
            $rowc= mysqli_fetch_assoc($user);
            $user_name=$rowc['name'];
            $user_image=$rowc['user_image'];
            $department=$rowc['department'];
            $batch=$rowc['batch']; 
            $auser_type=$rowc['user_type'];
             
        } 
        forumcardbody($user_id,$auser_id,$bio,$user_name,$user_image,$department,$batch,$mydepartment, $user_type,  $gbatch,$auser_type);
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
               <a href="adminmanagealumni.php?department=<?php echo $mydepartment; ?>">  <button class="btn btn-primary has-icon btn-block" type="button"  >   
               My Alumni of <?php echo $mydepartment; ?>
                </button> </a>
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
                                        
                                        <?php include '../admin/alldept.php';?>

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
            <form class="d-flex me-auto" method="post" action="../admin/adminmanagealumni.php">
            <button class="btn btn-sm  " type="submit" name="batchsubmit">Search Batch</button>
              
                <select class="custom-select custom-select-sm ms-2" name="batch"   > 
                    <option value="0">All Batch</option>  
                    <option value="1">1</option>  
                    <option value="2">2</option>
                    <option value="3">3</option>  
                    <option value="4">4</option>
                    <option value="5">5</option>  
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">3</option>  
                    <option value="10">4</option>
                    <option value="11">11</option>  
                    <option value="12">12</option>
                    <option value="13">13</option></form>
                    <option value="14">14</option>
                </select> 
                <input type="text" name="department" class="form-control" value="<?php echo  $department; ?>" style="display:none;"> 
            </form>
             
            <form action="adminmanagealumni.php" class="d-flex" method="post">
                <span class="input-icon input-icon-sm ml-auto  ">
                    <input type="text" name="user_name" class="form-control form-control-sm bg-gray-200 border-gray-200 shadow-none mb-4 mt-4 flex-shrink-1 " placeholder="Search forum" />
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

             $alumni = mysqli_query($conn, " SELECT alumni.user_id,alumni.bio FROM alumni  JOIN users ON alumni.user_id=users.user_id WHERE users.name LIKE'%$user_name%' AND users.user_type='alumni' OR users.user_type='admin'") or die('query failed'); 
             
             if(mysqli_num_rows($alumni) > 0){
                 forumBasedOnSort( $alumni,$conn,$user_id,$mydepartment, $user_type,$gbatch); 
        
        }else{
         echo ' <div class="heading">
         <div class="mt-3 bg-light text-center" >
             <h2>No Alumni Of such name</h2>
    </div>
    </div>';
      }
    
   //-------------------------------end of searching result shown---------------------------
    
//------------------------------------------if no searching ---------------------------------

}else{  

     
        if($gbatch=="0"){ 
            tittleheader($department,$gbatch); 
            $alumni = mysqli_query($conn, " SELECT alumni.user_id,alumni.bio FROM alumni  JOIN users ON alumni.user_id=users.user_id WHERE users.department='$department' AND users.user_type='alumni' OR users.user_type='admin'  ORDER BY users.batch DESC ") or die('query failed');
            forumBasedOnSort( $alumni,$conn,$user_id,$mydepartment, $user_type,$gbatch); 
        }else{  
            tittleheader($department,$gbatch); 
            $alumni = mysqli_query($conn, " SELECT alumni.user_id,alumni.bio FROM alumni  JOIN users ON alumni.user_id=users.user_id WHERE users.department='$department' AND users.batch=$gbatch AND users.user_type='alumni' OR users.user_type='admin' ORDER BY user_id DESC ") or die('query failed');
        forumBasedOnSort( $alumni,$conn,$user_id,$mydepartment, $user_type,$gbatch); 
    } 
     
    

    }?>
  
 

            <!-- /Inner main body -->
        </div>
        <!-- /Inner main -->
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
 