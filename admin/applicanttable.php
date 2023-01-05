 
              <tr class="candidates-list">

<td class="title"> 
  <div class="candidate-list-details">
    <div class="candidate-list-info">
      <div class="candidate-list-title">
      
        <h5 class="mb-0"><a href="#"></a>*<?php echo  $user_name; ?></h5>
      </div> 
    </div>
  </div>
</td> 
<td class="candidate-list-favourite-time text-center">
  <span class="candidate-list-time order-1"><?php echo  $user_mail; ?></span>
</td>

<td class="candidate-list-favourite-time text-center">
  <span class="candidate-list-time order-1"><?php echo  $user_dept; ?></span>
</td>

<td class="candidate-list-favourite-time text-center">
  <span class="candidate-list-time order-1"><?php echo  $user_session; ?></span>
</td>

<td class="candidate-list-favourite-time text-center">
  <span class="candidate-list-time order-1"><?php echo  $user_batch; ?></span>
</td> 
<td class="candidate-list-favourite-time text-center">
  <span class="candidate-list-time order-1"><?php echo  $user_number; ?></span>
</td> 
<td>
  <ul class="list-unstyled mb-0 d-flex justify-content-end">   

   <li><a href="applicantaction.php?addmember=1  &&  user_id=<?php echo $userm_id; ?> " class="text-primary" title="" data-original-title="add"><i class="fa-solid fa-plus"></i></a></li> 
  </ul>
</td>
<td>
  <ul>
<li><a href="applicantaction.php?deletemember=1  &&  user_id=<?php echo $userm_id; ?> " class="text-danger" title="" data-original-title="delete"><i class="far fa-trash-alt"></i></a></li>
  </ul>
</td>
</tr> 