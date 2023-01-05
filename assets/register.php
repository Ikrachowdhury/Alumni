<?php

include 'config.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  
  function sendMail($email,$v_code){
      require ("phpMailer/Exception.php");
      require ("phpMailer/PHPMailer.php");
      require ("phpMailer/SMTP.php");

      $mail= new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;  		//Enable SMTP authentication
        $mail->Username   = 'andrewsmith105086@gmail.com';                     //SMTP username
        $mail->Password   = 'tppmkafgklfvdenp';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
		);
        //Recipients
        $mail->setFrom('andrewsmith105086@gmail.com', 'NSTU Allumnus');
        $mail->addAddress($email);     //Add a recipient
	
		
		$mail->From = 'andrewsmith105086@gmail.com';
        $mail->Sender = $email;
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification';
        $mail->Body    = "Thanks for registration!<br>
        Verify your email my entering this code $v_code
        ";
    
        $mail->send();
       return true;
    } catch (Exception $e) {
        return false;
    }

  }


  function insertToDatabae($name,$email,$pass,$user_image,$user_type,$department,$batch,$session,$contact_number,$is_validate,$conn){

	$v_code=bin2hex(random_bytes(4));
	echo "lol";
	 
	$user_query= "INSERT INTO `users`(name, email, password,user_image,user_type,department,batch,session,number,is_validate,v_code,checked) VALUES('$name', '$email', '$pass','$user_image', '$user_type','$department','$batch','$session','$contact_number',0,'$v_code',0)";
 
	$result2=(mysqli_query($conn,$user_query) && sendMail($email,$v_code));
 
  if($result2){
	header('location:validateRegister.php');

  }
  else{
	echo "<script>
	alert('Not Successfully Registered or Check your internet connection');
	 
	</script>";
  }

  }

if (isset($_POST['submit'])) {
	 


	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$checkpass=$_POST['password'];
	$pass = mysqli_real_escape_string($conn, md5($_POST['password']));
	$department = mysqli_real_escape_string($conn, $_POST['dept_name']);
	$user_type = $_POST['user_type'];
	$batch = mysqli_real_escape_string($conn, $_POST['batch']); 
	$session = mysqli_real_escape_string($conn, $_POST['session']); 
	$contact_number = mysqli_real_escape_string($conn, $_POST['number']); 
	$user_image="user.png";

	$number = preg_match('@[0-9]@', $checkpass);
	$uppercase = preg_match('@[A-Z]@', $checkpass);
	$lowercase = preg_match('@[a-z]@', $checkpass);
	$specialChars = preg_match('@[^\w]@', $checkpass);

 
 

	if (!preg_match("/^[a-zA-Z0-9+_.-]+@*[a-zA-Z.]+.nstu.edu.bd+$/i", $email)  && $user_type=="student") {

		$message[] = "Must enter Education mail of the university";
	}
	 else if ($user_type=="alumni" && !preg_match("/^[a-zA-Z0-9+_.-]+@*[a-zA-Z.]+.nstu.edu.bd|.com+$/i", $email) ) {

		$message[] = "Must enter Valid Gmail";
	} 
	 else {
		$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

		if (mysqli_num_rows($select_users) > 0) {
			$row = mysqli_fetch_assoc($select_users);
			$is_validate=$row['is_validate'];
			$user_id=$row['user_id'];
			
			if($is_validate==1){
				$message[] = 'User already exist!';
			}else{
				mysqli_query($conn, "DELETE FROM `users` WHERE  user_id = '$user_id'") or die('query failed');
				insertToDatabae($name,$email,$pass,$user_image,$user_type,$department,$batch,$session,$contact_number,0,$conn);
			}
			 
		}

		else {
		 
			 
			insertToDatabae($name,$email,$pass,$user_image,$user_type,$department,$batch,$session,$contact_number,0,$conn);
		 
		}
	}


}


?>



<!DOCTYPE html>
<html lang="en">

<head>
 <?php include "linkheader.php";
 ?>
	<style>
		.number {
			display: none;
		}
		.joinedimg {
    width: 30px;
    max-width: 100%;
    margin: auto;
    vertical-align: middle;}
	</style>
</head>

<body style=" background-color:#0e4291">
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
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-5 col-xl-6 col-lg-6 col-md-7 col-sm-9">
					<div class="text-center my-3">
						<img src="../images//nstu.png" alt="logo" width="80">
						<h1 class="fs-4 card-title text-light fw-bold mb-4">NSTU Alumni</h1>
					</div>
					<div class="card shadow-lg mb-1">
						<div class="card-body px-5 pt-4 pt-3">
							<h1 class="fs-4 card-title fw-bold mb-3 text-center">Registration</h1>
							<form action="" method="post" class="form" name="form" autocomplete="on">
							<div class="d-flex mb-2">
									<label class="mb-2 text-muted me-3" name="user_type">User: </label>
									<div class="me-3">
										<input type="radio" name="user_type" class="numberradio" onclick="run()" value="student"> Student
									</div>
									<div>
										<input type="radio" name="user_type" class="numberradio" onclick="run()" value="alumni"> Alumni
									</div>

								</div>
								<div class="mb-3 ">
									<label class="mb-2 text-muted" for="name">Name</label>
									<input id="name" type="text" class="form-control" name="name" value="" required autofocus>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Gmail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required>
								</div>

								<div class="mb-4">
									<label class="mb-2 text-muted" for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required>
								</div>

								<div class="dept mb-2">
									<label class=" mb-2 text-muted" for="dept_name">Department</label>
									<select name="dept_name" class="mb-3" id="type-option">
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
								<div class=" mb-1">
									<label class="mb-2 text-muted"> Batch</label>
									<input   id="batchno" type="number" name="batch" required>
								</div>
								<div class=" mb-1">
									<label class="mb-2 text-muted"> Session</label>
									<input   id="session" type="text" name="session" required>
								</div>

							 
								<div class="number mb-1">
									<label class="mb-2 text-muted">Contact number</label>
									<input   id="number" type="number" name="number" required>
								</div>

								<script>
									function run() {
										var gen = document.querySelectorAll(".numberradio");
										gen.forEach((el) => {
											el.checked ? val = el.value : null
										})
										if (val == "alumni") { 
											document.querySelector(".number").style.display = "block";
										} else { 
											document.querySelector("#number").removeAttribute("required");
											document.querySelector(".number").style.display = "none";
									}
								}
								</script>
								 

								<div class="d-flex align-items-center">
								<a class="" href="../assets/allhome.php" id="profilebutton">
									<img src="../images/home.jpg" class="joinedimg" alt="logo" /> </a> 
									</a>
									<button type="submit" name="submit" class="btn btn-sm btn-primary ms-auto">
										Register
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-2">
							<div class="text-center">
								<small>Already have an account? <a href="./login.php" id="login">Login</a></small>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</section>

</body>

</html>