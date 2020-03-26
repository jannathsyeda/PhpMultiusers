<?php 
session_start();
$_userid=$_SESSION['id']?? 0;
if(!$_userid)
{
    header("location:index.php");
    die();

}


require_once "function.php";
include_once 'config.php';
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
  throw new Exception("Cannot connect to database");
}

$id=$_GET['id']??0;
$query="DELETE FROM user_table WHERE id={$id} LIMIT 1";
echo $query;
	 	mysqli_query($connection,$query);
	 	header('location:home.php');


?>