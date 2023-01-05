<?php

include 'config.php'; 
if(isset($_POST['submit'])){
	 
    $checkpass=$_POST['password'];
	$password = mysqli_real_escape_string($conn, md5($_POST['password']));
	$password_confirm= mysqli_real_escape_string($conn, md5($_POST['password_confirm'])); 

	 
 
	if ($password==$password_confirm) { 
		
	$number = preg_match('@[0-9]@', $checkpass);
	$uppercase = preg_match('@[A-Z]@', $checkpass);
	$lowercase = preg_match('@[a-z]@', $checkpass);
	$specialChars = preg_match('@[^\w]@', $checkpass);
		
		 if(strlen($checkpass) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars){ 
			$message[] = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
	
		}else{
		mysqli_query($conn, "UPDATE `users` SET password='$password_confirm' WHERE user_id='$user_id'") or die('query failed');
		echo
    "
    <script>
    document.location.href = '../assets/logout.php';
    </script>
    ";
		}

   }else{
	  $message[] = 'Do not match';
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
	<section class="h-100">
		<div class="container h-100">
		<nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="https://www.bootdey.com/snippets/view/bs5-edit-profile-account-details" target="__blank">Change Password</a>
        
    </nav>
    <hr class="mt-0 mb-4">
			<div class="row justify-content-sm-center h-100 mt-5" >
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
 
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Change Password</h1>
							<form method="POST" action="" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="password">New Password</label>
									<input id="password" type="password" class="form-control" name="password" value="" required autofocus>
									<div class="invalid-feedback">
										Password is required	
									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="password-confirm">Confirm Password</label>
									<input id="password-confirm" type="password" class="form-control" name="password_confirm" required>
								    <div class="invalid-feedback">
										Please confirm your new password
							    	</div>
								</div>

								<div class="d-flex align-items-center">
								 
									<button type="submit" name="submit" class="btn btn-primary ms-auto">
										Reset Password	
									</button>
								</div>
							</form>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</section>

 