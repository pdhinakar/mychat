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
		$group=$_GET['group_name'];
                $g = "delete from groupchat where group_name='$group'";
                mysqli_query($con,$g);
		$num=0;
		$s = "select group_name,creator from new_group where group_name = '$group' && creator = '$user' ";
		$result = mysqli_query($con,$s);
		$num = mysqli_num_rows($result);
		if($num==1)
		{
			$sql="delete from new_group where group_name='$group' && creator='$user'";
			if($con->query($sql) === TRUE) {
			$user_name=$user;}
	         $s = "DROP TABLE $group";       
	         if(mysqli_query($con, $s)) {  
	            //echo "Table is deleted successfully";  
	         } else {  
	           // echo "Table is not deleted successfully\n";
	         }
		}
		$user_name=$user;
		echo "<script type='text/javascript'>window.top.location='entry.php';</script>";
	?>
</body>
</html>						