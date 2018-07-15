<?php
include 'user_header.php';
include 'pdo.php';
?>
<html lang="en">
  <head>
  	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <script src="bootstrap/jquery.min.js"></script>
     <script src="my_profile_functions.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="my_profile_css.css" rel="stylesheet">
  </head>

  <body>
    <div class="container" style="margin-top: 200px;">
      <div class="row">
        <?php if(isset($_POST['followers'])){?>
        <div class="col-lg-8 col-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
              <table class="table">
                    <tbody>
                        <?php
                      require 'pdo.php';
                      $stmt=$db->prepare("SELECT * FROM followers WHERE username =:username");
                      $stmt->bindParam(":username",$username);
                      $stmt->execute();
                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                          echo '<tr>';
                          echo '<td>'.$row['username'].'</td>';
                          echo '<td>'.$row['follower'].'</td>';
                          echo '</tr>';
                        }?>
                    </tbody>
                  </table>
        </div>
        <?php }else if(isset($_POST['following'])){?>
        <div class="col-lg-8 col-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
              <table class="table">
                      <tbody>
                          <?php
                        require 'pdo.php';
                        $stmt=$db->prepare("SELECT * FROM followings WHERE username =:username");
                        $stmt->bindParam(":username",$username);
                        $stmt->execute();
                          while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                            echo '<tr>';
                            echo '<td>'.$row['username'].'</td>';
                            echo '<td>'.$row['following'].'</td>';
                            echo '</tr>';
                          }?>
                      </tbody>
                    </table>
        </div>
        <?php } ?>
      </div>
    </div>
  </body>