<?php
function setSession($name,$department,$batch,$image){
        $_SESSION['user_name'] =  $name;
		$_SESSION['user_dept'] =  $department ;
		$_SESSION['user_batch'] =  $batch ;
		$_SESSION['user_image'] =  $image;     
}

include '../assets//config.php';
$user_name=$_SESSION['user_name'];  
$user_dept=$_SESSION['user_dept'];
$user_batch=$_SESSION['user_batch'];
$user_image=$_SESSION['user_image'];

if (isset($_POST['submit'])) {
$name = mysqli_real_escape_string($conn, $_POST['name']); 
$department = mysqli_real_escape_string($conn, $_POST['dept_name']); 
$batch = mysqli_real_escape_string($conn, $_POST['batch']); 
if($user_type!="student"){
    $bio = mysqli_real_escape_string($conn, $_POST['bio']); 
    $company = mysqli_real_escape_string($conn, $_POST['company']); 
    $current_work = mysqli_real_escape_string($conn, $_POST['current_work']);
    $past_work = mysqli_real_escape_string($conn, $_POST['past_work']);  
    $graduation_year = mysqli_real_escape_string($conn, $_POST['graduation_year']); 
    $scl = mysqli_real_escape_string($conn, $_POST['scl']);
    $clg = mysqli_real_escape_string($conn, $_POST['clg']); 
}
  



if($_FILES['image']['name']!=null){

$image = $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = '../images//'. $image;

if ($image_size > 3145728) {
    $message[] =  'Image size is too large ,please provide new picture less than 3MB';

} else{ 
    move_uploaded_file($image_tmp_name, $image_folder); 
    mysqli_query($conn, "UPDATE `users` SET name = '$name', department='$department', batch='$batch' ,user_image='$image'  WHERE user_id= '$user_id'") or die('query failed'); 
    setSession($name,$department,$batch,$image); 

    if($user_type!="student"){
        mysqli_query($conn, "UPDATE `alumni` SET scl = '$scl', clg='$clg', graduation_year='$graduation_year' ,current_work='$current_work',company='$company' ,bio='$bio' ,past_work='$past_work'  WHERE user_id= '$user_id'") or die('query failed'); 
    } 
    echo
        "lol
        <script> 
          document.location.href = '../student/userprofile.php';
        </script>
        ";
   
     
}
}
else { 
    $image=$user_image;
    mysqli_query($conn, "UPDATE `users` SET name = '$name', department='$department', batch='$batch' ,user_image='$image'  WHERE user_id= '$user_id'") or die('query failed');
    setSession($name,$department,$batch,$image); 
    if($user_type!="student"){
        mysqli_query($conn, "UPDATE `alumni` SET scl = '$scl', clg='$clg', graduation_year='$graduation_year' ,current_work='$current_work',company='$company' ,bio='$bio' ,past_work='$past_work'  WHERE user_id= '$user_id'") or die('query failed'); 
    } 
    echo
        "lol
        <script> 
          document.location.href = '../student/userprofile.php';
        </script>
        ";
}

 }
//-----------------------------------------------------------for editing alumni carrieer--------------------------------------
 if(isset(($_GET['user_id']))){  
    $alumni_id=$_GET['user_id']; 
    $alumni=mysqli_query($conn, "SELECT * FROM `alumni` WHERE user_id='$alumni_id'") or die('query failed');
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
?>

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


<section>
    <div class="container">
         <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="https://www.bootdey.com/snippets/view/bs5-edit-profile-account-details" target="__blank">Edit profile</a>
        
    </nav>
    <hr class="mt-0 mb-4">
        <div class="row d-flex justify-content-center align-items-center" style="margin-top:10%">
  ;          <div class="col-sm-7">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body px-5 py-3">
                        <div class="">
                            <h2 class="text-center fw-bold mb-5 mx-1 mt-4">Edit Profile</h2>
                            <form class="mx-1"  action="" method="post" name="postform" enctype="multipart/form-data">
                                <div class="row pb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label mb-0 pt-1" for="form3Example1c">Full Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" id="form3Example1c" value="<?php echo $user_name; ?>" class="form-control" />
                                    </div>
                                </div> 
                                <div class="row pb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label mb-0 pt-1" for="form3Example1c">Department</label>
                                    </div>
                                    <div class="col-sm-9"> 
                                        <select name="dept_name" class="mb-3" id="type-option">
                                        <option value="<?php echo $user_dept; ?>"><?php echo $user_dept; ?></option>
										<option value="ACCE">ACCE</option>
										<option value="Agriculture">Agriculture</option>
										<option value="Applied Math">Applied Math</option>
										<option value="Bangla">Bangla</option>
										<option value="BGE">BGE</option>
										<option value="Biochemistry">Biochemistry</option>
										<option value="BMS">BMS</option>
										<option value="Business Administration">Business Administration</option>
										<option value="CSTE">CSTE</option>
										<option value="Economics">Economics</option>
										<option value="Education">Education</option>
										<option value="Educational Administration">Educational Administration</option>
										<option value="EEE">EEE</option>
										<option value="English">English</option>
										<option value="ESDM">ESDM</option>
										<option value="FIMS">FIMS</option>
										<option value="FTNS">FTNS</option>
										<option value="ICE">ICE</option>
										<option value="IIS">IIS</option>
										<option value="IIT">IIT</option>
										<option value="Law">Law</option>
										<option value="Microbiology">Microbiology</option>
										<option value="MIS">MIS</option>
										<option value="Oceanography">Oceanography</option>
										<option value="Pharmacy">Pharmacy</option>
										<option value="Social Work">Social Work</option>
										<option value="Sociology">Sociology</option>
										<option value="Statistics">Statistics</option>
										<option value="THM">THM</option>
										<option value="Zoology">Zoology</option>
									</select>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label mb-0 pt-1" for="form3Example1c">Batch</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="batch" id="form3Example1c" value="<?php echo  $user_batch; ?>"  class="form-control" />
                                    </div>
                                </div> 
                                <div class="row pb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label mb-0 pt-1" for="form3Example1c">Profile Picture</label>
                                    </div>
                                    <div class="col-sm-9">
                                    <input class="form-control" type="file" accept="image/jpg, image/jpeg, image/png"   name="image">
                                    </div>
                                   <hr>
                                </div>

                                        <?php if($user_type!="student"){ ?>
                                       
                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">Bio</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="bio" id="form3Example1c" value="<?php echo  $bio; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">Company</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="company" id="form3Example1c" value="<?php echo  $company; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">Current Work</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="current_work" id="form3Example1c" value="<?php echo  $current_work; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">Past Work</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="past_work" id="form3Example1c" value="<?php echo  $past_work; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">Graduation Year</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="graduation_year" id="form3Example1c" value="<?php echo  $graduation_year; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">School</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="scl" id="form3Example1c" value="<?php echo  $scl; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                         <div class="row pb-3">
                                             <div class="col-sm-3">
                                                 <label class="form-label mb-0 pt-1" for="form3Example1c">College</label>
                                             </div>
                                             <div class="col-sm-9">
                                                <input type="text" name="clg" id="form3Example1c" value="<?php echo  $clg; ?>"  class="form-control" />
                                             </div>
                                         </div>

                                       <?php }?>
                                 
                                <div class="d-flex justify-content-end  mb-3 ">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>