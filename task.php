<?php 
session_start();
include_once 'config.php';
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
	throw new Exception("Cannot connect to database");
}else{

	$action=$_POST['action']??0;
	
	if('Registretion'==$action)
	{
		$email=$_POST['email']?? 0;
		$password=$_POST['password']?? 0;

		if($email && $password)
		{
			$hash=password_hash($password, PASSWORD_BCRYPT);
			$query = "INSERT INTO multiuser_table(email,password) VALUES ('{$email}','{$hash}')";
			mysqli_query($connection,$query);
			if(mysqli_error($connection))
			{
				$status=2;//didn't match,duplicate
			}
			else
			{
				$status=3;//registration successfully
			}

		}
		else
		{
			$status=4;//empty
		}
		  header("Location:index.php?status={$status}");
	}

	else if('login'==$action)
	{
		$email=$_POST['email']?? 0;
		$password=$_POST['password']?? 0;
		if($email && $password)
		{
		$query="SELECT id ,password FROM multiuser_table where email='{$email}'";
	
		$result=mysqli_query($connection,$query);
			if(mysqli_num_rows($result)>0)
			{
				$data=mysqli_fetch_assoc($result);
			
				$_password=$data['password']??0;
				$_id=$data['id']??0;
				if(password_verify($password,$_password))
				{
					$_SESSION['id']=$_id;
					 header("location:home.php");
					die();
				}
				else
				{
					$status=6;//dint match
				}

			}
			else
			{
				$status=5;//no data
			}
		

	}
	else
	{
		$status=4; //empty
	}

 header("location:index.php?status={$status}");
}
	
	else if('insert'==$action){
		$name=$_POST['name']??0;
		$contact=$_POST['contact']??0;
		$user_id=$_SESSION['id']??0;
		if(	$name && $contact && $user_id)
		{
			$query =  "INSERT INTO user_table (user_id,name,contact) VALUES ( '{$user_id}','{$name}','{$contact}')";
			//echo $query;
			mysqli_query($connection,$query);
		}
	 header("location:home.php?added=true");
	}
	else if ('edit'==$action)
	 {
	 	$id=$_POST['id'];
		$name=$_POST['name'];
	 	$contact=$_POST['contact'];
	 	if($name && $contact)
	 	{	
	 		$query = "UPDATE user_table SET name='{$name}', contact='{$contact}' WHERE id={$id}";

				mysqli_query($connection, $query);

	 	}
	  header("location:home.php");
		
	}

		else if ( 'adminRequest' == $action ) {
			$adminReqId = $_POST['taskid'];
			//echo $adminReqId;
			if ( $adminReqId ) {
				$query = "UPDATE user_table SET status=2 WHERE id='{$adminReqId}' LIMIT 1";
				mysqli_query( $connection, $query );
			}
			 header( 'Location: home.php' );
	}
	

	else if ( 'memberRequest' == $action ) {
			$memberReqId = $_POST['taskid'];
			//echo $memberReqId;
			if ( $memberReqId ) {
				$query = "UPDATE user_table SET status=3 WHERE id='{$memberReqId}' LIMIT 1";
				echo $query;
				mysqli_query( $connection, $query );
			}
		 header( 'Location: home.php' );
	}

}
