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
		                echo '<a><i class="fa fa-fw fa-user"></i>'. $_SESSION['user_name'].'</a>';   
		              }
                               else{
                                      echo "<script type='text/javascript'>window.top.location='index.php';</script>";}
		              ?>
		              <a href="entry.php"><i class="fa fa-group" style="color:white"></i> CHAT ROOM</a>
		              <a href="privatechat.php"><i class="fa fa-comments" style="color:white"></i> PRIVATE CHAT</a>
		              <a href="logout.php"><i class="fa fa-sign-out"></i> LOG OUT</a>
		            </div>
		            <a style="margin-top: 0px;";href="javascript:void(0);" class="icon" onclick="myFunction()">
		              <i class="fa fa-bars"></i>
		            </a>
		          </diV>

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
  <h2><i>Private Chat Members</i></h2>

  	 <div>
		<?php
			require_once("connection.php");
			 $user_name=$_SESSION['user_name'];
			
			echo"<br>";
			echo"<h2><i>New Messages : </i></h2>";
			$n="select * from userchat where receiver='$user_name' && status='unread'";
			$result1 = mysqli_query($con,$n);
			$num = mysqli_num_rows($result1);
			if($num==0){
				echo "<br>";
				echo '<h3 style="margin:10px; color:#5D055D;"><i>No New Message</i></h3>';
			}
			else{
			 while($row = mysqli_fetch_assoc($result1)){
				        	$nuser = $row['sender'];
				        	echo '<br>';
				        	echo '<h3 style="margin:10px;color:#5D055D;";>'.$nuser.'</h3>';
				        	echo '<a style="text-decoration:none;" href=pmain.php?user_name='.$nuser.'>Lets Chat</a>';
				         	echo '<a style="margin-left:10px; text-decoration:none;" href="#">New Message</a>';
				         }
			}
			echo"<br><br>";
			echo"<h2><i>Others Chat :</i></h2>";
			$sql = "select * from users where user_name!='$user_name' ORDER BY user_name ASC";
			$result = mysqli_query($con,$sql);

					while($row = mysqli_fetch_assoc( $result )){
						$user_name=$row['user_name'];
							echo '<br>';
							echo '<h3 style="margin:10px;color:#5D055D;";>'.$user_name.'</h3>';
					        echo '<a style="text-decoration:none;" href=pmain.php?user_name='.$user_name.'>Lets Chat</a>';
						}				         
		?>
	</div>

				

</body>
</html>