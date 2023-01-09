 

 <?php
include '../assets//config.php';
if(isset(($_GET['selectedpost_id']))){ 
  $selectedpost_id=$_GET['selectedpost_id'];  
}
if(isset(($_GET['deleteComment']))){
  $comment_id=$_GET['comment_id']; 
  $selectedpost_id=$_GET['selectedpost_id'];  
   mysqli_query($conn, "DELETE FROM `comment` WHERE  comment_id = '$comment_id'") or die('query failed'); 


} 
if(isset(($_GET['deleteReplyComment']))){
 $comment_id=$_GET['comment_id'];
 $selectedpost_id=$_GET['selectedpost_id']; 
 $reply_id=$_GET['reply_id'];  
  mysqli_query($conn, "DELETE FROM `comment_reply` WHERE  comment_id = '$comment_id' AND reply_id='$reply_id'") or die('query failed'); 


} 
if(isset($_POST['submit'])){
    $comment_content= mysqli_real_escape_string($conn, $_POST['comment_content']);
    $post_id= $_POST['post_id'];
    $parent_id= $_POST['parent_id'];
    echo $parent_id;
    $comment_time = date("m.d.Y"); 
    mysqli_query($conn, "INSERT INTO `comment`(parent_id,user_id,post_id,comment_content,comment_time) VALUES('$parent_id','$user_id', '$post_id', '$comment_content','$comment_time')") or die('query failed');
     
    

}  ;
         $post = mysqli_query($conn, "SELECT * FROM `post` WHERE post_id='$selectedpost_id'") or die('query failed');
         if(mysqli_num_rows($post) > 0){ 
          echo "lol2";
            while($row = mysqli_fetch_assoc($post)){ 
              $post_id= $row['post_id']; 
              $post_tittle=$row['post_title'];
              $post_caption=$row['post_caption']; 
              $post_time=$row['post_time'];
              $numberof_view=$row['numberof_view'];
              $numberof_reply =$row['numberof_reply'];
              $puser_id=$row['user_id'];
              $user=mysqli_query($conn, "SELECT * FROM `users` WHERE user_id='$puser_id'") or die('query failed');
              if(mysqli_num_rows($user) > 0){
                  $rowc= mysqli_fetch_assoc($user);
                  $user_name=$rowc['name'];
                  $user_image=$rowc['user_image'];
                   
              }  
                
          
                
      ?>


<section >
    <div class="container my-2 py-1 px-2 mt-5">
       <!-- Account page navigation-->
    
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="card p-2">
<!-- ---------------------------------------------------------loads post one by one------------------------------------------------------------------------------- -->
                    <div class="card-body">
                        <div class="d-flex flex-start align-items-center">
                            <img class="rounded-circle shadow-1-strong me-3" src="../images//<?php echo $user_image; ?>" alt="avatar" width="60" height="60" />
                            <div>
                                <h6 class="fw-bold text-primary mb-1"><?php echo $user_name; ?></h6>
                                <p class="text-muted small mb-0">
                                <?php echo  $post_time; ?>
                                </p>
                            </div>
                            <a href="allforumpost.php?  dpost_id=<?php echo $post_id; ?>  " class="text-danger ms-auto" data-original-title="Delete"><i class="far fa-trash-alt"></i></a>
                    
                        </div>
                        <div>
                            <p class="mt-3 mb-1 pb-2 pe-2" style="text-align:justify;"> 
                            <?php echo  $post_caption; ?>
                            </p>
                        </div> 
                    </div>

                    <form action="" method="post" class="row ps-3 pe-4"> 
                        <div class="col-sm-10 mb-2 mt-2">
                            <input type="text" name="comment_content" class="form-control" placeholder="Write Comment" style="font-size:12px ;">
                            <input type="number" name="post_id" class="form-control" value="<?php echo  $post_id; ?>" style="display:none;">
                        </div>
                        <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                            <button  type="submit" name="submit" class="btn btn-sm btn-primary mb-2 mt-2">add </button>
                        </div>
                       
                    </form>

                     
<!-- --------------------------------------------------------checks fo comment and loads comment-------------------------------------------- -->
       <?php
            $comment=mysqli_query($conn, "SELECT * FROM `comment` WHERE post_id='$post_id' AND parent_id='0' ORDER BY comment_id DESC") or die('query failed');
            if(mysqli_num_rows($comment) > 0){
              while($rowco= mysqli_fetch_assoc($comment)){;
                $comment_id=$rowco['comment_id'];
                $userc_id=$rowco['user_id'];
                $comment_content=$rowco['comment_content'];
                $comment_time=$rowco['comment_time'];

                $user=mysqli_query($conn, "SELECT * FROM `users` WHERE  user_id=' $userc_id'") or die('query failed');
                if(mysqli_num_rows($user) > 0){
                    $rowu= mysqli_fetch_assoc($user);
                    $user_name=$rowu['name']; 
                    $user_image=$rowu['user_image'];
                     
                }
            

           ?>

           <div class="card-body p-4" id="commentcard">  
            <div class="row">
              <div class="col">
                <div class="d-flex flex-start">
                  <img class="rounded-circle shadow-1-strong me-3"
                    src="../images//<?php echo  $user_image; ?>" alt="avatar"  width="30" height="30" />
                  <div class="flex-grow-1 flex-shrink-1">
                    <div>
                      <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-1"> <?php echo  $user_name; ?>
                        </p>  
                      </div>
                      <p class="small mb-0">
                      <?php echo  $comment_content; ?>              
                      </p>
                      <span class="small">  <?php echo  $comment_time?>
                      </span><a href="#" data-bs-toggle="collapse" data-bs-target="#card<?php echo $comment_id; ?>" aria-expanded="false" aria-controls="collapseOne"><span class="small">reply</span></a>
                      <?php if($userc_id==$user_id){ ?>
                       <span><a href="userfeed.php?deleteComment=1? && comment_id=<?php echo  $comment_id; ?> && selectedpost_id=<?php echo $post_id; ?> " class=" btn-sm text-danger" style="text-decoration:none ;"><b>Delete</b></a></span>
                        <?php } ?>
                      
                    </div>
                        <!-- ---------------------------------reply Form------------------------------------------- -->
                        <form action="" id="card<?php echo $comment_id; ?>" method="post" class="row ps-3 pe-4 replyArea collapse"  data-bs-parent="#commentcard" > 
                    <div class="d-flex" >
                    <div class="col-sm-10 mb-2 mt-2">
                            <input type="text" name="comment_content" class="form-control" placeholder="Write Comment" style="font-size:12px ;">
                            <input type="number" name="parent_id" class="form-control" value="<?php echo  $comment_id; ?>" style="display:none;"> 
                            <input type="number" name="post_id" class="form-control" value="<?php echo  $post_id; ?>" style="display:none;">
                        </div>
                        <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                            <button  type="submit" name="submit" class="btn btn-sm btn-primary mb-2 mt-2">   Reply  </button>
                        </div>
                       
                    </div>
                       
                    </form> 
                 

<!-- ---------------------------------------------------checks for comment reply and loads reply---------------------------------------------------------- -->
                    <?php 
                               $comment_reply=mysqli_query($conn, "SELECT * FROM `comment` WHERE parent_id='$comment_id'ORDER BY comment_id DESC") or die('query failed');
                              if(mysqli_num_rows($comment_reply) > 0){
                                while( $rowreply= mysqli_fetch_assoc($comment_reply)){ 
                                $commentreply_id=$rowreply['comment_id'];
                                $userrc_id=$rowreply['user_id'];
                                $reply_content=$rowreply['comment_content'];
                                $comment_time=$rowreply['comment_time'];

                                $user=mysqli_query($conn, "SELECT * FROM `users` WHERE  user_id=' $userrc_id'") or die('query failed');
                                if(mysqli_num_rows($user) > 0){
                                $rowu= mysqli_fetch_assoc($user);
                                 $user_name=$rowu['name']; 
                                 $user_image=$rowu['user_image'];
                                }
                                 
                            
            
                    ?>
                  
                     
                    <div class="d-flex flex-start mt-4">
                      <a class="me-3" href="#">
                        <img class="rounded-circle shadow-1-strong"
                          src="../images//<?php echo  $user_image; ?>" alt="avatar" width="30" height="30" />
                      </a>
                      <div class="flex-grow-1 flex-shrink-1">
                        <div>
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-1">
                            <?php echo  $user_name; ?>
                            </p> 

                          </div>
                          <p class="small mb-0">
                          <?php echo  $reply_content?> 
                          </p>
                          <span class="small"><?php echo  $comment_time?></span>
                           </span><a href="#" data-bs-toggle="collapse" data-bs-target="#card<?php echo $commentreply_id; ?>" aria-expanded="false" aria-controls="collapseOne"><span class="small">reply</span>
                           <?php if($userc_id==$user_id){ ?>
                       <span><a href="userfeed.php?deleteComment=1? && comment_id=<?php echo  $commentreply_id; ?> && selectedpost_id=<?php echo $post_id; ?> " class=" btn-sm text-danger" style="text-decoration:none ;"><b>Delete</b></a></span>
                        <?php } ?>
                           

                        </div>
                      </div>
                    </div>    <!-- ---------------------------------reply Form------------------------------------------- -->
                        <form action="" id="card<?php echo $commentreply_id; ?>" method="post" class="row ps-3 pe-4 replyArea collapse"  data-bs-parent="#commentcard" > 
                    <div class="d-flex" >
                    <div class="col-sm-10 mb-2 mt-2">
                            <input type="text" name="comment_content" class="form-control" placeholder="Write Comment" style="font-size:12px ;"> 
                            <input type="number" name="parent_id" class="form-control" value="<?php echo  $comment_id; ?>" style="display:none;"> 
                            <input type="number" name="post_id" class="form-control" value="<?php echo  $post_id; ?>" style="display:none;">
                        </div>
                        <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                            <button  type="submit" name="submit" class="btn btn-sm btn-primary mb-2 mt-2">   Reply  </button>
                        </div>
                       
                    </div>
                       
                    </form> 

                    <?php
                                }
                              }
                    ?>

                    
                  </div>
                </div>
 
              </div>
            </div>
          </div> 

                <?php
                    }
                  } 
                    ?> 

                </div>
            </div>
        </div>

    </div>
</section>
<?php
         }
      }

?>
      

 