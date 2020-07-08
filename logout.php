<?php
session_start();
if(isset($_SESSION['user_name'])){
	unset($_SESSION['user_name']);
	header("location:index.php");
}else{
	header("location:index.php");
}

?>