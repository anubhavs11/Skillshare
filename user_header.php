<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Welcome to Skillshare | Best place to share your skills with other students</title>
    <link rel="stylesheet" type="text/css" href="w3.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="w4.css">
      <link rel='stylesheet' href='w1.css'>
      <link rel='stylesheet' href='fontawesome-free-5.0.9\web-fonts-with-css\css\fontawesome-all.min.css'>
      <script src="bootstrap/jquery.min.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <script src="bootstrap/jquery.min.js"></script>
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <?php
      session_start();
      if(empty($_SESSION['user'])){
        die("<h1>Something Went wrong</h1>");
      }
      include 'pdo.php';
      ?>
 <style>
               .navbar-default .navbar-nav>li>a {
                  color: #fff;
               }
                /* width */
              ::-webkit-scrollbar {
                  width: 10px;
              }

              /* Track */
              ::-webkit-scrollbar-track {
                  background: #f1f1f1; 
              }
               
              /* Handle */
              ::-webkit-scrollbar-thumb {
                  background: #888; 
              }

              /* Handle on hover */
              ::-webkit-scrollbar-thumb:hover {
                  background: #555; 
              }

              a {
                text-decoration: none !important;
             }
</style>
  </head>
  <script>
        function w3_open() {
          document.getElementById("mySidebar").style.display = "block";
          document.getElementById("header").style.marginLeft ="50%";
          document.getElementById("bar").style.display = "none";
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("bar").style.display = "block";
            document.getElementById("header").style.marginLeft ="0%";
        }
    </script>
  <body onload="w3_close()">
      <div class="hidden-lg hidden-md hidden-sm">
        <div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:50%;text-align:center;font-size: 16px;" id="mySidebar">
            <span onclick="w3_close()" class="w3-button w3-display-topright">&times;</span>
            <h1 class="w3-large w3-text-theme"><?php echo $_SESSION['user']; ?></h1>
            <?php 
            $username=$_SESSION['user'];
                  $result = $db->prepare("SELECT * FROM users WHERE username=:username");
                  $result->bindParam(":username",$username);
                  $result->execute();
                  $res=$result->fetch();
                  $image=$res['picture'];
            ?>
            <a href="my_profile.php"><img src="<?php echo 'profile_pics/'.$image; ?>" height="90" width="90" class="img-resposive img-circle "> </a>

            <a class="w3-button w3-bar-item w3-padding" style="margin-top: 20px;" href="home.php">Home</a>
            <a href="chat_page.php" class="w3-bar-item w3-button">Messages</a>
            <a href="notification.php" class="w3-bar-item w3-button">Notification</a>
            <a class="w3-button w3-bar-item w3-padding" href="my_profile.php">My Profile</a>
            <a class="w3-button w3-bar-item w3-padding" href='circle_feed.php'>My Circles</a>
            <a class="w3-button w3-bar-item w3-padding" href='create_circle.php'>Create Circle</a>
            <a class="w3-button w3-bar-item w3-padding" href="project_show.php">Projects</a>
            <a class="w3-button w3-bar-item w3-padding" href='post_your_project.php'>Post Projects</a>
            <a class="w3-button w3-bar-item w3-padding" href="index.php">Sign out</a>
        </div>
      </div>
    <nav id="header" class="w3-card-4 navbar navbar-default navbar-fixed-top" style="background-color:#56656d !important;border-color:#56656d !important;">
        <div class="navbar-header navbar-left w3-large" style="color: #fff;">
          <a href = "home.php" class="w3-bar-item w3-button w3-left w3-hide-small " style="margin-left: 50px;font-family: Alpha Eco ;font-size: 24px">Skillshare</a>
        </div>
        <div class="navbar-header navbar-right w3-large" style="margin-right: 10%;color: #fff;">
            <a id="bar" class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-left w3-padding-large w3-hover-white w3-large w3-theme-d2" onclick="w3_open()"><i class="fa fa-bars"></i></a>
            
            <a href = "home.php" class="w3-bar-item w3-button w3-left w3-hide-large w3-hide-medium w3-padding-large " style="font-family: Alpha Eco">Skillshare</a>
            <a class="w3-bar-item w3-hide-small w3-button w3-hover-white w3-padding-large " href="home.php">
                <i class="fa fa-home"></i> Home</a>

            <div class="w3-dropdown-click w3-hide-small">
             <button onclick="show_msg()" href="chat_page.php" class="w3-button w3-padding-large" title="Messages"><i class="fa fa-envelope"></i> <?php
                          $username=$_SESSION['user'];
                          $sql = "SELECT count(*) FROM chats WHERE receiver='$username' AND seen=0";
                          $result = $db->prepare($sql);
                          $result->execute();
                          $count = $result->fetchColumn();
                          if($count>0){
                              echo '<span class="badge w3-green">'.$count.'</span>';
                            }
                        ?></button>     
                <div id="msg_content" class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:350px;text-align:center;max-height: 300px;overflow-y:scroll;">
                    <?php
                    $p=0;
                    foreach($db->query("SELECT * FROM chats WHERE receiver='$username' AND seen=0 order by time1 ") as $row){
                      $p=$p+1;
                     ?>
                     <form action="chat_page.php" method="post">
                     <button class="w3-bar-item w3-button" type="submit" name="to" value="<?php echo $row['sender'];?>"><h4><b><?php echo $row['sender'],' : '; ?></b><?php echo $row['message']; ?></h4></button> 
                     </form>
                    <?php } 
                      if($p==0){?>
                      <h5>No new Messages</h5>
                      <?php } ?>
                      <a style="color:blue;" href="chat_page.php">show message box</a>
                      <h4></h4>
                      <h4></h4>
                </div>
            </div>
            <script type="text/javascript">
              function show_msg(){
                var x = document.getElementById("msg_content");
                  if (x.className.indexOf("w3-show") == -1) {
                      x.className += " w3-show";
                  } else { 
                      x.className = x.className.replace(" w3-show", "");
                      $.post('home2.php',{
                        msg_seen:'1'
                      });
                  }
              }
              function show_noti() {
                  var x = document.getElementById("noti_content");
                  if (x.className.indexOf("w3-show") == -1) {
                      x.className += " w3-show";
                  } else { 
                      x.className = x.className.replace(" w3-show", "");
                      $.post('home2.php',{
                        noti_seen:true
                      });
                  }
              }
            </script>
            <div class="w3-dropdown-click w3-hide-small">
                <button onclick="show_noti()" class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i> <?php
                          $username=$_SESSION['user'];
                          $sql = "SELECT count(*) FROM notification WHERE username='$username' AND seen=0";
                          $result = $db->prepare($sql);
                          $result->execute();
                          $count = $result->fetchColumn();
                          if($count>0){
                            echo '<span class="badge w3-green">'.$count.'</span>';
                  }
                ?></button>     
                <div id="noti_content" class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px;max-height: 300px;overflow-y:scroll;">
                    <?php
                    $noti=0;
                    foreach($db->query("SELECT * FROM notification WHERE username='$username' order by timestamp DESC ") as $row){
                       $noti= $noti+1;
                      if($row['type']=='comment'){
                       $loc="posts.php?post_id=".$row['id']; ?>
                            <a class="w3-bar-item w3-button" href="<?php echo $loc; ?>">
                                <?php echo $row['other_user'].' answered to your post </h4>';?>
                            </a>
                          <?php }  if($row['type']=='project'){  ?>
                          <a class="w3-bar-item w3-button" href="<?php echo '#'; ?>">
                               <?php echo 'congrats , '.$row['other_user'].' accepted your project order '; 
                             } ?>
                         </a><?php
                       if($row['type']=='discussion'){  ?>
                          <a class="w3-bar-item w3-button" href="<?php echo $loc; ?>">
                               <?php echo $row['other_user'].' started a discussion '; 
                             } ?>
                         </a>
                         <?php 
                       if($row['type']=='awesome'){  ?>
                          <a class="w3-bar-item w3-button" href="<?php echo '#'; ?>">
                               <?php echo $row['other_user'].' liked your Answer '; 
                             } ?>
                         </a><?php
                         if($row['type']=='project_complete'){  ?>
                         <form action="update.php" method="post">
                          <button class="w3-bar-item w3-button" name="download_project" type="submit"
                            value="<?php echo $row['id'];?>">
                               <?php echo $row['other_user'].' completed your project,download now '; 
                             } ?>
                         </button>
                         </form>
                         <?php }
                         if($noti==0){
                          echo "<h5 style='color:blue;text-align:center'>no notifications</h5>";
                         }?>
                </div>
              </div>
                <div class="w3-dropdown-hover w3-hide-small">
                <button class="w3-button w3-padding-large" ><i class="fa fa-user"></i>Account
                          </button>     
                <div class="w3-dropdown-content w3-card-4 w3-bar-block">  
                      <a style="font-size: 18px;" class="w3-button w3-bar-item w3-padding" href="my_profile.php">My Profile</a>
                      <a style="font-size: 18px;" class="w3-button w3-bar-item w3-padding" href="circle_feed.php">
                      My Circles</a>
                      <a style="font-size: 18px;" class="w3-button w3-bar-item w3-padding" href="create_circle.php">
                      Create Circles</a>
                      <a style="font-size: 18px;" class="w3-button w3-bar-item w3-padding" href="project_show.php">Projects</a>
                      <a style="font-size: 18px;" class="w3-button w3-bar-item w3-padding" href='post_your_project.php'>Post Projects</a>
                      <a style="font-size: 18px;" class="w3-button w3-bar-item w3-padding" href="index.php">Sign out</a>
                </div>
            </div>
        </div>
    </nav>
    </body>
</html>
