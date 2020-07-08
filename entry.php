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
		          <?php
		          require_once ("connection.php"); ?>
		          <body  background="rose.jpg"; style="margin: 0px;">
		          <div style="margin: 0px;">
		          <div class="topnav">
		            <a href="#" class="active">MY CHAT <i class="fa fa-comment" style="color: white"></i></a><hr>
		   
		            <div id="myLinks">
		              <?php 
		                if (isset($_SESSION['user_name'])) {
		                echo '<a><i class="fa fa-fw fa-user"></i>'.$_SESSION['user_name'].'</a>';   
		              }
                               else{
                                    echo "<script type='text/javascript'>window.top.location='index.php';</script>";}
		              ?>
		              <a href="entry.php"><i class="fa fa-group" style="color:white"></i> CHAT ROOM</a>
		              <a href="privatechat.php"><i class="fa fa-comments" style="color:white"></i> PRIVATE CHAT</a>
		              <a href="logout.php"><i class="fa fa-sign-out"></i> LOG OUT</a>
		              <?php
                			
               				echo '<a style="text-decoration:none;"; href=deleteaccount.php?user_name='.$_SESSION['user_name'].'><i class="fa fa-trash" style="color:white"></i> DELETE MY ACCOUNT</a>';
                	  ?>
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
<?php
 	require_once("connection.php");
 	if(isset($_POST['create']))
 	{
		$g = filter_input(INPUT_POST,'group_name');
                        $group_name= str_replace(' ', '_', $g);
		
			$group_name1=strtoupper($group_name);
                        
			if($group_name != "" )
			{
				$s = "select group_name from new_group where group_name='$group_name'";

				 $result = mysqli_query($con,$s);

				 $num = mysqli_num_rows($result);

				if($num>0)
				{
					echo "Name already Taken";
				}
				else
				{
					$user=$_SESSION['user_name'];
                                        $user1=strtoupper($user);
					$sql = "CREATE TABLE $group_name (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					user_name VARCHAR(30) NOT NULL,
					message text(100) NOT NULL,
					date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
					)";

					if ($con->query($sql) === TRUE) {
				  	 //echo "Table MyGuests created successfully";
				  	$_SESSION['group_name'] = $group_name;
					} 
					
					$reg = "insert into new_group(id,group_name,creator,creator1) values ('','$group_name','$user','$user1')";
					if(mysqli_query($con,$reg))
					{
						$_SESSION['user_name'] = $user;
						echo "<script type='text/javascript'>window.top.location='entry.php';</script>";
					}
					
				}

			}
	}

	?>
		
	<h2><i>Create your own chatroom</i></h2>
	<br>
		<div>
			<form method="post">
						<h2><i>Enter a chatroom name</i></h2>
					
						<input type="text" name="group_name" placeholder="Enter a chatroom name" required="group name">
				
						<input type="submit"  name="create" value="create">
			</form>
	</div>
	<br>
	<br>
	<h2><i>Available chatrooms:</i></h2>
	<div>
		<?php
			require_once("connection.php");
			$sql = "select * from new_group ORDER BY group_name ASC";
			$result = mysqli_query($con,$sql);
			$receiver=$_SESSION['user_name'];
			$member=strtoupper($receiver);

			


			
			while($row = mysqli_fetch_assoc( $result )){
                                                echo '<br>';
                                                echo '<fieldset style="border-color:#5D055D;margin-right:0px; margin-left:0px;";>';
                                                echo '<div>';
						$group_name=$row['group_name'];
						echo '<br>';
						echo '<h2 style="margin:10px; color:#5D055D;";>'.$group_name.'</h2>';
				        echo '<a style="text-decoration:none;float:right;"; href=gmain.php?group_name='.$group_name.'>Enter chatroom</a>';
				        $sql1 = "select * from groupchat where group_name='$group_name' && group_member1='$member' && status = 'unread'";
						$result1 = mysqli_query($con,$sql1);
						if(mysqli_num_rows($result1))
						{
							echo '<a style="margin-left:0px;float:left; text-decoration:none;" href="#">New Message</a>';
						}
				                echo '</div>';
                                                echo '</fieldset>';


			}
		?>
	</div>
</body>
</html>