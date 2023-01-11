<?php
$user_image = $_SESSION['user_image'];
$user_type=$_SESSION['user_type'];
?>
 

<style>
  .img {
    width: 80px;
    max-width: 100%;
    margin: auto;
    vertical-align: middle;
  }

  .feedimg {
    width: 19px;
    max-width: 100%;
    margin: auto;
    vertical-align: middle;
  }

  .joinedimg {
    width: 28px;
    max-width: 100%;
    margin: auto;
    vertical-align: middle;
  }

  .link {
    color:aliceblue;
    padding: 0 10px 0 3px;
    text-decoration: none;
  }
  .dropdown-menu {
    max-height: 230px;
    overflow-y: auto;
}
</style>
<!-- ---------------------------------------------------navbar---------------------------------------------------- -->
<nav class="navbar navbar-expand-lg p-2 fixed-top "  style=" background-color:#0e4291">
  <div class="container">
 
      <a href="#" class="navbar-brand text-light logo" style="font-size: 15px ;"><img src="../images//nstu.png" alt="user icon" style="width:25px;border-radius:50%;" /> NSTU Allumni</a>
      <button class="navbar-toggler " data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon bg-dark"></span>
      </button> 


    <div class="collapse navbar-collapse" id="navbarcollapseCMS">
      <ul class="navbar-nav ms-auto">
               <!-- .......................student.................................. -->
        <?php if ($user_type == "student") : ?>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="feedimg" alt="logo" /> -->
            <a href="../alumni/alumnijobpost.php" class="link">
              <span><b>Find Jobs</b></span>
            </a>
          </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="img" alt="logo"> -->
            <a href="../student/allforumpost.php" class="link">
              <span><b>Forum</b></span>
            </a>
        </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="img" alt="logo" /> -->
            <a href="#" class="link">
              <span><b>My queries</b></span>
            </a>
          </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="joinedimg" alt="logo" /> -->
            <a href="../admin/adminmanagealumni.php" class="link">
              <span><b>Allumni</b></span>
            </a>
          </li>


        <!-- .......................alumni.................................. -->
        <?php elseif($user_type == "alumni") : ?> 

          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="feedimg" alt="logo" /> -->
            <a href="../alumni/alumnijobpost.php" class="link">
              <span><b>Job Area</b></span>
            </a>
          </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="img" alt="logo"> -->
            <a href="../student/allforumpost.php" class="link">
              <span><b>Forum</b></span>
            </a>
        </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="img" alt="logo" /> -->
            <a href="#" class="link">
              <span><b>Notice</b></span>
            </a>
          </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="joinedimg" alt="logo" /> -->
            <a href="../admin/adminmanagealumni.php" class="link">
              <span><b>All Alumni</b></span>
            </a>
          </li>

          <!-- ----------------------------admin------------------------------------ -->
          <?php elseif($user_type == "admin") : ?> 

            <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="feedimg" alt="logo" /> -->
            <a href="../alumni/alumnijobpost.php" class="link">
              <span><b>Create Job</b></span>
            </a>
          </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="img" alt="logo"> -->
            <a href="../student/allforumpost.php" class="link">
              <span><b>Forum</b></span>
            </a>
        </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="img" alt="logo" /> -->
            <a href="#" class="link">
              <span><b>Notice</b></span>
            </a>
          </li>
          <li class="nav-item pe-2">
            <!-- <img src="../images//user.png" class="joinedimg" alt="logo" /> -->
            <a href="../admin/adminmanagealumni.php" class="link">
              <span><b>Manage Allumni </b></span>
            </a>
          </li>

        <?php endif; ?>
      </ul>



      <ul class="navbar-nav ms-auto">
        <!-- <div style="margin-top:7px;" >
          <li class="nav-item dropdown">
            <a class="link-secondary me-3 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell " style="font-size:20px"></i>
            </a> 
             
            <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdownMenuLink" >
          
               
            </ul>  
          </li>
        </div> --> 
          <li class="nav-item dropdown">
            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="../images//<?php echo $user_image; ?>" class="rounded-circle" height="36" alt="user icon" loading="lazy" />
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
              <li>
              <a class="dropdown-item" href="../student/userprofile.php" id="profilebutton">My profile</a> 
                
              </li>
              <li>
                <a class="dropdown-item" href="../assets/logout.php">Logout</a>
              </li>
            </ul>
          </li>
   
      </ul>
    </div>
  </div>
</nav>