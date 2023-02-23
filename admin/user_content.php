  <?php 
      if(!session_id()){session_start();}
      if(empty($_SESSION['user'])){ ?>
            <div class="x-user">---</div>
            <div class="x-userid">------------</div>
        <?php } else { ?>
            <div class="x-user"><?php echo $_SESSION['user']['name']; ?></div>
            <div class="x-userid"><?php echo $_SESSION['user']['uid']; ?></div>
       <?php } ?> 
        

       
