<?php

include 'config.php';
session_start();

if (isset($_POST['submit'])) {

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, md5($_POST['password']));

	$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

	if (mysqli_num_rows($select_users) > 0) {

		$row = mysqli_fetch_assoc($select_users);
        $is_validate=$row['is_validate'];
        $checked=$row['checked'];

		$_SESSION['user_name'] = $row['name'];
		$_SESSION['user_email'] = $row['email'];
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['user_type'] = $row['user_type'];
		$_SESSION['user_dept'] = $row['department'];
		$_SESSION['user_batch'] = $row['batch'];
		$_SESSION['user_image'] = $row['user_image']; 
		$_SESSION['user_session'] = $row['session'];
		$_SESSION['is_login']=1;


        $user_type=$_SESSION['user_type'];
		$user_id=$_SESSION['user_id'];

		if($is_validate==1){
		
			if($checked==1){
			if($user_type=="student"){
				header('location:../student/userprofile.php'); 

			}else{
				$select_admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE alumni_id = '$user_id'") or die('query failed');
				if (mysqli_num_rows($select_admin) > 0)
				{
					$_SESSION['user_type']="admin";
					header('location:../alumni/alumnijobpost.php'); 
				}
				else{
					header('location:../alumni/alumnijobpost.php'); 
				}
				 
			} 
		} else{
			echo '<script>alert("Sorry not yet varified from Your Departmnet admin")</script>';

		} 
     	}else{
			$message[] = 'User not varified first create a varified account!';
		}
	} else {
		$message[] = 'Incorrect email or password!';
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
 <?php include "linkheader.php";
 ?>
<style>
	   .joinedimg {
    width: 28px;
    max-width: 100%;
    margin: auto;
    vertical-align: middle;
  }
  
</style>	
	 
</head>

<body style=" background-color:#0e4291">
	<!-- ---------------------------------------------Error msg------------------------------------ -->
	<?php
	if (isset($message)) {
		foreach ($message as $message) {
			echo '
      <div class="message"> 
         <i  class="fa-solid fa-xmark" style="font-size:20px" onclick="this.parentElement.remove();"></i>
         <span>' . $message . '</span>
      </div>
      ';
		}
	}
	?>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-3">
						<img src="../images//nstu.png" alt="logo" width="80">
						<h1 class="fs-4 card-title text-light fw-bold mb-4">NSTU Alumni</h1>
					</div>
					<div class="card shadow-lg">
						<div class="card-body px-5 pt-4 pb-3">
							<h1 class="fs-4 card-title fw-bold mb-4 text-center">Login</h1>
							<form action="" method="post" name="form" class="loginform" novalidate="" autocomplete="on">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Nstu email Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-2">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<div class="d-flex align-items-center">
									<div class="form-check"> 
									<a class="" href="../assets/allhome.php" id="profilebutton">
									<img src="../images/home.jpg" class="joinedimg" alt="logo" /> </a> 
									</a>
									</div>
									<a href="../assets/fogetpass.php" class="float-end ms-auto forgot">
										Forgot Password?
									</a>
								</div>
								<div id="login-div">
									<button type="submit" name="submit" class="btn btn-sm btn-primary mt-2" id="login-button">
										Login
									</button>
								</div>

							</form>
						</div>
						<div class="card-footer py-2">
							<div class="text-center no-account">
								Don't have an account? <a href="./register.php" class="create-account">Create account</a>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</section>
</body>

</html>