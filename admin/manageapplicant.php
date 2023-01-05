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
<nav class="nav nav-borders mt-3">
        <a class="nav-link active ms-0" href="https://www.bootdey.com/snippets/view/bs5-edit-profile-account-details" target="__blank">Alumus Join Request</a>
        
    </nav>
    <hr class="mt-0 mb-4">
<?php

include '../assets//config.php'; 

    
$applicant = mysqli_query($conn, "SELECT * FROM `users`  WHERE checked='0'") or die('query failed');

if (mysqli_num_rows($applicant) > 0) { 


?>
 
<!-- ---------------------------------------member  table starts--------------------------------------------- -->
<div class="container mt-5 mb-4">
 
<div class="col-lg-12 mt-4 mt-lg-0">
    <div class="row">
      <div class="col-md-12">
        <div class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
          <table class="table manage-candidates-top mb-0">
            <h2>All Application</h2> 
            <thead>
              <tr>
                <th></th>
                <th class="text-center">Department</th>
                <th class="text-center">Email</th>
                <th class="text-center">Session</th>
                <th class="action text-right">Batch</th>
                <th class="action text-right">Phone Number</th>
              </tr>
            </thead>
            <tbody> 

<?php
 
//------------------------------------gets all member-------------------------------------------------
 

while ($row = mysqli_fetch_assoc($applicant)) { 
                $userm_id=$row['user_id'];
                $user_name=$row['name']; 
                $user_image=$row['user_image'];
                $user_dept=$row['department'];
                $user_session=$row['session'];
                $user_batch=$row['batch'];
                $user_number=$row['number'];
                $user_mail=$row['email'];
                 
            
            include "applicanttable.php";

} 
?> 


</tbody>
 


 </table>
</div>
</div>

</div>
</div>
</div>

<?php
}else{
  echo " <hr> 
  <h3 class='text-center text-mute'> No Applicant</h3>  ";
}

?>  
  