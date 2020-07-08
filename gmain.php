<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>My Chat</title><link rel = "icon" href =  "mainlogo.png" type = "image/x-icon">
<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="styleone.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="styletwo.css">
          </head>
          <body  background="rose.jpg"; style="margin: 0px;">
          <div style="margin: 0px;">
          <div class="topnav">
            <a href="#" class="active">MY CHAT <i class="fa fa-comment" style="color: white"></i></a>
            <hr>
            <div id="myLinks">
             <?php 
                if (isset($_SESSION['user_name'])) {
                echo '<a style="color:white;"><i class="fa fa-fw fa-user"></i>' .$_SESSION['user_name'].'</a>';   
              }
               else{
                echo "<script type='text/javascript'>window.top.location='index.php';</script>";}
              ?>
              <a href="entry.php"><i class="fa fa-group" style="color:white"></i> CHAT ROOM</a>
              <a href="privatechat.php"><i class="fa fa-comments" style="color:white"></i> PRIVATE CHAT</a>
               <?php
                $group=$_GET['group_name'];
                echo '<a style="text-decoration:none;"; href=deletechatroom.php?group_name='.$group.'><i class="fa fa-trash" style="color:white"></i> DELETE CHATROOM<br><small>(Delete only by Admin)</small></a>';
                ?>
               <?php
                $group=$_GET['group_name'];
                echo '<a style="text-decoration:none;"; href=exit.php?group_name='.$group.'><i class="fa fa-sign-out" style="color:white"></i> LEAVE CHATROOM</a>';
                ?>
              <a href="logout.php"><i class="fa fa-sign-out"></i> LOG OUT</a>
            </div>
            <a style="margin:0px;"; href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
          </div>

          <script>
          function myFunction() {
            var x = document.getElementById("myLinks");
            if (x.style.display === "block") {
              x.style.display = "none";
            } else {
              x.style.display = "block";
            }
            }
            function openNav() {
              document.getElementById("mySidepanel").style.width = "250px";
            }

            function closeNav() {
              document.getElementById("mySidepanel").style.width = "0";
            }
          </script>
         
        <center><a href="#footer"  style="
           font-family: inherit;
              font-weight: 300;
              font-size: 15px;
              background-color: #5D055D;
              color: white;
              text-decoration:none; 
              margin: 0px;
              padding: 5px;
              float: right;">Go to bottom</a>	

              <?php
              require_once("connection.php");
              $group=$_GET['group_name'];
              echo '<h1 style="color:#5D055D; text-align:center; margin:0px;">'.$group.' </h1>';
        
                $receiver=$_SESSION['user_name'];
                $member=strtoupper($receiver);
        
                $sql = "update groupchat set status = 'read' where group_name='$group' && group_member1='$member'";
                if(mysqli_query($con,$sql)){
                  //echo "notification delected";
                }
                else{
        
                  echo "notification error";
                }
      ?></center>
      

     <div id="mySidepanel" class="sidepanel">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"> << </a> 
            <?php
              $group_member=$_SESSION['user_name'];
              if($group_member!=''){
              // $group;
              $group_member1=strtoupper($group_member);      
           
              $s = "select group_name,group_member1 from groupchat where group_name='$group' && group_member1='$group_member1' ";

               $result = mysqli_query($con,$s);

               $num = mysqli_num_rows($result);

              if($num>0)
              {
                // echo "Name already Taken";
              }
              else
              {
                
                $reg = "insert into groupchat (id,group_name,group_member,group_member1,status) values ('','$group' ,'$group_member' , '$group_member1','')";
                if(mysqli_query($con,$reg))
                {
                  $_SESSION['user_name'] = $group_member;
                  // echo "<script type='text/javascript'>window.top.location='entry.php';</script>";
                }
               }
              echo '<h2 style="margin:10px; color:white;";><i class="fa fa-fw fa-user"></i>Admin</h2>';
               $s = "select creator from new_group where group_name='$group'";
              $result = mysqli_query($con,$s);
              if($row = mysqli_fetch_assoc( $result )){
                $creator=$row['creator'];
                 echo '<a  href=pmain.php?user_name='.$creator.' style="color:white;";><i class="fa fa-arrow-right" style="color:white"></i>' .$creator.'</a>';}
              echo '<hr>';
              echo '<h2 style="margin:10px; color:white;";><i class="fa fa-group" style="color:white"></i> Members</h2>';
              $sql = "select group_member from groupchat where group_name='$group' && group_member!='$creator'";
              $result = mysqli_query($con,$sql);
              
              while($row = mysqli_fetch_assoc( $result )){
                    $group_member=$row['group_member'];
                    echo '<a href=pmain.php?user_name='.$group_member.'style="color:white;";><i class="fa fa-arrow-right" style="color:white"></i>' .$group_member.'</a>';
              }
            }
           
              ?>
         </div>


          <button class="openbtn" onclick="openNav()"> >> </button> 
    <div id="message_area" style="overflow-y: scroll;">

      <?php
      $sql = "select * from $group order by id";
      if(mysqli_query($con,$sql))
      {
        //echo " success";
      }
      $result = mysqli_query($con,$sql);

      while( $row = mysqli_fetch_assoc( $result ) ){
         $user_name=$row['user_name'];
        if($user_name!=$_SESSION['user_name']){
            $message=$row['message'];
            $time=$row['date_time'];
            echo '<h3 class="othermessage" style="color:#5D055D; margin:0px; float:left;">'.$user_name.' : '.$message.'</h3>';
            echo "<br><br>";
            echo '<small class="othermessage" style="float:left;">'.$time.'</small>';
            echo '<br><br>';
          }
        else{
             $message=$row['message'];
            $time=$row['date_time'];
            echo '<h3 class="yourmessage" style="color:#5D055D; margin:0px; float:right;">You : '.$message.'</h3>';
            echo "<br><br>";
            echo '<small class="yourmessage" style="float:right; color:#5D055D;">'.$time.'</small>';
            echo '<br><br>';
        }}
        echo '<small id="footer"></small>';
        ?>

        <?php
        require_once("connection.php");
      if(isset($_POST['submit'])){
        if(isset($_POST['message'])!=""){
        $message=$_POST['message'];
        $user_name=$_SESSION['user_name'];
        $q = "insert into $group(id,user_name,message) values ('','$user_name','$message')";
        if(mysqli_query($con,$q)){
          echo '<h3 class="yourmessage" style="color:#5D055D; float:right;">You : '.$message.'</h3>';
          echo "<br><br>";
                  }

        $gmember = strtoupper($user_name);
        $s1 = "update groupchat set status='unread' where group_name='$group' && group_member1!='$gmember'";
        if(mysqli_query($con,$s1)){
          //echo "updated";
        }

      }}
      ?>
    </div>
       
    <form method="post">
        <textarea name="message" required="message" rows="3" style="width: 80%; margin-top:15px; height:30%; border: 1px solid #5D055D;" placeholder="type to send message......"></textarea>
      <button name="submit" value="submit"><img src="send.png" width="48" height="53"/></button></form>         

</body>
</html>
