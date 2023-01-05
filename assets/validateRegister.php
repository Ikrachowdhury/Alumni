<?php

include 'config.php'; 

if (isset($_POST['submit'])) {

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$validate = $_POST['validate'];

	$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

	if (mysqli_num_rows($select_users) > 0) {
        while($row = mysqli_fetch_assoc($select_users)){
            $random_code=$row['v_code'];
            $user_id=$row['user_id'];
        }

        if($validate==$random_code){
            mysqli_query($conn, "UPDATE `users` SET is_validate = '1' WHERE user_id = '$user_id'") or die('query failed');
            header('location:login.php');
        }
        else{
            $message[] = 'Incorrect Code';
        }

	} else {
		$message[] = 'Incorrect email ';
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include "linkheader.php";
 ?>
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
						<img src="../images//user.png" alt="logo" width="80">
						<h1 class="fs-4 card-title fw-bold mb-4 text-light"> Email varification</h1>
					</div>
					<div class="card shadow-lg">
						<div class="card-body px-5 pt-4 pb-3">
							<h1 class="fs-4 card-title fw-bold mb-4 text-center">Email Validation</h1>
							<form action="" method="post" name="form" class="loginform" novalidate="" autocomplete="on">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Email Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-2">
									<div class="mb-2 w-100">
										<label class="text-muted" for="validate">Enter validation code</label>
									</div>
									<input id="validate" type="text" class="form-control" name="validate" required>
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								
								<div id="login-div">
									<button type="submit" name="submit" class="btn btn-sm btn-primary mt-2" id="login-button">
										Submit
									</button>
								</div>

							</form>
						</div>
						
					</div> 
				</div>
			</div>
		</div>
	</section>
</body>

</html>