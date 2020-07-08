<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Chat</title><link rel = "icon" href =  "mainlogo.png" type = "image/x-icon">
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="styletwo.css">
		<link rel="stylesheet" type="text/css" href="styleone.css">
		          </head>
		          <body  background="rose.jpg"; style="margin: 0px;">
		          <div style="margin: 0px;">
		          <div class="topnav">
		            <a href="#" class="active">MY CHAT <i class="fa fa-comment" style="color: white"></i></a><hr>
		            <div id="myLinks">
		              <?php 
		                if (isset($_SESSION['user_name'])) {
		                echo '<a><i class="fa fa-fw fa-user"></i>' .$_SESSION['user_name'].'</a>';   
		              }
                               else{
                                    echo "<script type='text/javascript'>window.top.location='index.php';</script>";}
		              ?>
		              <a href="entry.php"><i class="fa fa-group" style="color:white"></i> CHAT ROOM</a>
		             
		              <a href="privatechat.php"><i class="fa fa-comments" style="color:white"></i> PRIVATE CHAT</a>
		              <a href="logout.php"><i class="fa fa-sign-out"></i> LOG OUT</a>
		            </div>
		            <a style="margin-top: 0px;"; href="javascript:void(0);" class="icon" onclick="myFunction()">
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
			$receiver=$_GET['user_name'];
			echo '<h1 style="color:#5D055D;">'.$receiver.'</h1>';
	?></center>
			<?php
				$sender=$_GET['user_name'];
				$receiver=$_SESSION['user_name'];
				$sql = "update userchat set status = 'read' where sender='$sender' && receiver='$receiver'";
				if(mysqli_query($con,$sql)){
					//echo "notification delected";
				}
				else{
					echo "notification error";
				}
			?>
              
			
		<div id="message_area" class="inner-border">
 			<?php
 			$sender=$_SESSION['user_name'];
 			$receiver=$_GET['user_name'];
			$sql = "select * from userchat where (sender='$sender' && receiver='$receiver'|| sender='$receiver' && receiver='$sender') order by id";
			if(mysqli_query($con,$sql))
			{
				//echo " success";
			}
			$result = mysqli_query($con,$sql);
			while( $row = mysqli_fetch_assoc( $result ) ){
					 $user_name=$row['sender'];
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
			        }
			    }echo '<small id="footer"></small>';
				?>

				<?php
				require_once("connection.php");

			if(isset($_POST['submit'])){
				if(isset($_POST['message'])!=""){
				$message=$_POST['message'];
				$sender=$_SESSION['user_name'];
				$c = "select * from userchat where sender = '$sender' && receiver = '$receiver' && status = 'unread'";
				$n = mysqli_query($con,$c);
				$n1 = mysqli_num_rows($n);
				if($n1 == 0){
				$q = "insert into userchat(id,sender,receiver,message,status) values ('','$sender','$receiver','$message','unread')";
				if(mysqli_query($con,$q)){
					echo '<h3 style="color:#5D055D; float:right;" class="yourmessage">You : '.$message.'</h3>';
					echo "<br><br>";
				}
				}
				else{
					$q = "insert into userchat(id,sender,receiver,message,status) values ('','$sender','$receiver','$message','read')";
				if(mysqli_query($con,$q)){
					echo '<h3 style="color:#5D055D; float:right;" class="yourmessage">You : '.$message.'</h3>';
					echo "<br><br>";
				}
			}

	
			}}
			?>
		</div>
		<form method="post">
			  <textarea name="message" required="message" rows="3" style="width: 80%; margin-top:15px; height:30%; border: 1px solid #5D055D;" placeholder="type to send message......"></textarea>
      <button name="submit" value="submit"><img src="send.png" width="48" height="53"/></button>

		</form>
</body>
</html>  