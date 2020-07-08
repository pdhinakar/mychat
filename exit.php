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
                $user1=strtoupper($user);
                $group=$_GET['group_name'];
                
                
                $sql = "delete from groupchat where group_name='$group' && group_member1='$user1'";
		if(mysqli_query($con,$sql)){
			 //echo "deleted1";
		}
                $d = "select creator1 from new_group where group_name='$group'";
                $d1 = mysqli_query($con,$d);
                if($row = mysqli_fetch_assoc($d1)){
                        $c = $row['creator1'];
                }
                if($c == $user1){
                        $s = "SELECT * FROM groupchat where group_name='$group' ORDER BY RAND() LIMIT 1";
                        $s1 = mysqli_query($con,$s);
                        while($row = mysqli_fetch_assoc($s1)){
                                $nuser = $row['group_member'];
                        }
                        $nuser1=strtoupper($nuser);
                        $s2 = "update new_group set creator='$nuser',creator1='$nuser1' where group_name='$group' ";
                        if(mysqli_query($con,$s2)){           
                                echo "<script type='text/javascript'>window.top.location='entry.php';</script>";
                        }

                                
                }
                
	?>
</body>
</html>