<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Chat</title>
</head>
<body>
	<?php
	 require_once("connection.php");
		$user=$_SESSION['user_name'];
		$num=0;
		$s = "select user_name,password from users where user_name = '$user'";
		$result = mysqli_query($con,$s);
		$num = mysqli_num_rows($result);
		if($num==1)
		{
			$sql="delete from users where user_name='$user'";
			if($con->query($sql) === TRUE) {
				echo "<script type='text/javascript'>window.top.location='index.php';</script>";}
			else
				echo "error";

		}
	?>
</body>
</html>					