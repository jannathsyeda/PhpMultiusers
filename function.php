<?php 



function getStatus($statusCode=0)
{
	$status=[
		'1'=> 0,
		'2'=>"duplicate email",
		'3'=>"register successfully",
		'4'=>'email and password are empty',
		'5'=>'no data',
		'6'=>"didn't match"
	];

	return $status[$statusCode];
}


function getStatusIdForAction($sessionId){
	global $connection;
	$query = "SELECT status FROM user_table where id='{$sessionId}' LIMIT 1";
	$val = mysqli_query($connection,$query);
	$value = '';
	while($data = mysqli_fetch_assoc($val)){
		$value = $data['status'];
	}
	return $value;

}

function getStatusIdForStatusField($id){
	global $connection;
	$query = "SELECT status FROM user_table where id='{$id}' LIMIT 1";
	$val = mysqli_query($connection,$query);
	while($data = mysqli_fetch_assoc($val)){
		$value = $data['status'];
	}
	return $value;
}

?>