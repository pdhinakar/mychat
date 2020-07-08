<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>My Chat</title><link rel = "icon" href =  
"mainlogo.png" 
        type = "image/x-icon">
	<link rel="stylesheet" type="text/css" href="styleone.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>  
<body background="rose.jpg";><br>
	<h1 style="color: #5D055D; text-align: center; height: 50px;">MY CHAT <i class="fa fa-comment" style="color: #5D055D"></i></h1>
	<?php
	require_once("connection.php");
		if(isset($_POST['login']))
		{
			$user_name=$_POST['user_name'];
			$password=$_POST['password'];
			$user_name1=strtoupper($user_name);
			if($user_name != "" and $password != "")
			{
       			$s = "select user_name1,password from users where User_name = '$user_name1' && Password = '$password' ";

				$result = mysqli_query($con,$s);

				$num = mysqli_num_rows($result);

				if($num>0)
				{
					$_SESSION['user_name'] = $user_name;
					echo "<script type='text/javascript'>window.top.location='entry.php';</script>";

				}
				else
				{
					$s = "select user_name1,password from users where User_name = '$user_name1'";
					$result = mysqli_query($con,$s);
					$num = mysqli_num_rows($result);
					if($num>0)
					{
						echo "Login Failed ";
					}
					else
						echo "Please Sign up";
				}
			}
		}

		if(isset($_POST['signup']))
		{
			$user_name=$_POST['user_name'];
			$password=$_POST['password'];
			$user_name1=strtoupper($user_name);
			if($user_name != "" and $password != "")
			{
				$s = "select user_name1 from users where user_name1='$user_name1'";

				 $result = mysqli_query($con,$s);

				 $num = mysqli_num_rows($result);

				if($num>0)
				{
					echo "Name already Taken";
				}
				else
				{
					
					$reg = "insert into users(id,user_name,user_name1,password) values ('','$user_name' ,'$user_name1' , '$password')";
					if(mysqli_query($con,$reg))
					{
						$_SESSION['user_name'] = $user_name;
						echo "<script type='text/javascript'>window.top.location='entry.php';</script>";

					}
					
				}

			}
		}
	?>
	<h1><i>Login</i></h1>
	<div>
		
			<form method="post">
					<h2><i>User Name</i></h2> 
							<input type="text" name="user_name" placeholder="User Name" required="user_name" >
					
							<h2><i>Password</i></h2> 
							<input type="Password" name="password" placeholder="Password" required="password" >
					
						<input type="submit" name="login" value="Login">
						 
						 
	
			</form>
	</div>

	<h1><i>Sign Up</i></h1>
	<div>
		
			<form method="post">
					<h2><i>User Name</i></h2> 
							<input type="text" name="user_name" minlength="4" placeholder="User Name" required="user_name" >
					
							<h2><i>Password</i></h2> 
							<input type="Password" name="password" minlength="4" placeholder="Password" required="password" >
					
						<input type="submit" name="signup" value="Sign Up">
						 	
			</form>
	</div>
</body>
</html>